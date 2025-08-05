<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
     protected $guarded = [];
     /*   'invoice_id',
        'item_name',
        'quantity',
        'rate',
        'discount',
        'total',
    ]; */

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
