<?php

/**
 * Hostinger Web Setup & Deployment Helper for Laravel
 * 
 * IMPORTANT: CHANGE THE SECRET KEY BELOW BEFORE UPLOADING!
 * Delete or disable this file after completing your initial setup for security.
 */

define('SECRET_KEY', 'hostinger_duc_setup_2026'); // Change this secret key!

$providedKey = $_GET['key'] ?? '';

if ($providedKey !== SECRET_KEY) {
    http_response_code(403);
    echo '<!DOCTYPE html><html><head><title>Access Denied</title><style>body{font-family:sans-serif;background:#0f172a;color:#f8fafc;display:flex;justify-content:center;align-items:center;height:100vh;margin:0;}.card{background:#1e293b;padding:2rem;border-radius:0.75rem;box-shadow:0 10px 15px -3px rgba(0,0,0,0.5);text-align:center;max-width:400px;}h1{color:#ef4444;font-size:1.5rem;}code{background:#334155;padding:0.2rem 0.4rem;border-radius:0.25rem;font-family:monospace;}</style></head><body>';
    echo '<div class="card"><h1>403 Forbidden</h1><p>Invalid or missing secret key.</p><p>Pass <code>?key=YOUR_SECRET_KEY</code> in the URL.</p></div>';
    echo '</body></html>';
    exit;
}

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Artisan;

$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

$action = $_GET['action'] ?? 'status';
$output = '';

try {
    switch ($action) {
        case 'storage-link':
            $target = public_path('storage');
            // Unlink existing broken symlink or file if present
            if (is_link($target) || file_exists($target)) {
                if (is_dir($target) && !is_link($target)) {
                    $output .= "Note: public/storage is a directory.\n";
                } else {
                    @unlink($target);
                    $output .= "Removed old storage link/file.\n";
                }
            }
            try {
                Artisan::call('storage:link');
                $output .= Artisan::output() ?: "Storage symlink created successfully!\n";
            } catch (\Throwable $e) {
                $output .= "Symlink failed: " . $e->getMessage() . "\nTrying php symlink fallback...\n";
                $targetDir = storage_path('app/public');
                if (@symlink($targetDir, $target)) {
                    $output .= "Direct PHP symlink succeeded!\n";
                } else {
                    $output .= "PHP symlink failed. Consider setting FILESYSTEM_PUBLIC_ROOT=public/storage in .env\n";
                }
            }
            break;

        case 'direct-storage':
            $target = public_path('storage');
            if (is_link($target)) {
                @unlink($target);
            }
            if (!file_exists($target)) {
                mkdir($target, 0775, true);
            }
            $output = "Created direct public/storage directory!\nAdd 'FILESYSTEM_PUBLIC_ROOT=public/storage' to your .env file and run Clear Cache.";
            break;

        case 'migrate':
            Artisan::call('migrate', ['--force' => true]);
            $output = Artisan::output() ?: "Database migrations executed successfully!";
            break;

        case 'seed':
            Artisan::call('db:seed', ['--force' => true]);
            Artisan::call('cache:clear');
            Artisan::call('optimize:clear');
            $output = Artisan::output() ?: "Database seeders executed successfully! Cache cleared.";
            break;

        case 'fresh-seed':
            Artisan::call('migrate:fresh', ['--seed' => true, '--force' => true]);
            Artisan::call('cache:clear');
            Artisan::call('optimize:clear');
            $output = "Database reset, freshly seeded, and caches cleared successfully!\n" . Artisan::output();
            break;

        case 'optimize':
            Artisan::call('config:cache');
            Artisan::call('route:cache');
            Artisan::call('view:cache');
            $output = "Application caches generated successfully!\n" . Artisan::output();
            break;

        case 'clear':
            Artisan::call('optimize:clear');
            Artisan::call('cache:clear');
            $output = "All application & database caches cleared successfully!\n" . Artisan::output();
            break;

        case 'key-generate':
            Artisan::call('key:generate', ['--force' => true]);
            $output = Artisan::output() ?: "App key generated successfully!";
            break;

        default:
            $symlinkStatus = is_link(public_path('storage')) ? 'Valid Link' : (file_exists(public_path('storage')) ? 'Directory exists' : 'Missing');
            $output = "System Status:\nPHP Version: " . PHP_VERSION . "\nLaravel Version: " . $app->version() . "\nEnvironment: " . app()->environment() . "\nStorage Link Status: " . $symlinkStatus . "\nDefault Disk: " . config('filesystems.default') . "\nPublic Disk Root: " . config('filesystems.disks.public.root') . "\nAWS Region: " . config('filesystems.disks.s3.region', 'N/A');
            break;
    }
} catch (Exception $e) {
    $output = "ERROR: " . $e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hostinger Setup Helper - DUC Website</title>
    <style>
        body { font-family: system-ui, -apple-system, sans-serif; background: #0f172a; color: #f8fafc; margin: 0; padding: 2rem; }
        .container { max-width: 800px; margin: 0 auto; background: #1e293b; border-radius: 1rem; padding: 2rem; border: 1px solid #334155; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.5); }
        h1 { color: #38bdf8; margin-top: 0; display: flex; align-items: center; gap: 0.5rem; }
        .alert { background: #7c2d12; color: #fdba74; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; border-left: 4px solid #f97316; }
        .btn-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.5rem; }
        .btn { display: inline-block; padding: 0.75rem 1rem; background: #0284c7; color: white; text-decoration: none; border-radius: 0.5rem; font-weight: 600; text-align: center; transition: background 0.2s; }
        .btn:hover { background: #0369a1; }
        .btn-secondary { background: #475569; }
        .btn-secondary:hover { background: #334155; }
        .btn-warning { background: #d97706; }
        .btn-warning:hover { background: #b45309; }
        .btn-danger { background: #dc2626; }
        .btn-danger:hover { background: #b91c1c; }
        pre { background: #090d16; padding: 1.25rem; border-radius: 0.5rem; color: #4ade80; overflow-x: auto; font-size: 0.9rem; border: 1px solid #1e293b; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🚀 Hostinger Setup Helper</h1>
        
        <div class="alert">
            <strong>⚠️ Security Reminder:</strong> Delete or disable this file (<code>public/hostinger-setup.php</code>) after finishing your website deployment!
        </div>

        <h3>Quick Actions</h3>
        <div class="btn-grid">
            <a class="btn" href="?key=<?= SECRET_KEY ?>&action=storage-link">1. Recreate Storage Link</a>
            <a class="btn btn-secondary" href="?key=<?= SECRET_KEY ?>&action=direct-storage">Create Direct Storage Folder</a>
            <a class="btn" href="?key=<?= SECRET_KEY ?>&action=migrate">2. Run Migrations</a>
            <a class="btn btn-warning" href="?key=<?= SECRET_KEY ?>&action=seed">3. Seed Database & Clear Cache</a>
            <a class="btn btn-danger" href="?key=<?= SECRET_KEY ?>&action=fresh-seed" onclick="return confirm('Wipe database and fresh seed?')">4. Fresh Seed (Wipe & Re-seed)</a>
            <a class="btn" href="?key=<?= SECRET_KEY ?>&action=optimize">5. Cache App & Routes</a>
            <a class="btn btn-secondary" href="?key=<?= SECRET_KEY ?>&action=clear">Clear All Caches</a>
            <a class="btn btn-secondary" href="?key=<?= SECRET_KEY ?>&action=status">Check Status</a>
        </div>

        <h3>Output Console</h3>
        <pre><?= htmlspecialchars($output) ?></pre>
    </div>
</body>
</html>
