<?php
namespace App\Models;
use Illuminate\Database\Eloquent\{Model,Factories\HasFactory};
class Employee extends Model
{
    use HasFactory;
    protected $table="employees";
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'address',
        'photos'
    ];
    public $timestamps = true;
}
