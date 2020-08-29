<?php

namespace Kordy\Ticketit\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kordy\Ticketit\Models;
use Kordy\Ticketit\Controllers\NotificationsController;

class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('Kordy\Ticketit\Middleware\IsAdminMiddleware', ['only' => ['edit', 'update', 'destroy']]);
        $this->middleware('Kordy\Ticketit\Middleware\ResAccessMiddleware', ['only' => 'store']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'ticket_id'   => 'required|exists:ticketit,id',
            'content'     => 'required|min:6',
        ]);

        if($request->has('status_change') && $request->get('status_change')){
            // check if status realy changed then send combined email otherwise send only comment do other wise
            $ticket = Models\Ticket::find($request->get('ticket_id'));
            if($ticket->status->id !== (int)$request->get('status_change')){
                session(['com_stat_both' => true]);
            }else{
                session(['com_stat_both' => false]);
            }

        }

        $comment = new Models\Comment();

        $comment->setPurifiedContent($request->get('content'));

        $comment->ticket_id = $request->get('ticket_id');
        $comment->user_id = \Sentinel::getuser()->id;
        $comment->save();

        if(session('com_stat_both', false)){

            $original_ticket = Models\Ticket::find($comment->ticket_id);
            $ticket = Models\Ticket::find($comment->ticket_id);
            $ticket->status_id = $request->get('status_change');
            $ticket->updated_at = $comment->created_at;
            $ticket->save();

            $notification = new NotificationsController();
            $notification->newCommentAndStatus($comment, $ticket, $original_ticket);

            session(['com_stat_both' => false]);
        }else{
            $ticket = Models\Ticket::find($comment->ticket_id);
            $ticket->updated_at = $comment->created_at;
            $ticket->save();
        }

        return back()->with('status', trans('ticketit::lang.comment-has-been-added-ok'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
