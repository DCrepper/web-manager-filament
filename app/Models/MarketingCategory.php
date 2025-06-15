<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class MarketingCategory extends Model
{
    protected $fillable = [
        'name',
    ];

    public function marketing(): HasMany
    {
        return $this->hasMany(Marketing::class);
    }
}
