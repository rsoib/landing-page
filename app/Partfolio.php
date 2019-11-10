<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partfolio extends Model
{
    //
	protected $fillable = ['name','filter','images'];
	
    public $timestamps = TRUE;
}
