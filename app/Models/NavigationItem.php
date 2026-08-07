<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NavigationItem extends Model
{
    protected $guarded = [];

    protected $casts = [
        'label' => 'array',
    ];

    public function parent()
    {
        return $this->belongsTo(NavigationItem::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(NavigationItem::class, 'parent_id')->orderBy('order');
    }

    public static function getTree()
    {
        $items = self::whereNull('parent_id')->with('children.children')->orderBy('order')->get();
        return $items->unique(function ($item) {
            $label = is_array($item->label) ? json_encode($item->label) : (string)($item->label ?? '');
            return strtolower(trim($label)) . '_' . strtolower(trim($item->href ?? ''));
        })->values();
    }
}
