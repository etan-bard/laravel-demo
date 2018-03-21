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

	/* Specifies the relationship between a Ticket and a Category. */
	public function category() {
		return $this->belongsTo(Category::class);
	}

	/* Specifies the relationship between a ticket and it's comments. */
	public function comments() {
		return $this->hasMany(Comment::class);
	}

	/* Specifies the relationship between a Ticket and a User. */
	public function user() {
		return $this->belongsTo(User::class);
	}
}
