<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Employee extends Model
{
    protected $collection = "emmployees";
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'name'];
}
