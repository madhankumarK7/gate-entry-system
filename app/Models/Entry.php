<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Entry extends Model
{
    use HasFactory;
    protected $fillable = [
        'visitor_id',
        'gate_id',
        'entry_time',
        'exit_time',
    ];
    protected $casts = [
        'entry_time' => 'datetime',
        'exit_time' => 'datetime',
    ];
    
    public function visitor(): BelongsTo
    {
        return $this->belongsTo(Visitor::class,'visitor_id');
    }

    public function gate(): BelongsTo
    {
        return $this->belongsTo(Gate::class,'gate_id');
    }

    public function formattedEntryTime(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->entry_time ? $this->entry_time->format('d/m/Y h:i A') : 'N/A'
        );
    }

    public function formattedExitTime(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->exit_time ? $this->exit_time->format('d/m/Y h:i A') : 'N/A'
        );
    }

}
