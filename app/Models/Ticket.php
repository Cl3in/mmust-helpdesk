<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Department;
use App\Models\RespondTicket;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
         'subject',
          'department_id',
           'body',
           'status',
           'user_id'
                ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function response()
    {
        return $this->hasMany(RespondTicket::class);
    }
}
