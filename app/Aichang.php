<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aichang extends Model
{
    protected $table = 'aichang_message_keyword';
    public $timestamps = true;
    protected $primaryKey = 'keyword_id';
    protected $fillable = ['keyword_id', 'keyword', 'created_at', 'updated_at', 'usrname'];
}
