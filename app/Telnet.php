<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Telnet extends Model
{
    protected $table = 'telnet_keyword';
    public $timestamps = true;
    protected $primaryKey = 'keyword_id';
    protected $fillable = ['keyword_id', 'keyword', 'created_at', 'updated_at', 'usrname'];
}
