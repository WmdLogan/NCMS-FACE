<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ftplog extends Model
{
    protected $table = 'ftp_txt_log';
    public $timestamps = false;
    protected $primaryKey = 'log_id';
}
