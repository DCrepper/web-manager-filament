<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class UpsellCategory extends Model
{
    protected $guarded = [];

    public function upsells()
    {
        return $this->hasMany(Upsell::class);
    }
}
