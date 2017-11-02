<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ddeboer\Imap\Server;
use Ddeboer\Imap\Search\RawExpression;
use App\Message;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id=null, Request $request)
    {
        
      
        $mes = Message::where('from', $_ENV['MAIL_USERNAME'])->orderBy('created_at', 'desc')->get();
        
        if($request->isMethod('post')){
            
            if($request->recipient_date == 'click'){
                $mes = Message::orderBy('created_at', 'asc')->get();
            }
            if($request->recipient_subject == 'click'){
                $mes= Message::orderBy('subject', 'asc')->get();
            }
            if($request->recipient == 'click'){
                $mes = Message::orderBy('to', 'asc')->get();
            }
            if($request->exit){
                $request->session()->flush();
            }
        }
        
        if($request->email && $request->password){
            $request->session()->put('email', $request->email);
            $request->session()->put('password', $request->password);
            $_ENV['MAIL_USERNAME'] = trim($request->email);
            $_ENV['MAIL_PASSWORD'] = $request->password;
        }
        if (!$request->session()->has('email')) {
            return redirect()->route('login');
          }
        
        $server = new Server('imap.gmail.com');
        $connection = $server->authenticate($_ENV['MAIL_USERNAME'], $_ENV['MAIL_PASSWORD']);
        
        $mailbox = $connection->getMailbox('INBOX');
        
        $messages = $mailbox->getMessages();
      //
        $collection = collect($messages);
        $messages = $collection->slice(count($collection)-10);
        $result = [];
        if($request->del == 'click'){
            
            foreach($request->id as $res){
                if ($mailbox->getMessage($res)->delete()) {
                    throw new Exception('Удаление');
                }
                return redirect()->route('home');    
            }
        }
        if($request->del2 == 'click'){
            foreach($request->id as $res){
                $del = Message::find($res);
                $del->delete();
            }
            return redirect()->route('home')->with('click', 'Нажатие');
        }
      
        foreach ($messages as $k=>$message) {
            
            $result[$k]['id'] = $message->getNumber();
            $result[$k]['subject'] = $message->getSubject();
            $result[$k]['from'] = $message->getFrom();
           $result[$k]['message'] = $message->getBodyText();  
          $result[$k]['date'] = json_encode($message->getDate());
   
        }
      
        foreach ($result as $key => $row) {
            $subject[$key]  = $row['subject'];
            $from[$key] = $row['from'];
            $date[$key] = $row['date'];
            $text[$key] = $row['message'];
        }
        
        if($request->sender !='click' && $result){
            array_multisort($date, SORT_DESC, $result);
        }
        
        if($request->sender == 'click'){
            array_multisort($from, SORT_ASC, $result);
        }
        if($request->letter_subject == 'click'){
            array_multisort($subject, SORT_ASC, $result);
        }
        if($request->date_re == 'click'){
            array_multisort($date, SORT_ASC, $result);
        }

        $message = false;
        if($id !== null){
            $from = $result[$id]['from'];
            $message = $result[$id]['message'];
            $subject = $result[$id]['subject'];
            $data = json_decode($result[$id]['date'], true);
            $data= $data['date'];
            return view('home',[
                'result'=>$result,
                'message'=>$message,
                'from'=>$from,
                'subject'=>$subject,
                'data'=>$data,
                'mes'=>$mes
               
            ]);
        }

   
        return view('home',[
            'result'=>$result,
            'message'=>$message,
            'mes'=>$mes
           
        ]);
    }

    public function detals($id){
        $message2 = Message::find($id);
       
        $mes = Message::all();
        
          $server = new Server('imap.gmail.com');
          $connection = $server->authenticate('itmastertest2017@gmail.com', 'shutzzz19871905');
        
          $mailbox = $connection->getMailbox('INBOX');
          $messages = $mailbox->getMessages();
          $result = [];
          
          foreach ($messages as $k=>$message) {
              $result[$k]['subject'] = $message->getSubject();
              $result[$k]['from'] = $message->getFrom();
             $result[$k]['message'] = $message->getBodyText();
              
            $result[$k]['date'] = json_encode($message->getDate());
            
          }
    
        return view('home', [
            'result'=>$result,
            'message2'=>$message2,
            'mes'=>$mes
        ]);
    }

    
}
