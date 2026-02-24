<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    use HasFactory;
    protected $table = 'transaction';
    protected $fillable = [
        'from',
        'to',
        'amount',
        'currency',
        'current_profit',
        'type',
        'status',
        'note',
        'method',
        'created_by_guard',
        'created_by_id',
    ];

    public function fromUser(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(User::class, 'id', 'from');
    }
    public function toUser(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(User::class, 'id', 'to');
    }

    public function getCreatedByNameAttribute(): string
    {
        if (!$this->created_by_guard || !$this->created_by_id) {
            return '-';
        }
        if ($this->created_by_guard === 'agent') {
            $a = \App\Models\Agent::find($this->created_by_id);
            return $a ? $a->name : '-';
        }
        $u = User::find($this->created_by_id);
        return $u ? $u->name : '-';
    }
}
