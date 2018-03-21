<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {
	protected $fillable = ['name'];


	/* Specifies a one to many relationship between a Category and Tickets. */
	public function tickets() {
		return $this->hasMany(Ticket::class);
	}
}
