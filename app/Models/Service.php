<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model,SoftDeletes};
class Service extends Model
{
    use HasFactory,SoftDeletes;
    protected $table="services";
    protected $fillable = [
        'service',
        'category',
        'price',
        'status'
    ];
    public $timestamps = true;
}
