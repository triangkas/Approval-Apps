<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApprovalStep extends Model
{
    public function requests()
    {
        return $this->hasMany(Request::class, 'approval_level', 'level');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
