<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Am extends Model
{
    protected $table = 'am_message_keyword';
    public $timestamps = true;
    protected $primaryKey = 'keyword_id';
    protected $fillable = ['keyword_id', 'keyword', 'created_at', 'updated_at', 'usrname'];
}
