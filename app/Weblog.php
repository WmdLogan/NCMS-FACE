<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Weblog extends Model
{
    protected $table = 'website_message_log';
    public $timestamps = false;
    protected $primaryKey = 'log_id';
}
