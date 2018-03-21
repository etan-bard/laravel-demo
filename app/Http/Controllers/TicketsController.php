<?php

namespace App\Http\Controllers;

use App\Category;
use App\Ticket;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TicketsController extends Controller {

	/* This ensures that all functions in TicketsController go through the 'auth' middleware. */
	public function __construct() {
    	$this->middleware('auth');
	}

	/* This will pass all categories to a view. */
    public function create() {
    	$categories = Category::all();

    	return view('tickets.create', compact('categories'));
    }

    /* Writes the new ticket to the database. */
    public function store(Request $request) {
    	$this->validate($request, [
            'title'    => 'required',
            'category' => 'required',
            'priority' => 'required',
            'message'  => 'required'
        ]);

        $ticket = new Ticket([
            'title'      => $request->input('title'),
            'user_id'    => Auth::user()->id,
            'ticket_id'  => strtoupper(str_random(10)),
            'category_id'=> $request->input('category'),
            'priority'   => $request->input('priority'),
            'message'    => $request->input('message'),
            'status'     => "Open",
        ]);

        $ticket->save();

        return redirect()->back()->with("status", "A ticket with ID: #$ticket->ticket_id has been opened.");
	}

	/* This will retrieve the current user's tickets. */
	public function userTickets() {
    	$tickets = Ticket::where('user_id', Auth::user()->id)->paginate(10);
    	$categories = Category::all();

    	return view('tickets.user_tickets', compact('tickets', 'categories'));
	}

	/* This will retrieve a specific ticket. */
	public function show($ticket_id) {
    	$ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();
    	$comments = $ticket->comments;
    	$category = $ticket->category;

    	return view('tickets.show', compact('ticket', 'category', 'comments'));
	}

	/* This will retrieve all tickets. */
	public function index($open_only) {

    	// If only open tickets are requested, then we will limit our query to only show open tickets.
    	$tickets;
		if($open_only === 'true') {
			Log::debug('Open tickets only');
    		$tickets = Ticket::where('status', 'Open')->paginate(10);
    	} else {
    		Log::debug('All tickets');
    		$tickets = Ticket::paginate(10);
    	}
    	
    	$categories = Category::all();

    	return view('tickets.index', compact('tickets', 'categories'));
	}

	public function close($ticket_id) {
    	$ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();
    	$ticket->status = 'Closed';
    	$ticket->save();
    	$ticketOwner = $ticket->user;

    	Log::debug('Mail would be sent to ' . $ticketOwner->email . ' that their ticket #' . $ticket_id . ' has been closed.');

    	return redirect()->back()->with("status", "The ticket has been closed.");
	}
}
