<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
        protected $fillable = [
    	
        'status','user_delete','customer_delete'
    ];
}
