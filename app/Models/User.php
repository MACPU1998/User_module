<?php

namespace App\Models;

use App\Models\Admin\TicketMessage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $fillable
        = [
            'first_name',
            'last_name',
            'email',
            'password',
            'mobile',
            'avatar',
            'occupation',
            'status',
        ];

    //protected $hidden = ['password'];

    protected array $dates
        = [
            'created_at',
            'updated_at',
            'deleted_at',
        ];

    protected $casts = [

    ];

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => $attributes['first_name']." ".$attributes['last_name'],
        );
    }
    protected function jalaliCreatedAt(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => jdate("Y/m/d", strtotime($attributes['created_at'])),
        );
    }
    public function projects()
    {
        return $this->hasMany(UserProject::class);
    }
    public function  ticketMessages()
    {
        return $this->morphMany(TicketMessage::class,"ticketMessagable","creator_type","creator_id");
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(
            [
                'first_name',
                'last_name',
                'email',
                'mobile',
                'avatar',
                'occupation',
                'status'
            ]);
        // Chain fluent methods for configuration options
    }
}
