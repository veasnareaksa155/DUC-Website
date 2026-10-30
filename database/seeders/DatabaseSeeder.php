<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $isSeeded = Schema::hasTable('users') && DB::table('users')->count() > 0;
        $force = env('FORCE_SEED', false) === true || env('FORCE_SEED', 'false') === 'true';

        if ($isSeeded && !$force) {
            if ($this->command) {
                $this->command->info('Database already contains data. Skipping seeding.');
            }
            return;
        }

        // 1. Clean existing records in child-to-parent order to prevent foreign key constraint violations
        if (Schema::hasTable('activity_logs')) {
            DB::table('activity_logs')->delete();
        }
        if (Schema::hasTable('navigation_items')) {
            DB::table('navigation_items')->update(['parent_id' => null]);
            DB::table('navigation_items')->delete();
        }
        if (Schema::hasTable('events')) {
            DB::table('events')->delete();
        }
        if (Schema::hasTable('departments')) {
            DB::table('departments')->delete();
        }
        if (Schema::hasTable('faculties')) {
            DB::table('faculties')->delete();
        }
        if (Schema::hasTable('page_contents')) {
            DB::table('page_contents')->delete();
        }
        if (Schema::hasTable('settings')) {
            DB::table('settings')->delete();
        }
        if (Schema::hasTable('translations')) {
            DB::table('translations')->delete();
        }
        if (Schema::hasTable('users')) {
            DB::table('users')->delete();
        }

        // 2. Call seeders in parent-to-child order
        $this->call([
            UsersTableSeeder::class,
            SettingsTableSeeder::class,
            TranslationsTableSeeder::class,
            PageContentsTableSeeder::class,
            FacultiesTableSeeder::class,
            DepartmentsTableSeeder::class,
            NavigationItemsTableSeeder::class,
            EventsTableSeeder::class,
            ActivityLogsTableSeeder::class,
        ]);

        // 3. For PostgreSQL: update sequence values to max ID so subsequent insertions via web UI do not violate primary keys
        if (DB::connection()->getDriverName() === 'pgsql') {
            $tables = [
                'users',
                'settings',
                'translations',
                'page_contents',
                'faculties',
                'departments',
                'navigation_items',
                'events',
                'activity_logs',
            ];
            foreach ($tables as $table) {
                if (Schema::hasTable($table)) {
                    DB::statement("SELECT setval(pg_get_serial_sequence('{$table}', 'id'), coalesce(max(id), 0) + 1, false) FROM \"{$table}\";");
                }
            }
        }
    }
}
