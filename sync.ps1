# ProGuidePh Automation Script: Sync & Push to GitHub
# Usage: .\sync.ps1 "Commit Message"

param (
    [string]$CommitMessage = "Auto-sync: $((Get-Date).ToString('yyyy-MM-dd HH:mm:ss'))"
)

Write-Host "--- Starting Sync Process ---" -ForegroundColor Cyan

# 1. Run NPM Build
Write-Host "[1/3] Building assets..." -ForegroundColor Yellow
npm run build
if ($LASTEXITCODE -ne 0) {
    Write-Host "Build failed! Aborting sync." -ForegroundColor Red
    exit $LASTEXITCODE
}

# 2. Add and Commit
Write-Host "[2/3] Committing changes..." -ForegroundColor Yellow
git add .
git commit -m $CommitMessage

# 3. Push to GitHub
Write-Host "[3/3] Pushing to GitHub..." -ForegroundColor Yellow
git push origin main
if ($LASTEXITCODE -ne 0) {
    Write-Host "Push failed!" -ForegroundColor Red
    exit $LASTEXITCODE
}

Write-Host "--- Sync Complete! ---" -ForegroundColor Green
