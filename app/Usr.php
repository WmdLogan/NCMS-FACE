<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usr extends Model
{
    protected $table = 'usr';
    public $timestamps = false;
    protected $primaryKey = 'usr_id';
    protected $fillable = ['usr_id', 'username', 'passwd', 'auth'];
}
