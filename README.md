# dra-cristina-barata

Website for [dracristinabarata.pt](https://dracristinabarata.pt) — Dra. Cristina Barata,
psicóloga clínica (PsicoAngola). Plain PHP, no build step, no database.

## Layout

```
public/            everything served by the web server (this is the document root)
  index.php        front controller: routes /<page> to pages/<page>.php
  location_util.php  visitor country lookup, used for PT/international content
  pages/           one file per page (quem_sou, consultas, psicoangola, media, feedback, international)
  css/  font/  img/
  .htaccess        rewrites every non-file request to index.php
  robots.txt  sitemap.xml
deploy.sh          deploy public/ over FTP (macOS/Linux, lftp)
deploy.ps1         deploy public/ over FTP (Windows, WinSCP)
.deploy_secrets.example  template for the FTP credentials
```

Only `public/` is uploaded, so the deploy scripts and your credentials can never
be served from the website.

## Running locally

Any PHP 7.4+ install will do — the built-in server is enough:

```sh
php -S localhost:8000 -t public public/index.php
```

Routing goes through `index.php`, so passing it as the router script makes
`http://localhost:8000/consultas` work the same way `.htaccess` does in production.

## Deploying

### 1. Set up credentials (once)

FTP credentials are **never committed**. `.deploy_secrets` is in `.gitignore`;
this is a public repository, so keep it that way.

```sh
cp .deploy_secrets.example .deploy_secrets
```

Then edit `.deploy_secrets` and fill in the real values:

| Variable       | Meaning                                                           |
| -------------- | ----------------------------------------------------------------- |
| `FTP_HOST`     | FTP hostname, optionally `host:port` (e.g. `ftp.example.com:21`)  |
| `FTP_USER`     | FTP username                                                      |
| `FTP_PASS`     | FTP password                                                      |
| `FTP_PROTOCOL` | optional, `deploy.ps1` only — `ftpes` (default), `ftps`, or `ftp` |

Notes:

- The file is shell syntax, `source`d by `deploy.sh` and parsed by `deploy.ps1`,
  so both scripts read the same credentials.
- Keep the single quotes around values. Single-quoted strings are literal in
  bash, so a password containing `$`, `` ` ``, `"` or `\` needs no escaping.
  For a literal `'`, write `'\''`.
- The scripts refuse to run while a value is still the placeholder
  (`ftp.example.com`, `username`, `password`).
- Credentials for this site are shared privately — ask the site owner. Nothing
  in this repository grants access to the server.

### 2. Deploy

macOS/Linux (needs [lftp](https://lftp.yar.tk/)):

```sh
./deploy.sh
```

Windows (needs [WinSCP](https://winscp.net/): `winget install -e --id WinSCP.WinSCP`):

```powershell
.\deploy.ps1          # prompts for confirmation
.\deploy.ps1 -Force   # no prompt
```

Both mirror `public/` onto the FTP login home directory **with deletion** —
remote files that do not exist locally are removed. Both connect over FTP with
TLS and do not verify the server certificate, matching the host's setup.
