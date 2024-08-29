<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resignation extends Model
{
    use HasFactory;
    protected $fillable = [
        'resignation_effect_date',
        'resignation_file',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
