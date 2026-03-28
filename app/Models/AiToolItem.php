<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AiToolItem extends Model
{
    protected $fillable = [
        'page_id',
        'icon_path',
        'name',
        'description',
        'button_text',
        'button_url',
        'button_target_blank',
        'sort_order',
    ];

    protected $casts = [
        'button_target_blank' => 'boolean',
    ];

    /**
     * Get the page that owns the AI tool item.
     */
    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }
}
