<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class events extends Model
{
    use HasFactory;

    protected $table = 'event_name';

    protected $primaryKey = 'auto_id';

    protected $fillable = [

        'event_name',
        'from_date',
        'to_date',
        'venue'
    ];
}
