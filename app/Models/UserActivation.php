<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserActivation extends Model
{
    protected $fillable = [
        'user_id',
        'mobile',
        'code',
        'hashcode',
        'status',
        'used_at',
        'expired_at',
        'created_at',
    ];

    protected array $dates = [
        'used_at',
        'expired_at',
        'created_at',
    ];

    protected function jalaliCreatedAt(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => jdate("Y/m/d H:i:s", strtotime($attributes['created_at'])),
        );
    }

//    public function user(): BelongsTo
//    {
//        return $this->belongsTo(User::class);
//    }
}
