<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Telnetlog extends Model
{
    protected $table = 'telnet_kill_log';
    public $timestamps = false;
    protected $primaryKey = 'log_id';
}
