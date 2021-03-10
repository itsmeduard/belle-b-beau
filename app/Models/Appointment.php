<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $table="appointment";

    protected $fillable = [
        'name',
        'email',
        'phone',
        'service',
        'schedule',
        'esthetician',
        'note',
        'ipAddress',
        'created_at',
    ];

    public $timestamps = false;
}
