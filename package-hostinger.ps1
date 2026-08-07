# package-hostinger.ps1
# Automated build & packaging script for Hostinger deployment

Write-Host "==================================================" -ForegroundColor Cyan
Write-Host "  Building & Packaging DUC Website for Hostinger  " -ForegroundColor Cyan
Write-Host "==================================================" -ForegroundColor Cyan

# Step 1: Run npm run build
Write-Host "`n[1/3] Compiling Vue 3 / Vite frontend assets..." -ForegroundColor Yellow
npm run build
if ($LASTEXITCODE -ne 0) {
    Write-Host "Error compiling frontend assets with Vite!" -ForegroundColor Red
    exit 1
}

$zipFile = "duc-website-hostinger.zip"
if (Test-Path $zipFile) { Remove-Item $zipFile -Force }

# Remove local public/storage symlink if present to prevent tar stat errors on Windows
if (Test-Path "public\storage") {
    cmd /c rmdir "public\storage" 2>$null
}

Write-Host "`n[2/3] Archiving project files into $zipFile..." -ForegroundColor Yellow

# Use bsdtar to create the zip archive directly
tar -a -cf $zipFile `
    --exclude=".git" `
    --exclude="node_modules" `
    --exclude="storage/logs/*.log" `
    --exclude=".env" `
    --exclude="duc-website-hostinger.zip" `
    app bootstrap config database public resources routes storage vendor .htaccess .env.hostinger.example artisan composer.json composer.lock package.json HOSTINGER_DEPLOYMENT_GUIDE.md

# Re-link local storage link after packaging
php artisan storage:link --quiet

Write-Host "`n[3/3] Package created successfully!" -ForegroundColor Green
Write-Host "Zip Archive: $zipFile" -ForegroundColor Cyan
$size = (Get-Item $zipFile).Length / 1MB
Write-Host ("Archive Size: {0:N2} MB" -f $size) -ForegroundColor Green
Write-Host "`nReady for upload to Hostinger public_html!" -ForegroundColor Yellow
