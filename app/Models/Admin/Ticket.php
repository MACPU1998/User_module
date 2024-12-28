<?php
namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ["code","creator_id","creator_type","title","status","ticket_category_id","department_id","created_at","updated_at"];



    protected function jalaliCreatedAt(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => jdate("Y/m/d H:i:s", strtotime($attributes['created_at'])),
        );
    }

    public function ticketCategory()
    {
        return $this->belongsTo(TicketCategory::class,"ticket_category_id");
    }


    public function ticketable()
    {
        return $this->morphTo("ticketable","creator_type","creator_id");
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

}
