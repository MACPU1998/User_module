<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        "slug",
        "key",
        "value",
        "type",
    ];

    protected array $dates
        = [
            'created_at',
            'updated_at',
        ];
}
