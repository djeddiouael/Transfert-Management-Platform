<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'current_institution',
        'current_department',
        'current_faculty',
        'current_specialization',
        'current_formation',
        'current_year',
        'average_grade',
        'desired_formation',
        'motivation',
        'career_plan',
        'technical_skills',
        'languages',
        'projects',
        'status',
        'admin_notes',
        'transcript_path',
        'cv_path',
        'motivation_letter_path',
        'id_document_path',
        'certificates_paths'
    ];

    protected $casts = [
        'certificates_paths' => 'array',
        'languages' => 'array',
        'request_date' => 'datetime'
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function statusHistory()
    {
        return $this->hasMany(TransferRequestStatusHistory::class, 'transfer_request_id');
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'pending' => 'warning',
            'confirmed' => 'info',
            'accepted' => 'success',
            'rejected' => 'danger',
            default => 'secondary'
        };
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

    public function getStatusDetailsAttribute()
    {
        return match($this->status) {
            'pending' => __('transfer.status.pending_details'),
            'confirmed' => __('transfer.status.confirmed_details'),
            'accepted' => __('transfer.status.accepted_details'),
            'rejected' => __('transfer.status.rejected_details'),
            default => __('transfer.status.unknown_details')
        };
    }

    public function getDocumentsAttribute()
    {
        return [
            'transcript' => $this->transcript_path,
            'cv' => $this->cv_path,
            'motivation_letter' => $this->motivation_letter_path,
            'id_document' => $this->id_document_path,
            'certificates' => $this->certificates_paths
        ];
    }
} 