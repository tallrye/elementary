<?php

namespace App\Http\Controllers\Chats;

use Illuminate\Http\Request as Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Profile;
use App\User;
use App\Models\Notifications\Notification;
use App\Models\Chat\Message;
use App\Models\Chat\Conversation;
use App\Models\Chat\MessageNotification;
use LaravelPusher;
use Datatables;
use File;
use Image;
use DB;

class ChatsController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Side Messages Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the sidebar messaging module.
    |
    */


    /**
     * Constructor method inherits directly from it's parent
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Send a message to another user. Fetch the conversations threads
     * then create a natification for each party, then save the message
     * and finally push response back to application 
     *
     * @param   \Illuminate\Http\Request  $request
     * @param   \App\Models\Chat\Message
     * @param   \App\Models\Chat\Conversation
     * @param   \App\Models\Chat\MessageNotification
     * @param   \LaravelPusher
     * @return  array
     */
    public function sendmessage(Request $request)
    {
        $sender = $request->get('sender_id');
        $recipient = $request->get('recipient_id');
        $senderThread = Conversation::where('sender_id', $sender)->where('recipient_id', $recipient)->first();
        $recipientThread = Conversation::where('sender_id', $recipient)->where('recipient_id', $sender)->first();
        $message = Message::create(['text' => $request->get('text'),'sender_id' => $sender, 'recipient_id' => $recipient]);

        MessageNotification::create(['conversation_id' => $senderThread->id,'message_id' => $message->id]);
        MessageNotification::create(['conversation_id' => $recipientThread->id,'message_id' => $message->id]);
        
        LaravelPusher::trigger('messages-channel'.$request->get('recipient_id'), 'refresh-messages', ['message' => 'Mesaj Geldi', 'id' => $message->id]);

        return array(['id' => $message->id, 'text' => 'Mesaj Gönderildi']);
    }

    /**
     * Fetch the last sent message to the module. Generate the HTML layout
     * and return this HTML back to the View;
     *
     * @param   integer  $id
     * @param   \App\Models\Chat\Message
     * @param   \Illuminate\Support\Facades\Auth
     * @return  string
     */
    public function fetchmessage($id){
        $message = Message::findOrFail($id);
        $html = '<div class="post out"><img class="avatar" alt="" src="'.url(Auth::user()->profile->photo).'" />      
                    <div class="message">
                        <span class="arrow"></span>
                        <a href="javascript:;" class="name">Ben</a>
                        <span class="datetime">'.$message->created_at->format('d-m-Y @ H:i:s').'</span>
                        <span class="body">'.$message->text.'</span>
                    </div>
                </div>';
        return $html;
    }


    /**
     * Send a new message to a user. Generate the HTML layout
     * and return this HTML back to the View as well as necessary
     * data to update the View i.e. unred message count badge.
     *
     * @param   integer  $id
     * @param   \App\Models\Chat\Message
     * @param   \Illuminate\Support\Facades\Auth
     * @return  array
     */
    public function newmessage($id){
        $message = Message::findOrFail($id);
        $html = '<div class="post in unreadMessage" data-message="'.$message->id.'">
                    <img class="avatar" alt="" src="'.url($message->sender->profile->photo).'" />      
                    <div class="message">
                        <span class="arrow"></span>
                        <a href="javascript:;" class="name">'.$message->sender->name.'</a>
                        <span class="datetime">'.$message->created_at->format('d-m-Y @ H:i:s').'</span>
                        <span class="body">'.$message->text.'</span>
                    </div>
                </div>';

        $unreadTotal = Message::where('recipient_id', Auth::user()->id)->where('isRead', 'false')->count();
        $unredFromSender = Message::where('recipient_id', Auth::user()->id)->where('sender_id', $message->sender_id)->where('isRead', 'false')->count();

        return array('html' => $html, 'unreadTotal' => $unreadTotal, 'lastSender' => $message->sender_id, 'unredFromSender' => $unredFromSender);
    }

    /**
     * Generate an HTML layout for a certain conversation with another user
     * and return this HTML back to the View as well as necessary
     * data to update the View i.e. unred message count badge. If there's
     * no previous conversation between two user, create a new conversation.
     *
     * @param   integer  $id
     * @param   \App\Models\Chat\Message
     * @param   \App\Models\Chat\Conversation
     * @param   \App\Models\Chat\MessageNotification
     * @param   \App\User
     * @param   \Illuminate\Support\Facades\Auth
     * @return  array
     */
    public function loadconversationwith($id){
        $recipient = User::findOrFail($id);
        if(doIHaveConversationWith($recipient->id) == false){
            Conversation::create(['sender_id' => Auth::user()->id,'recipient_id' => $recipient->id]);
            Conversation::create(['sender_id' => $recipient->id,'recipient_id' => Auth::user()->id]);
        }
        $notifications = MessageNotification::where('conversation_id', myConversationWith($recipient->id)->id)->orderBy('created_at','DESC')->take(10)->get();
        $messages = '';
        foreach($notifications as $notification){
            if($notification->message->sender_id == Auth::user()->id){
                $messages = '<div class="post out">
                                <img class="avatar" alt="" src="'.url($notification->message->sender->profile->photo).'" />
                                <div class="message">
                                    <span class="arrow"></span>
                                    <a href="javascript:;" class="name">Ben</a>
                                    <span class="datetime">'. $notification->message->created_at->format('d-m-Y @ H:i:s') .'</span>
                                    <span class="body"> '. $notification->message->text .' </span>
                                </div>
                            </div>'.$messages;
            }else{
                if($notification->message->isRead){
                    $isRead = "";
                }else{
                    $isRead = "unreadMessage";
                }
                $messages = '<div class="post in '.$isRead.'" data-message="'.$notification->message->id.'">
                    <img class="avatar" alt="" src="'.url($recipient->profile->photo).'" />
                    <div class="message">
                        <span class="arrow"></span>
                        <a href="javascript:;" class="name">'. $recipient->name .'</a>
                        <span class="datetime">'. $notification->message->created_at->format('d-m-Y @ H:i:s') .'</span>
                        <span class="body"> '. $notification->message->text .' </span>
                    </div>
                </div>'.$messages;
            }
        }

        $form = \Form::open(['route' => 'chat.sendmessage', 'class' => 'sideMessageForm']).'
                    <div class="input-group">
                        <input type="hidden" value="'.Auth::user()->id .'" name="sender_id">
                        <input type="hidden" value="'. $recipient->id .'" name="recipient_id">
                        <input type="text" autocomplete="off" class="form-control" name="text" placeholder="Yaz...">
                        <div class="input-group-btn">
                            <button type="submit" class="btn green">
                                <i class="icon-paper-clip"></i>
                            </button>
                        </div>
                    </div>
                '. \Form::close();

        if(count($notifications) < 10){
            $formEarlier = "";
        }else{
            $formEarlier = \Form::open(['route' => 'chat.loadearlier', 'class' => 'loadEarlierForm']).'
                            <input type="hidden" value="'.Auth::user()->id .'" name="sender_id">
                            <input type="hidden" value="'. $recipient->id .'" name="recipient_id">
                            <input type="hidden" value="10" name="skip">
                            <button type="submit" id="loadEarlierMessages">Önceki yazışmaları yükle</button>
                        '. \Form::close();
        }
        $unreadTotal = Message::where('recipient_id', Auth::user()->id)->where('isRead', 'false')->count();
        return array('messages' => $messages, 'form' => $form, 'unreadTotal' => $unreadTotal, 'formEarlier' => $formEarlier);
    }

    /**
     * Update a message by changing it's status from unread to read.
     *
     * @param   integer  $id
     * @param   \App\Models\Chat\Message
     * @param   \Illuminate\Support\Facades\Auth
     * @return  array
     */
    public function readmessage($id){
        $message = Message::findOrFail($id);
        $message->isRead = true;
        $message->save();
        $unreadTotal = Message::where('recipient_id', Auth::user()->id)->where('isRead', 'false')->count();
        $unreadFromSender = Message::where('recipient_id', Auth::user()->id)->where('sender_id', $message->sender_id)->where('isRead', 'false')->count();
        return array('unreadTotal' => $unreadTotal, 'lastSender' => $message->sender_id, 'unreadFromSender' => $unreadFromSender);
    }

    /**
     * Load 10 more earlier messages
     *
     * @param   integer  $id
     * @param   \App\Models\Chat\Message
     * @param   \App\Models\Chat\MessageNotification
     * @param   \App\User
     * @param   \Illuminate\Support\Facades\Auth
     * @return  array
     */
    public function loadearlier(Request $request){
        $notifications = MessageNotification::where('conversation_id', myConversationWith($request->get('recipient_id'))->id)->orderBy('created_at','DESC')->skip($request->get('skip'))->take(10)->get();
        $messagelength = count($notifications);
        $recipient = User::findOrFail($request->get('recipient_id'));
        $messages = '';
        foreach($notifications as $notification){
            if($notification->message->sender_id == Auth::user()->id){
                $messages = '<div class="post out">
                                <img class="avatar" alt="" src="'.url($notification->message->sender->profile->photo).'" />
                                <div class="message">
                                    <span class="arrow"></span>
                                    <a href="javascript:;" class="name">Ben</a>
                                    <span class="datetime">'. $notification->message->created_at->format('d-m-Y @ H:i:s') .'</span>
                                    <span class="body"> '. $notification->message->text .' </span>
                                </div>
                            </div>'.$messages;
            }else{
                if($notification->message->isRead){
                    $isRead = "";
                }else{
                    $isRead = "unreadMessage";
                }
                $messages = '<div class="post in '.$isRead.'" data-message="'.$notification->message->id.'">
                                <img class="avatar" alt="" src="'.url($recipient->profile->photo).'" />
                                <div class="message">
                                    <span class="arrow"></span>
                                    <a href="javascript:;" class="name">'. $recipient->name .'</a>
                                    <span class="datetime">'. $notification->message->created_at->format('d-m-Y @ H:i:s') .'</span>
                                    <span class="body"> '. $notification->message->text .' </span>
                                </div>
                            </div>'.$messages;
            }
        }
        return array('messages' => $messages, 'messagelength' => $messagelength);
    }

}