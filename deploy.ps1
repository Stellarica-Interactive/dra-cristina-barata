#Requires -Version 5.1
<#
.SYNOPSIS
Deploys public/ to dracristinabarata.pt over FTP. Windows counterpart of deploy.sh.

Uses WinSCP, which speaks explicit FTPS and reuses the control connection's TLS
session on the data channel -- something .NET's FtpWebRequest cannot do and which
most FTPS servers require.

Install once:  winget install -e --id WinSCP.WinSCP

.EXAMPLE
.\deploy.ps1
.EXAMPLE
.\deploy.ps1 -Force    # skip the confirmation prompt
#>
[CmdletBinding()]
param([switch] $Force)

$ErrorActionPreference = 'Stop'

function Get-DeploySecrets {
    <#
    .SYNOPSIS
    Parses the shell-style .deploy_secrets file into a hashtable.
    Same file deploy.sh `source`s, so credentials live in one place only.
    #>
    param([string] $Path = (Join-Path $PSScriptRoot '.deploy_secrets'))

    if (-not (Test-Path -LiteralPath $Path)) {
        throw "Missing $Path. Copy .deploy_secrets.example to .deploy_secrets and fill in your FTP details."
    }

    $secrets = @{}
    foreach ($line in (Get-Content -LiteralPath $Path -Encoding UTF8)) {
        $trimmed = $line.Trim()
        if ($trimmed -eq '' -or $trimmed.StartsWith('#')) { continue }

        $m = [regex]::Match($trimmed, '^(?:export\s+)?([A-Za-z_][A-Za-z0-9_]*)\s*=\s*(.*)$')
        if (-not $m.Success) { continue }

        $key = $m.Groups[1].Value
        $val = $m.Groups[2].Value.Trim()

        if ($val.Length -ge 2 -and $val.StartsWith("'") -and $val.EndsWith("'")) {
            # Single-quoted: literal, except the '\'' idiom for an embedded quote.
            $val = $val.Substring(1, $val.Length - 2).Replace("'\''", "'")
        }
        elseif ($val.Length -ge 2 -and $val.StartsWith('"') -and $val.EndsWith('"')) {
            $val = $val.Substring(1, $val.Length - 2)
        }
        else {
            # Unquoted: strip a trailing inline comment.
            $val = [regex]::Replace($val, '\s+#.*$', '')
        }

        $secrets[$key] = $val
    }
    return $secrets
}

function Get-RequiredSecret {
    param(
        [Parameter(Mandatory = $true)] [hashtable] $Secrets,
        [Parameter(Mandatory = $true)] [string] $Name
    )
    if (-not $Secrets.ContainsKey($Name) -or [string]::IsNullOrWhiteSpace($Secrets[$Name])) {
        throw "$Name is not set in .deploy_secrets."
    }
    $value = $Secrets[$Name]
    if ($value -in @('ftp.example.com', 'username', 'password')) {
        throw "$Name still holds the placeholder value '$value'. Put your real FTP details in .deploy_secrets."
    }
    return $value
}

