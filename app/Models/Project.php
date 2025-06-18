<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Project extends Model
{
    protected $guarded = [];

    protected $casts = [
        'next_update_date' => 'date',
        'last_update_date' => 'date',
        'contract_amount' => 'integer',
        'contract_status' => 'boolean',
        'status' => 'string',
        'upsells' => 'array',
        'marketing' => 'array',
    ];

    public function upsellCategories(): HasMany
    {
        return $this->hasMany(UpsellCategory::class);
    }

    public function upsells(): HasMany
    {
        return $this->hasMany(Upsell::class);
    }

    public function marketing(): HasMany
    {
        return $this->hasMany(Marketing::class);
    }
}
