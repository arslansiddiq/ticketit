<?php

namespace Kordy\Ticketit\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Kordy\Ticketit\Helpers\LaravelVersion;
use Kordy\Ticketit\Models\Comment;
use Kordy\Ticketit\Models\TSetting;
use Kordy\Ticketit\Models\Ticket;
use Kordy\Ticketit\Notifications\TicketNotification;
use Sentinel;


class NotificationsController extends Controller
{
    public function newComment(Comment $comment)
    {
        $ticket = $comment->ticket;
        $notification_owner = $comment->ticket->user;
        $template = 'ticketit::emails.comment';
        $data = ['comment' => serialize($comment), 'ticket' => serialize($ticket)];

        // //Send Notification to Agent
        if($ticket->agent->email !== Sentinel::getUser()->email){
            $this->sendNotification($template, $data, $ticket, $ticket->agent,
                trans('ticketit::lang.notify-new-comment-from').$ticket->agent->name.trans('ticketit::lang.notify-on').$ticket->subject, 'comment');
        }
        
        if($notification_owner->email !== Sentinel::getUser()->email){
            $this->sendNotification($template, $data, $ticket, $notification_owner,
                trans('ticketit::lang.notify-new-comment-from').$notification_owner->name.trans('ticketit::lang.notify-on').$ticket->subject, 'comment');
        }

    }

    public function ticketStatusUpdated(Ticket $ticket, Ticket $original_ticket)
    {
        $notification_owner = Sentinel::getUser();
        $template = 'ticketit::emails.status';
        $data = [
            'ticket'             => serialize($ticket),
            'notification_owner' => serialize($notification_owner),
            'original_ticket'    => serialize($original_ticket),
        ];
        if (strtotime($ticket->completed_at)) {
            $this->sendNotification($template, $data, $ticket, $notification_owner,
                $notification_owner->name.trans('ticketit::lang.notify-updated').$ticket->subject.trans('ticketit::lang.notify-status-to-complete'), 'status');
        } else {
            $this->sendNotification($template, $data, $ticket, $notification_owner,
                $notification_owner->name.trans('ticketit::lang.notify-updated').$ticket->subject.trans('ticketit::lang.notify-status-to').$ticket->status->name, 'status');
        }
    }

    public function ticketAgentUpdated(Ticket $ticket, Ticket $original_ticket)
    {
        $notification_owner = Sentinel::getUser();
        $template = 'ticketit::emails.transfer';
        $data = [
            'ticket'             => serialize($ticket),
            'notification_owner' => serialize($notification_owner),
            'original_ticket'    => serialize($original_ticket),
        ];

        $this->sendNotification($template, $data, $ticket, $notification_owner,
            $notification_owner->name.trans('ticketit::lang.notify-transferred').$ticket->subject.trans('ticketit::lang.notify-to-you'), 'agent');
    }

    public function newTicketNotifyAgent(Ticket $ticket)
    {
        $notification_owner = Sentinel::getUser();
        $template = 'ticketit::emails.assigned';
        $data = [
            'ticket'             => serialize($ticket),
            'notification_owner' => serialize($notification_owner),
            'images'             => serialize($this->extractLinks($ticket->html))
        ];

        $this->sendNotification($template, $data, $ticket, $notification_owner,
            $notification_owner->name.trans('ticketit::lang.notify-created-ticket').$ticket->subject, 'new-ticket');

        $template = 'ticketit::emails.assigned-zapier';
        $this->sendNotification($template, $data, $ticket, $notification_owner,
            $notification_owner->name.trans('ticketit::lang.notify-created-ticket').$ticket->subject, 'new-ticket-zapier');

    }

    /**
     * Extract Links from content
     * @return Array | array
     */
    protected function extractLinks($content)
    {
        //Get the page's HTML source using file_get_contents.
        $htmlDom = new \DomDocument();
        //Parse the HTML of the page using DOMDocument::loadHTML
        $htmlDom->loadHtml($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NOERROR | LIBXML_NOWARNING);    
        //Extract the links from the HTML.
        $links = $htmlDom->getElementsByTagName('a');
        //Array that will contain our extracted links.
        $extractedLinks = array();
        //We can do this because the DOMNodeList object is traversable.
        foreach($links as $link)
        {
            $linkText = $link->nodeValue;
            $linkHref = $link->getAttribute('href');
            //If the link is empty, skip it and don't
            if(strlen(trim($linkHref)) == 0){
                continue;
            }
            //Skip if it is a hashtag / anchor link.
            if($linkHref[0] == '#'){
                continue;
            }
            //Add the link to our $extractedLinks array.
            $extractedLinks[] = array(
                'text' => $linkText,
                'href' => $linkHref
            );
        }
        return $extractedLinks;
    }

