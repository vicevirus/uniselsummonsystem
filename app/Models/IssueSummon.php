<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IssueSummon extends Model
{
    use HasFactory;

    protected $table = 'issue_summons';

    protected $primaryKey = 'summonId';

    protected $fillable = [
        'violation',
        'fineAmount',
        'dueDate',
        'issuedBy',
        'QRCodeId',
        'status',
        'securityId',
    ];

    protected $casts = [
        'dueDate' => 'date',
    ];



    public function student()
    {
        return $this->belongsTo(Student::class, 'QRCodeId', 'QRCodeId');
    }

    public function securityGuard()
    {
        return $this->belongsTo(SecurityGuard::class, 'securityId', 'securityId');
    }
}
