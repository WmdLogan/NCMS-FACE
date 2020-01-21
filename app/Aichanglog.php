<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aichanglog extends Model
{
    protected $table = 'aichang_message_log';
    public $timestamps = false;
    protected $primaryKey = 'log_id';
}
