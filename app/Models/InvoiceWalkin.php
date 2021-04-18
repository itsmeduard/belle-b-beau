<?php
namespace App\Models;
use Illuminate\Database\Eloquent\{Model,Factories\HasFactory};
class InvoiceWalkin extends Model
{
    use HasFactory;
    protected $table='invoice_walkin';
    protected $fillable = [
        'invoice_number',
        'detail_id',
        'total',
        'created_at'
    ];
    public $timestamps = false;
}
