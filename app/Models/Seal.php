<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seal extends Model
{
    protected $fillable = [
        'company_id',
        'seal_type',
        'seal_path',
    ];
}
