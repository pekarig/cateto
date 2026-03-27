<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContentBlock extends Model
{
    protected $fillable = [
        'page_id',
        'key',
        'type',
        'content',
        'sort_order',
    ];

    /**
     * Get the page that owns the content block.
     */
    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }
}
