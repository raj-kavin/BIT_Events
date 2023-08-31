<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class venueapprovals extends Model
{
    use HasFactory;

    protected $table = 'event_approval';

    protected $primaryKey = 'auto_id';

    protected $fillable = [


        'venue_name',
        'User_Id',
        'User_Name',
        'Approval_Status'

    ];
}
