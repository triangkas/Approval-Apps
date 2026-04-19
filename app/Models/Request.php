<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    public function level()
    {
        return $this->belongsTo(ApprovalStep::class, 'approval_level', 'level');
    }
}
