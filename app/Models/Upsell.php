<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Upsell extends Model
{
    protected $fillable = [
        'id',
        'project_id',
        'upsell_category_id',
        'description',
        'price',
        'status',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function upsellCategory(): BelongsTo
    {
        return $this->belongsTo(UpsellCategory::class);
    }
}
