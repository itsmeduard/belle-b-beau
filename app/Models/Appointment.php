<?php
namespace App\Models;
use Illuminate\Database\Eloquent\{Model,Factories\HasFactory};
class Appointment extends Model
{
    use HasFactory;
    protected $table="appointments";
    protected $fillable = [
        'name',
        'email',
        'phone',
        'service',
        'schedule',
        'note',
        'ipAddress',
        'created_at',
    ];
    public $timestamps = false;
}
