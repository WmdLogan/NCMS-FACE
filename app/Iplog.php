<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Iplog extends Model
{
    protected $table = 'ip_kill_log';
    public $timestamps = false;
    protected $primaryKey = 'log_id';
}
