<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    //
		protected $fillable = ['name','alias','text','images'];


     	public $timestamps = TRUE;	
}
