<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    use HasFactory;
    protected $table = 'withdraw';
    protected $fillable = [
        'user_id',
        'amount',
        'status',
        'note',
        'reject_reason',
        'method',
        'phone',
        'name',
        'passport',
        'bank_account',
        'swift',
        'card_no',
    ];

    /** Status: 0 = Pending, 1 = Approved, 2 = Rejected */
    public const STATUS_PENDING = 0;
    public const STATUS_APPROVED = 1;
    public const STATUS_REJECTED = 2;

    public function userDetail(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