function Resolve-WinScp {
    <# Locates winscp.com (the console build; winscp.exe is the GUI). #>
    $cmd = Get-Command -Name 'winscp.com' -CommandType Application -ErrorAction SilentlyContinue
    if ($cmd) { return $cmd.Source }

    $candidates = @(
        (Join-Path $env:ProgramFiles 'WinSCP\winscp.com')
        (Join-Path ${env:ProgramFiles(x86)} 'WinSCP\winscp.com')
        (Join-Path $env:LOCALAPPDATA 'Programs\WinSCP\winscp.com')
    )
    foreach ($c in $candidates) {
        if ($c -and (Test-Path -LiteralPath $c)) { return $c }
    }

    throw @'
WinSCP was not found. Install it once with:

    winget install -e --id WinSCP.WinSCP

(or download from https://winscp.net/ and make sure winscp.com is on PATH)
'@
}

$secrets = Get-DeploySecrets

$FtpHost  = Get-RequiredSecret $secrets 'FTP_HOST'
$User     = Get-RequiredSecret $secrets 'FTP_USER'
$Password = Get-RequiredSecret $secrets 'FTP_PASS'

# Explicit FTPS by default; set FTP_PROTOCOL only if the server has no TLS.
$Protocol = 'ftpes'
if ($secrets.ContainsKey('FTP_PROTOCOL') -and $secrets['FTP_PROTOCOL']) {
    $Protocol = $secrets['FTP_PROTOCOL']
}
if ($Protocol -notin @('ftpes', 'ftps', 'ftp')) {
    throw "FTP_PROTOCOL must be one of ftpes, ftps, ftp (got '$Protocol')."
}

# Only public/ is ever uploaded, so .deploy_secrets and the deploy scripts
# themselves cannot end up served from the website.
$LocalDir = 'public'
# '.' is the FTP login home directory, which is the site's document root.
$RemoteDir = '.'

# A host copied out of a URL may carry a scheme (e.g. 'ftp://1.2.3.4'), which
# lftp accepts but which would corrupt the URL built below. Strip it. The
# protocol stays whatever FTP_PROTOCOL says, so a stray 'ftp://' can never
# silently downgrade the connection to unencrypted.
$rawHost = $FtpHost
$FtpHost = [regex]::Replace($FtpHost, '^[A-Za-z][A-Za-z0-9+.-]*://', '').TrimEnd('/')
if ([string]::IsNullOrWhiteSpace($FtpHost)) {
    throw "FTP host '$rawHost' has no hostname in it."
}

$localPath = Join-Path $PSScriptRoot $LocalDir
if (-not (Test-Path -LiteralPath $localPath -PathType Container)) {
    throw "Local directory not found: $localPath"
}
$localPath = (Resolve-Path -LiteralPath $localPath).Path

Write-Host ''
Write-Host "Site      : dracristinabarata.pt"
Write-Host "Local     : $localPath"
Write-Host "Remote    : ${Protocol}://$FtpHost -> $RemoteDir"
Write-Host "Mode      : mirror with delete (remote files not present locally are REMOVED)"
Write-Host ''

if (-not $Force) {
    $answer = Read-Host 'Proceed? [y/N]'
    if ($answer -notmatch '^(y|yes)$') {
        Write-Host 'Aborted.'
        return
    }
}

# WinSCP escapes a literal " inside its own script strings by doubling it.
$esc = { param($s) $s -replace '"', '""' }
$userEnc = [uri]::EscapeDataString($User)
$passEnc = [uri]::EscapeDataString($Password)

$syncArgs = @('synchronize', 'remote', '-delete', '-mirror')
$syncArgs += ('"' + (& $esc $localPath) + '"')
$syncArgs += ('"' + (& $esc $RemoteDir) + '"')

$script = @(
    'option batch abort'
    'option confirm off'
    'option transfer binary'
    # -certificate=* accepts any TLS certificate, matching deploy.sh's
    # `set ssl:verify-certificate no`.
    "open ${Protocol}://${userEnc}:${passEnc}@${FtpHost}/ -certificate=* -passive=on"
    ($syncArgs -join ' ')
    'close'
    'exit'
)

# The password lives in this file, so keep it in the user-private temp dir
# and delete it as soon as WinSCP is done.
$winscp = Resolve-WinScp
$scriptFile = Join-Path $env:TEMP ("winscp-deploy-{0}.txt" -f [guid]::NewGuid())
try {
    Set-Content -LiteralPath $scriptFile -Value $script -Encoding UTF8
    # /ini=nul ignores any stored WinSCP configuration so deploys are reproducible.
    & $winscp /ini=nul /script="$scriptFile"
    $code = $LASTEXITCODE
    if ($code -ne 0) { throw "WinSCP exited with code $code -- deploy failed." }
    Write-Host ''
    Write-Host 'Deployed.'
}
finally {
    Remove-Item -LiteralPath $scriptFile -Force -ErrorAction SilentlyContinue
}
