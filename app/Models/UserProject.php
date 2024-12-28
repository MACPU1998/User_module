<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class UserProject extends Model
{
    use SoftDeletes,LogsActivity;

    protected $primaryKey = 'id';
    protected $fillable
        = [
            'user_id',
            'client_first_name',
            'client_last_name',
            'client_national_code',
            'client_phone',
            'client_address',
            'client_zipcode',
            'client_province_id',
            'client_city_id',
            'picture1',
            'picture2',
            'picture3',
            'picture4',
            'picture5',
            'description',
            'status',
            'sale_partner_name',
            'title',
            'code',
            'credit',
            'comment'
        ];

    protected array $dates
        = [
            'created_at',
            'updated_at',
            'deleted_at',
        ];

    protected $casts = [
      "client_city_id" => "int",
      "client_province_id" => "int",
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $appends = [
        'city_name',
        'province_name'
    ];

    public function getCityNameAttribute(): ?string
    {
        return $this->city()->value('name');
    }
//    public function getPicture1Attribute($value){
//        return Storage::response("userprojects/pictures/".$value);
//    }

protected function jalaliCreatedAt(): Attribute
{
    return Attribute::make(
        get: fn (mixed $value, array $attributes) => jdate("Y/m/d", strtotime($attributes['created_at'])),
    );
}

    /**
     * @return object|null
     */
    public function getProvinceNameAttribute(): ?string
    {
        return $this->province()->value('name');
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class,"client_province_id","id");
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class,"client_city_id","id");
    }

    public function items()
    {
        return $this->hasMany(UserProjectItem::class,"user_project_id","id");
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['user_id',
        'client_first_name',
        'client_last_name',
        'client_national_code',
        'client_phone',
        'client_address',
        'client_zipcode',
        'client_province_id',
        'client_city_id',
        'picture1',
        'picture2',
        'picture3',
        'picture4',
        'picture5',
        'description',
        'status',
        'sale_partner_name',
        'title',
        'code',
        'credit',
        'comment']);
        // Chain fluent methods for configuration options
    }


}
