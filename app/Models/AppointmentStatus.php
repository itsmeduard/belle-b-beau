<?php
namespace App\Models;
use Illuminate\Database\Eloquent\{Model,Factories\HasFactory};
class AppointmentStatus extends Model
{
    use HasFactory;
    protected $table="appointment_status";
    protected $fillable = [
        'appt_id',
        'status',
    ];
    public $timestamps = false;
}
