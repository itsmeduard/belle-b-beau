<?php
namespace App\Models;
use Illuminate\Database\Eloquent\{Model, Factories\HasFactory, SoftDeletes};
class Employee extends Model
{
    use HasFactory,SoftDeletes;
    protected $table="employees";
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'address',
        'photo',
        'status'
    ];
    public $timestamps = true;
}
