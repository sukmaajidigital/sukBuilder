<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DynamicColumn extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $casts = ['validation_rules' => 'array'];

    public function dynamicTable(): BelongsTo
    {
        return $this->belongsTo(DynamicTable::class);
    }
}
