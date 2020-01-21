<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Amtxtlog extends Model
{
    protected $table = 'am_txt_log';
    public $timestamps = false;
    protected $primaryKey = 'log_id';
}
