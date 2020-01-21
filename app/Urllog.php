<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Urllog extends Model
{
    protected $table = 'url_kill_log';
    public $timestamps = false;
    protected $primaryKey = 'log_id';
}
