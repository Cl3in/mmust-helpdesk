<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Department;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [ 'subject', 'department_id', 'body' ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
