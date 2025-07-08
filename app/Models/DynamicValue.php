<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DynamicValue extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function dynamicRow(): BelongsTo
    {
        return $this->belongsTo(DynamicRow::class);
    }

    public function dynamicColumn(): BelongsTo
    {
        return $this->belongsTo(DynamicColumn::class);
    }
}
