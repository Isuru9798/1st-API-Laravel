<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mytable extends Model
{
    protected $table = 'myTable';
    public $timestamps = false;
    protected $fillable = [
        'name',
        'email',
        'mobileNumber',
        'macAddress',
        'deviceId',
        'imiNumber',
        'timestamp'
    ];
}