    public function newCommentAndStatus(Comment $comment, Ticket $ticket, Ticket $original_ticket)
    {
        $notification_owner = Sentinel::getUser();
        $template = 'ticketit::emails.comment-status';
        $data = [
            'comment'            => serialize($comment),
            'ticket'             => serialize($ticket),
            'notification_owner' => serialize($notification_owner),
            'original_ticket'    => serialize($original_ticket),
        ];
        // dd($original_ticket);
        if (strtotime($ticket->completed_at)) {
            $this->sendNotification($template, $data, $ticket, $notification_owner,
                $notification_owner->name.trans('ticketit::lang.comment-notify-updated').$ticket->subject.trans('ticketit::lang.notify-status-to-complete'), 'status');
        } else {
            $this->sendNotification($template, $data, $ticket, $notification_owner,
                $notification_owner->name.trans('ticketit::lang.comment-notify-updated').$ticket->subject.trans('ticketit::lang.notify-status-to').$ticket->status->name, 'status');
        }
    }

    /**
     * Send email notifications from the action owner to other involved users.
     *
     * @param string $template
     * @param array  $data
     * @param object $ticket
     * @param object $notification_owner
     */
    public function sendNotification($template, $data, $ticket, $notification_owner, $subject, $type)
    {
        /**
         * @var User
         */
        $to = null;
        $setting = new TSetting();
        $notify_data = [
            'channels'  =>  ['database'],
            'title'     =>  'Ticket Support Notification',
            'message'   =>  $subject,
            'action'    =>  route($setting->grab('main_route').'.show', $ticket->id),
            'image'     =>  '#'
        ];
        if($type == 'comment'){
            $to = $notification_owner;
            $notify_data['title'] = 'New Comment on Ticket';
        }
        else if($type == 'new-ticket'){
            $to = $ticket->agent;
            $notify_data['title'] = 'New Ticket created';
        }
        else if ($type !== 'agent') {
            $to = $ticket->user;
            $notify_data['title'] = 'Ticket Notification';
            if ($ticket->user->email != $notification_owner->email) {
                $to = $ticket->user;
            }

            if ($ticket->agent->email != $notification_owner->email) {
                $to = $ticket->agent;
            }
        }
        else {
            $to = $ticket->agent;
        }

        if(env('TICKET_SYSTEM', 'prod') == 'dev'){
            $to = ['id' => 41,'email' => env('DEVELOPER_EMAIL',''), 'name' => 'Ticket Testing'];
            $to = (object) $to;
        }

        if($type == 'new-ticket-zapier'){
            // $to = [$to];
            $zapp =  (object)['email' => env('TICKETS_SECOND_EMAIL',''), 'name' => env('APP_NAME')];
            // array_push($to, $zapp);
            $to = $zapp;
        }


        if (LaravelVersion::lt('5.4')) {
            $mail_callback = function ($m) use ($to, $notification_owner, $subject) {
                $m->to($to->email, $to->name);

                $m->replyTo($notification_owner->email, $notification_owner->name);

                $m->subject($subject);
            };

            if (TSetting::grab('queue_emails') == 'yes') {
                Mail::queue($template, $data, $mail_callback);
            } else {
                Mail::send($template, $data, $mail_callback);
            }
        } elseif (LaravelVersion::min('5.4')) {
            $mail = new \Kordy\Ticketit\Mail\TicketitNotification($template, $data, $notification_owner, $subject);

            if (TSetting::grab('queue_emails') == 'yes') {
                Mail::to($to)->queue($mail);
            } else {
                Mail::to($to)->send($mail);
            }

            // Send User Inapp Notification when email sent
            if(isset($to->id)){
                $user = Sentinel::findUserById($to->id);
                {
                    $user->notify(new TicketNotification($notify_data));
                }
            }
        }
    }
}
