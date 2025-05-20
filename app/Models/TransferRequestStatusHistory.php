<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferRequestStatusHistory extends Model
{
    use HasFactory;

    protected $table = 'transfer_request_status_history';

    protected $fillable = [
        'transfer_request_id',
        'status',
        'notes',
        'changed_by',
        'changed_at'
    ];

    protected $casts = [
        'changed_at' => 'datetime'
    ];

    public function transferRequest()
    {
        return $this->belongsTo(TransferRequest::class);
    }

    public function changer()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }

    public function getStatusTextAttribute()
    {
        return match($this->status) {
            'pending' => __('transfer.status.pending'),
            'confirmed' => __('transfer.status.confirmed'),
            'accepted' => __('transfer.status.accepted'),
            'rejected' => __('transfer.status.rejected'),
            default => __('transfer.status.unknown')
        };
    }
} 