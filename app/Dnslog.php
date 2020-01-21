<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dnslog extends Model
{
    protected $table = 'dns_log';
    public $timestamps = false;
    protected $primaryKey = 'log_id';
}
