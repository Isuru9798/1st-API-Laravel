<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegisterDetails extends Model
{
    protected $table = 'register_details';
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
