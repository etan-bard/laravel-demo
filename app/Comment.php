<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
    	'ticket_id', 'user_id', 'comment'
	];

	/* Specifies the relationship between a Comment and a Ticket. */
	public function ticket() {
    	return $this->belongsTo(Ticket::class);
	}

	/* Specifies the relationship between a Comment and a User. */
	public function user() {
    	return $this->belongsTo(User::class);
	}
}
