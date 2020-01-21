<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dns extends Model
{
    protected $table = 'dns_keyword';
    public $timestamps = true;
    protected $primaryKey = 'keyword_id';
    protected $fillable = ['keyword_id', 'keyword', 'created_at', 'updated_at', 'usrname','cheat_ip'];
}
