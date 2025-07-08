<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DynamicRow extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function dynamicTable(): BelongsTo
    {
        return $this->belongsTo(DynamicTable::class);
    }

    public function values(): HasMany
    {
        return $this->hasMany(DynamicValue::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
