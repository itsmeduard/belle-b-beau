<?php
namespace App\Models;
use Illuminate\Database\Eloquent\{Model,Factories\HasFactory};
class Walkin extends Model
{
    use HasFactory;
    protected $table='walkin';
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'service',
        'schedule',
        'note',
        'created_at'
    ];
    public $timestamps = false;
}
