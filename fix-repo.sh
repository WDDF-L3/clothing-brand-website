#!/bin/bash
# ============================================================
# fix-repo.sh
# Run this ONCE inside your project folder to:
#   1. Remove .env and vendor/ from Git tracking
#   2. Rotate the compromised APP_KEY
#   3. Apply all fixed files from the patch
# ============================================================

echo ""
echo "===== Maison Mode — Repository Security Fix ====="
echo ""

# Step 1: Remove .env from Git tracking (stop tracking it, keep the file)
echo "[1/5] Removing .env from Git tracking..."
git rm --cached .env 2>/dev/null && echo "  ✓ .env untracked" || echo "  ℹ .env was not tracked"

# Step 2: Remove vendor/ from Git tracking
echo "[2/5] Removing vendor/ from Git tracking..."
git rm -r --cached vendor/ 2>/dev/null && echo "  ✓ vendor/ untracked" || echo "  ℹ vendor/ was not tracked"

# Step 3: Generate a new APP_KEY (old one is compromised since it was public)
echo "[3/5] Rotating APP_KEY..."
php artisan key:generate --force
echo "  ✓ New APP_KEY generated in .env"

# Step 4: Make storage and bootstrap/cache writable
echo "[4/5] Setting directory permissions..."
chmod -R 775 storage bootstrap/cache 2>/dev/null && echo "  ✓ Permissions set" || echo "  ℹ Could not set permissions (Windows — that's ok)"

# Step 5: Clear all caches
echo "[5/5] Clearing caches..."
php artisan config:clear
php artisan view:clear
php artisan route:clear
echo "  ✓ Caches cleared"

echo ""
echo "===== Now commit the fixes ====="
echo ""
echo "  Run these commands:"
echo ""
echo "  git add .gitignore .env.example README.md bootstrap/ public/ routes/console.php storage/ tests/ phpunit.xml"
echo "  git commit -m 'fix: remove .env and vendor from tracking, add missing core files, add tests'"
echo "  git push origin main"
echo ""
echo "===== Done! ====="
echo ""
echo "⚠️  IMPORTANT: The old APP_KEY was public. Sessions signed with"
echo "   the old key are now invalid. All users will be logged out."
echo "   This is expected and correct behaviour."
echo ""
