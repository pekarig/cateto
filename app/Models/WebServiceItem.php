<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WebServiceItem extends Model
{
    protected $fillable = [
        'page_id',
        'tagline',
        'icon_path',
        'heading',
        'description',
        'features',
        'sort_order',
    ];

    protected $casts = [
        'features' => 'array',
    ];

    /**
     * Get the page that owns the service item.
     */
    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }
}
