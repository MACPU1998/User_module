<?php

namespace App\Models\Admin;

use App\Enums\AdminStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasFactory,HasRoles,LogsActivity;
    protected $guard = 'admin';

    protected $fillable=["first_name","last_name","email","phone","password","image","status","created_at","updated_at"];

    protected $casts = [
      "status" => AdminStatus::class,
    ];

    public function before(Admin $user, string $ability): bool|null
    {

        if ($user->hasRole('super admin')) {
            return true;
        }

        return null; // see the note above in Gate::before about why null must be returned here.
    }

    protected function jalaliCreatedAt(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => jdate("Y/m/d H:i:s", strtotime($attributes['created_at'])),
        );
    }

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => $attributes['first_name']." ".$attributes['last_name'],
        );
    }

    public function  tickets()
    {
        return $this->morphMany(Ticket::class,"ticketable","creator_type","creator_id");
    }
    public function  ticketMessages()
    {
        return $this->morphMany(TicketMessage::class,"ticketMessagable","creator_type","creator_id");
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class,"admin_departments");
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(["first_name","last_name","email","phone","password","image","status","created_at","updated_at"]);
        // Chain fluent methods for configuration options
    }
}
