# ============================================================
# fix-repo.ps1  (Windows PowerShell version)
# Run this ONCE inside your project folder to:
#   1. Remove .env and vendor/ from Git tracking
#   2. Rotate the compromised APP_KEY
#   3. Apply all fixed files from the patch
# ============================================================

Write-Host ""
Write-Host "===== Maison Mode — Repository Security Fix =====" -ForegroundColor Cyan
Write-Host ""

# Step 1: Remove .env from Git tracking
Write-Host "[1/5] Removing .env from Git tracking..." -ForegroundColor Yellow
git rm --cached .env 2>$null
if ($LASTEXITCODE -eq 0) { Write-Host "  OK .env untracked" -ForegroundColor Green }
else { Write-Host "  INFO .env was not tracked" }

# Step 2: Remove vendor/ from Git tracking
Write-Host "[2/5] Removing vendor/ from Git tracking..." -ForegroundColor Yellow
git rm -r --cached vendor/ 2>$null
if ($LASTEXITCODE -eq 0) { Write-Host "  OK vendor/ untracked" -ForegroundColor Green }
else { Write-Host "  INFO vendor/ was not tracked" }

# Step 3: Generate new APP_KEY
Write-Host "[3/5] Rotating APP_KEY (old one was public!)..." -ForegroundColor Yellow
php artisan key:generate --force
Write-Host "  OK New APP_KEY written to .env" -ForegroundColor Green

# Step 4: Clear caches
Write-Host "[4/5] Clearing caches..." -ForegroundColor Yellow
php artisan config:clear
php artisan view:clear
php artisan route:clear
Write-Host "  OK Caches cleared" -ForegroundColor Green

# Step 5: Instructions
Write-Host ""
Write-Host "[5/5] Now commit all the fixes:" -ForegroundColor Yellow
Write-Host ""
Write-Host '  git add .gitignore .env.example README.md bootstrap/ public/ routes/console.php storage/ tests/ phpunit.xml' -ForegroundColor White
Write-Host '  git commit -m "fix: security, missing files, tests, correct DB name"' -ForegroundColor White
Write-Host '  git push origin main' -ForegroundColor White
Write-Host ""
Write-Host "===== Done! =====" -ForegroundColor Cyan
Write-Host ""
Write-Host "WARNING: The old APP_KEY was visible on GitHub." -ForegroundColor Red
Write-Host "A new key has been generated. All active sessions are now invalid." -ForegroundColor Red
Write-Host "This is correct and expected behaviour." -ForegroundColor Red
Write-Host ""
