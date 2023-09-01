<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class events_attendence extends Model
{
    use HasFactory;
    protected $table = 'event_attendance';

    protected $primaryKey = 'auto_id';

    protected $fillable = [

        'staff_id',
        'event_id',
        'from_date',
        'to_date',
        'venue'

    ];
}
