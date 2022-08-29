<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $table = 'invoices';

    protected $fillable = ['invoice_id', 'invoice_date', 'serie', 'folio', 'paymentTerms', 'paymentMethod', 'expeditionPlace', 'currency', 'fiscalRegime', 'rfc', 'productCode', 'unitCode', 'quantity', 'unit', 'description', 'unitValue', 'subtotal', 'discount', 'total'];
}
