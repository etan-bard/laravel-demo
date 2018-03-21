<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
	use Notifiable;

	/**
	 * The attributes that are mass assignable.
	 * @var array
	 */
	protected $fillable = [
		'name', 'email', 'password',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	/* Specifies the one to many relationship between a User and Comments. */
	public function comments() {
		return $this->hasMany(Comment::class);
	}

	/* Specifies the one to many relationship between a User and Tickets. */
	public function tickets() {
		return $this->hasMany(Ticket::class);
	}
}
