<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Amlog extends Model
{
    protected $table = 'am_message_log';
    public $timestamps = false;
    protected $primaryKey = 'log_id';
}
