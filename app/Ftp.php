<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ftp extends Model
{
    protected $table = 'ftp_txt_keyword';
    public $timestamps = true;
    protected $primaryKey = 'keyword_id';
    protected $fillable = ['keyword_id', 'keyword', 'created_at', 'updated_at', 'usrname'];
}
