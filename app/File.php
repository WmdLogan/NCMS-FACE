<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table = 'file_keyword';
    public $timestamps = false;
    protected $primaryKey = 'keyword_id';
}
