<?php
namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role as ModelsRole;

class TicketMessage extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ["ticket_id","creator_id","creator_type","replyer_id","message","ip","created_at","updated_at"];

    public function ticketMessagable()
    {
        return $this->morphTo("ticketMessagable","creator_type","creator_id");
    }

    public function ticketAttachments()
    {
        return $this->hasMany(TicketMessageAttachment::class);
    }

    protected function jalaliCreatedAt(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => jdate("Y/m/d H:i:s", strtotime($attributes['created_at'])),
        );
    }


}
