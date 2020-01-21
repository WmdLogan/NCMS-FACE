<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Syslog extends Model
{
    protected $table = 'sys_operate_log';
    public $timestamps = true;
    protected $primaryKey = 'log_id';
    protected $fillable = ['log_id', 'username', 'created_at', 'updated_at', 'operate_type'];
}
