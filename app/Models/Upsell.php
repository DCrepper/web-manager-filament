<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class Upsell extends Model
{
    protected $fillable = [
        'id',
        'project_id',
        'category_id',
        'description',
        'price',
        'status',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function upsellCategory()
    {
        return $this->belongsTo(UpsellCategory::class);
    }
}
