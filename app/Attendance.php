<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
    'start_time ', 'end_time ', 'user_id',
    ];
}