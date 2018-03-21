<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model {
    protected $fillable = [
    	'user_id', 
    	'category_id', 
    	'ticket_id', 
    	'title', 
    	'priority', 
    	'message', 
    	'status'
	];

	/* Specifies a one to one relationship between a Ticket and a Category. */
	public function category() {
		return $this->belongsTo(Category::class);
	}
}
