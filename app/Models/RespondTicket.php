<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ticket;
use App\Models\User;

class RespondTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
         'technician_id',
          'response',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
 
    public function technician()
    {
        return $this->belongsTo(User::class);
    }
}
