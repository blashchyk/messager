<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Message;
use Auth;
class MailController extends Controller
{
    public function email(Request $request)
    {
        $auth = Auth::user();
        
        $mes = new Message();
        $mes->from = $_ENV['MAIL_USERNAME'];
        $mes->to = trim($request->email);
        $mes->message = $request->message;
        $mes->subject = $request->subject;
        $mes->save();
        $data = ['name'=>$request->message];
        
         Mail::send(['text'=>'mail'], $data, function ($message) use ($request) {
            $message->from($_ENV['MAIL_USERNAME']);
            // $message->sender('john@johndoe.com', 'John Doe');
        
            $message->to($request->email);
            // $message->cc('john@johndoe.com', 'John Doe');
            // $message->bcc('john@johndoe.com', 'John Doe');
            // $message->replyTo('john@johndoe.com', 'John Doe');
             $message->subject($request->subject);
            // $message->priority(3);
            // $message->attach('pathToFile');
        });
       
            return redirect()->route('home')->with('status', 'Сообщение отправлено');
        
        
    }
}
