<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class eventsapproval extends Model
{
    use HasFactory;
    protected $table = 'event_approval';

    protected $primaryKey = 'auto_id';

    protected $fillable = [


        'event_name',
        'event_venue',
        'F_date',
        'T_date',
        'User_Id',
        'User_Name',
        'Approval_Status'

    ];
}
