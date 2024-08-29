<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ctp extends Model
{
    use HasFactory;
    protected $fillable = [
        'base',
        'pli',
        'ca',
        'ma',
        'other_allowance',
        'total_ctp',
        'ctp_effect_date',
        'file',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
