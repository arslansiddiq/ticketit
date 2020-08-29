<?php $comment = unserialize($comment);?>
<?php $original_ticket = unserialize($original_ticket);?>
<?php $ticket = unserialize($ticket);?>

{{-- @extends($email) --}}
@extends('ticketit::emails.templates.leadgenerated')

@section('subject')
	{{ trans('ticketit::email/globals.comment') }}
@stop

@section('link')
	<a href="{{ route($setting->grab('main_route').'.show', $ticket->id) }}" style="display: table;margin: 0 auto;text-decoration: none;background-color: #14b6b7;color: #ffffff;padding: 30px 50px;border-radius: 5px;font-size: 20px;">
		<span style="padding: 18px 50px;">View Your Ticket</span>
	</a>
@stop

@section('comment')
	<p class="email-template__thank-you" style="text-align: center;font-weight: 500;font-size: 20px;margin-top: 50px;margin-bottom: 10px;color: #3f4040;">Thank You For Your Patience!</p>
@stop

@section('content')
	{{-- {!! trans('ticketit::email/comment.data', [
	    'owner'      =>  $ticket->user->name,
	    'name'      =>  $comment->user->name,
	    'subject'   =>  $ticket->subject,
	    'id'		=>	$ticket->id,
	    'status'    =>  $ticket->status->name,
	    'category'  =>  $ticket->category->name,
	    'comment'   =>  $comment->email_content
	]) !!} --}}
	
	  <h3 class="email-template__intro" style="margin: 0 0 20px;font-weight: 400;font-size: 20px;">Hello {{ $ticket->user->first_name }},</h3>
	  <p class="email-template__message" style="line-height: 1.4em;font-size: 15px;">Lead Generated support has replied to the ticket you created and changed the status of the ticket.</p>
	  <table class="email-template__schedule" style="margin: 50px auto;width: 100%;">
	    <tbody>
	      <tr>
	        <td style="padding: 5px 10px 5px 0;width: 100px;"><span class="heading-bold" style="font-weight: 600;">Ticket #:</span></td>
	        <td> {{ $ticket->id }} </td>
	      </tr>
	      <tr>
	        <td style="padding: 5px 10px 5px 0;width: 100px;"><span class="heading-bold" style="font-weight: 600;">Date:</span></td>
	        <td> {{ $ticket->created_at->toDayDateTimeString() }} </td>
	      </tr>
	      <tr>
	        <td style="padding: 5px 10px 5px 0;width: 100px;"><span class="heading-bold" style="font-weight: 600;">Title:</span></td>
	        <td> {{ $ticket->subject }} </td>
	      </tr>
	      <tr>
	        <td style="padding: 5px 10px 5px 0;width: 100px;"><span class="heading-bold" style="font-weight: 600;">Old Status:</span></td>
	        <td> {{ $original_ticket->status->name }} </td>
	      </tr>
	      <tr>
	        <td style="padding: 5px 10px 5px 0;width: 100px;"><span class="heading-bold" style="font-weight: 600;">New Status:</span></td>
	        <td> {{ $ticket->status->name }} </td>
	      </tr>
	      <tr>
	        <td colspan="2" style="padding: 20px 10px 5px 0;width: 100px;"><span class="heading-bold" style="font-weight: 600;">Reply from Lead Generated Support:</span></td>
	      </tr>
	      <tr>
	        <td colspan="2"> {!! $comment->email_content !!} </td>
	      </tr>
	    </tbody>
	  </table><!-- .email-template__schedule -->
	
@stop
