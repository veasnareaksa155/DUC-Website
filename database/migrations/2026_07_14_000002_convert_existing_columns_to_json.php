<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Navigation Items: label
        $this->convertTableColumns('navigation_items', ['label']);

        // 2. Page Contents: title, content
        // For page content, since it's already a JSON structure (like rector text paragraphs, history, etc.),
        // we wrap the whole structure: {"en": {old JSON}, "km": {empty copy of structure / empty keys}}
        $this->convertPageContents();

        // 3. Events: title, description, content
        $this->convertTableColumns('events', ['title', 'description', 'content']);

        // 4. Faculties: name, mission, vision, goals
        $this->convertTableColumns('faculties', ['name', 'mission', 'vision', 'goals']);

        // 5. Departments: name, description, mission, vision, goals
        $this->convertTableColumns('departments', ['name', 'description', 'mission', 'vision', 'goals']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reversing is not strictly necessary for this structural migration,
        // but we can leave it empty to prevent data loss on rollback.
    }

    /**
     * Helper to convert normal text columns in a table to {"en": "val", "km": ""} JSON format.
     */
    private function convertTableColumns(string $table, array $columns): void
    {
        if (!Schema::hasTable($table)) {
            return;
        }

        $records = DB::table($table)->get();

        foreach ($records as $record) {
            $updates = [];
            foreach ($columns as $column) {
                $val = $record->$column;
                if ($val !== null && !empty($val)) {
                    // Check if already valid JSON
                    $decoded = json_decode($val, true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                        continue;
                    }
                    // Not JSON, format it
                    $updates[$column] = json_encode([
                        'en' => $val,
                        'km' => ''
                    ], JSON_UNESCAPED_UNICODE);
                }
            }

            if (!empty($updates)) {
                DB::table($table)->where('id', $record->id)->update($updates);
            }
        }
    }

    /**
     * Helper to wrap page content JSON into {"en": {...}, "km": {...}} JSON format.
     */
    private function convertPageContents(): void
    {
        if (!Schema::hasTable('page_contents')) {
            return;
        }

        $pages = DB::table('page_contents')->get();

        foreach ($pages as $page) {
            $updates = [];
            
            // Convert title
            $title = $page->title;
            if ($title !== null && !empty($title)) {
                $decodedTitle = json_decode($title, true);
                if (json_last_error() !== JSON_ERROR_NONE || !is_array($decodedTitle)) {
                    $updates['title'] = json_encode([
                        'en' => $title,
                        'km' => ''
                    ], JSON_UNESCAPED_UNICODE);
                }
            }

            // Convert content
            $content = $page->content;
            if ($content !== null && !empty($content)) {
                $decodedContent = json_decode($content, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decodedContent)) {
                    // Check if it's already wrapped in en/km
                    if (!isset($decodedContent['en']) && !isset($decodedContent['km'])) {
                        // Create an empty template copy for Khmer
                        $kmTemplate = $this->createEmptyTemplate($decodedContent);
                        
                        $updates['content'] = json_encode([
                            'en' => $decodedContent,
                            'km' => $kmTemplate
                        ], JSON_UNESCAPED_UNICODE);
                    }
                }
            }

            if (!empty($updates)) {
                DB::table('page_contents')->where('id', $page->id)->update($updates);
            }
        }
    }

    /**
     * Recursively clone a structure, clearing string values to make a blank Khmer template.
     */
    private function createEmptyTemplate(mixed $data): mixed
    {
        if (is_array($data)) {
            $cloned = [];
            foreach ($data as $key => $val) {
                $cloned[$key] = $this->createEmptyTemplate($val);
            }
            return $cloned;
        }
        if (is_string($data)) {
            return '';
        }
        return $data;
    }
};
