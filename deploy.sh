#!/usr/bin/env bash
# Deploys public/ to dracristinabarata.pt over FTP (lftp -- macOS/Linux).
# Windows counterpart: deploy.ps1
set -e

cd "$(dirname "$0")"

if [ ! -f .deploy_secrets ]; then
    echo "Missing .deploy_secrets. Copy .deploy_secrets.example to .deploy_secrets and fill in your FTP details." >&2
    exit 1
fi

source .deploy_secrets

for var in FTP_HOST FTP_USER FTP_PASS; do
    if [ -z "${!var}" ]; then
        echo "$var is not set in .deploy_secrets." >&2
        exit 1
    fi
done

LOCAL_DIR="public"
# '.' is the FTP login home directory, which is the site's document root.
REMOTE_DIR="."

echo
echo "Local  : $LOCAL_DIR"
echo "Remote : $FTP_HOST -> $REMOTE_DIR"
echo "Mode   : mirror with delete (remote files not present locally are REMOVED)"
echo

lftp -u "$FTP_USER","$FTP_PASS" "$FTP_HOST" << CMD

set ftp:ssl-allow true
set ssl:verify-certificate no

# Mirror local -> remote
mirror -R --delete --verbose "$LOCAL_DIR" "$REMOTE_DIR"
bye
CMD
