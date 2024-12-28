<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    use HasFactory;


    public function parentInfo()
    {
        return $this->belongsTo(Permission::class,"parent");
    }

    protected function jalaliCreatedAt(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => jdate("Y/m/d H:i:s", strtotime($attributes['created_at'])),
        );
    }

    


}
