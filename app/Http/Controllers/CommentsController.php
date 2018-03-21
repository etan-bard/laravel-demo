<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Ticket;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CommentsController extends Controller
{
    public function postComment(Request $request)
	{
    	$this->validate($request, [
        	'comment'   => 'required'
    	]);

        	$comment = Comment::create([
            	'ticket_id' => $request->input('ticket_id'),
            	'user_id'   => Auth::user()->id,
            	'comment'   => $request->input('comment'),
        	]);

        // This will create a log debug message if the User is not the Ticket owner.
        if ($comment->ticket->user->id !== Auth::user()->id) {

            Log::debug('Mail would be sent to ' . $comment->ticket->user->email . ' that their ticket has received a reply.');
        }

        return redirect()->back()->with("status", "Your comment has be submitted.");
}
}
