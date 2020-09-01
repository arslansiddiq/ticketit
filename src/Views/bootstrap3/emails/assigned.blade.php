<?php $notification_owner = unserialize($notification_owner);?>
<?php $ticket = unserialize($ticket);?>
<?php $images = unserialize($images);?>

@extends('ticketit::emails.templates.leadgenerated')

@section('subject')
	{{ trans('ticketit::email/globals.assigned') }}
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
	{{-- {!! trans('ticketit::email/assigned.data', [
		'name'      =>  $notification_owner->name,
		'subject'   =>  $ticket->subject,
		'id'		=>	$ticket->id,
		'status'    =>  $ticket->status->name,
		'category'  =>  ($ticket->category->parent_category) ? $ticket->category->parent_category->name : $ticket->category->name,
		'sub_category' => ($ticket->category->parent_category) ? $ticket->category->name : null,
		'priority' => $ticket->priority->name,
		'content'	=>	$ticket->email_content
	]) !!} --}}

	<h3 class="email-template__intro" style="margin: 0 0 20px;font-weight: 400;font-size: 20px;">Hello Support Team,</h3>
	<p class="email-template__message" style="line-height: 1.4em;font-size: 15px;">
		A new ticket has been created in the Lead Generated support system.
	</p>
	<table class="email-template__schedule" style="margin: 50px auto;width: 100%;">
	  <tbody>
	    <tr>
	      <td style="padding: 5px 10px 5px 0;width: 100px; vertical-align:top;"><span class="heading-bold" style="font-weight: 600;">Ticket #:</span></td>
	      <td> {{ $ticket->id }} </td>
	    </tr>
	    <tr>
	      <td style="padding: 5px 10px 5px 0;width: 100px; vertical-align:top;"><span class="heading-bold" style="font-weight: 600;">Date:</span></td>
	      <td> {{ $ticket->created_at->toDayDateTimeString() }} </td>
	    </tr>
	    <tr>
	      <td style="padding: 5px 10px 5px 0;width: 100px; vertical-align:top;"><span class="heading-bold" style="font-weight: 600;">Title:</span></td>
	      <td> {{ $ticket->subject }} </td>
	    </tr>
	    <tr>
	      <td style="padding: 5px 10px 5px 0;width: 100px; vertical-align:top;"><span class="heading-bold" style="font-weight: 600;">User:</span></td>
	      <td> {{ $notification_owner->name }} </td>
	    </tr>
	    <tr>
	      <td style="padding: 5px 10px 5px 0;width: 100px; vertical-align:top;"><span class="heading-bold" style="font-weight: 600;">Status:</span></td>
	      <td> {{ $ticket->status->name }} </td>
	    </tr>
	    <tr>
	      <td style="padding: 5px 10px 5px 0;width: 100px; vertical-align:top;"><span class="heading-bold" style="font-weight: 600;">Category:</span></td>
	      <td> {!! ($ticket->category->parent_category) ? $ticket->category->parent_category->name : $ticket->category->name !!} </td>
	    </tr>
	    @if ($ticket->category->parent_category)
		    <tr>
		      <td style="padding: 5px 10px 5px 0;width: 100px; vertical-align:top;"><span class="heading-bold" style="font-weight: 600;">Sub Category: </span></td>
		      <td colspan="2"> {!! ($ticket->category->parent_category) ? $ticket->category->name : '-' !!} </td>
		    </tr>
	    @endif
	    <tr>
	      <td style="padding: 5px 10px 5px 0;width: 100px; vertical-align:top;"><span class="heading-bold" style="font-weight: 600;">Images/Links: </span></td>
	      <td> 
	      	@foreach ($images as $image)
	      		<a href="{{ $image['href'] }}">{{ $image['text'] }}</a> 
	      	@endforeach
	      </td>
	    </tr>
	    <tr>
	      <td style="padding: 5px 10px 5px 0;width: 100px; vertical-align:top;"><span class="heading-bold" style="font-weight: 600;">Ticket Url: </span></td>
	      <td> <a href="{{ route($setting->grab('main_route').'.show', $ticket->id) }}">{{ route($setting->grab('main_route').'.show', $ticket->id) }}</a>
	      </td>
	    </tr>
	    <tr>
	      <td style="padding: 20px 10px 5px 0;width: 100px; vertical-align:top;"><span class="heading-bold" style="font-weight: 600;">Description: </span></td>
	      <td> {!! $ticket->email_content !!} </td>
	    </tr>
	  </tbody>
	</table>
@stop
