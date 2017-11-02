@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-offset-1 col-md-3">
             <div class="panel panel-default">
                <div class="panel-heading">Почта</div>

                <div class="panel-body">
                    <div>
                   
                        <a  class="show" href="#">Написать сообщение</a>
                    </div>
                    <div>
                        <a class="incoming" href="#">Входящие</a>
                    </div>
                   <div>
                        <a class="outgoing" href="#">Исходящие</a>
                    </div>

                   
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Мои сообщения</div>
                
                
                  
                <div class="panel-body">
                <div class='messages_body'>
                
                    <table border="1">
                        <form method="post" action="{{route('home')}}">
                        
                        {{ csrf_field() }}
                        <div class="wrapper_button">
                        <button class="btn btn-danger delete" name="del" value="click">Удалить</button>
                        <button name="exit" value="click" class="btn btn-danger exit">Выход</button>
                        </div>
                        <tr>
                            <th>#</th>
                            <th>Отправитель <button class=' btn btn-info' name="sender" value="click"><i class="fa fa-chevron-down" aria-hidden="true"></i></button></th>
                            <th>Тема письма <button class=' btn btn-info' name="letter_subject" value="click"><i class="fa fa-chevron-down" aria-hidden="true"></i></button></th>
                            <th>Дата получения <button class=' btn btn-info' name="date_re" value="click"><i class="fa fa-chevron-down" aria-hidden="true"></i></button></th>
                        </tr>
                        
                 
                        @foreach($result as $k=>$res)
                        <tr>
                            <td><input type="checkbox" name="id[]" value="{{$res['id']}}"></td>

                            <td><a href="{{route('message', $k)}}">{{$res['from']}}</a>
                            {{--  <input type='hidden' name="message_id" value="{{$k}}">  --}}
                            
                            </td>
                            <td>{{$res['subject']}}</td>
                            <td>{{substr(json_decode($res['date'])->date, 0, 19)}}</td>
                        </tr>
                        @endforeach
                        </form>
                        
                        </table>
                        
                    
                    
                    <div>
                </div>

                
            </div>
            <div class='messages_body2'>
                    <table border="1">
                        <form method="post" action="{{route('home')}}">
                            {{ csrf_field() }}
                            <div class="wrapper_button">
                        <button class="btn btn-danger delete2" name="del2" value="click">Удалить</button>
                          <button name="exit" value="click" class="btn btn-danger exit">Выход</button>
                        </div>
                        <tr>
                            <th>#</th>
                            <th>Получатель <button <button class='btn btn-info' name="recipient" value="click"><i class="fa fa-chevron-down" aria-hidden="true"></i></button></th>
                            <th>Тема письма <button <button class='btn btn-info' name="recipient_subject" value="click"><i class="fa fa-chevron-down" aria-hidden="true"></i></button></th>
                            <th>Дата отправки <button <button class='btn btn-info' name="recipient_date" value="click"><i class="fa fa-chevron-down" aria-hidden="true"></i></button></th>
                        </tr>
                       
                        @if($mes)
                        @foreach($mes as $res)
                       
                        <tr>
                            <td><input type="checkbox"name="id[]" value="{{$res->id}}"></td>

                            <td><a href="{{route('message_detal', $res->id)}}">{{$res->to}}</a>
                            {{--  <input type='hidden' name="message_id" value="{{$k}}">  --}}
                            
                            </td>
                            <td>{{$res->subject}}</td>
                            <td>{{$res->created_at}}</td>
                        </tr>
                        @endforeach
                        @endif
                         </form>
                        
                        </table>
                    
                    
                    <div>
                </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-offset-3 col-md-6">
            @if(session('status'))
                <div class="messages">
                
                    <p>{{session('status')}}</p>
                </div>
            @endif


            <div class="message">
            <button class="close">X</button>
            <h1 class="text-center">Написать сообщение</h1>
            <div class="col-sm-12">
            <form action="{{route('email')}}" method="post" class="form-horizontal">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-3">
                        <p>Кому:</p>
                    </div>
                    <div class="col-md-9">
                        <input class="form-control" type="email" name='email' placeholder="Адоес получателя">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <p>Тема:</p>
                    </div>
                    <div class="col-md-9">
                        <input class="form-control" type="text" name="subject" placeholder="Тема сообщения">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <p>Сообщение:</p>
                        <textarea  class="form-control" name="message" id="message" cols="15" rows="10"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class=" col-sm-offset-7 col-sm-5">
                        <button type="submit" class="btn btn-success">Отправить</button>
                        <button type="reset" class="btn btn-warning">Отменить</button>
                    </div>
                </div>
            </form>
        
        
                </div>
            </div>
            @if($message)
               
            <div class="text">
                <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="closer_text"><a href="{{route('home')}}">X</a></div>
                        <div class="text_mes">
                        <div>
                            <h3>{{$from}}</h3>
                            <h5>{{substr($data, 0,19)}}</h5>
                        </div>
                       Тема: <h4>{{$subject}}</h4>
                        
                        {{$message}}
                        
                        </div>
                        <button class="reply btn btn-success">Ответить</button>
                    </div>
                </div>
            </div>
            @endif
             @if(isset($message2))
      
            <div class="text">
                <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="closer_text"><a href="{{route('home')}}">X</a></div>
                        <div class="text_mes">
                        <div>
                            <h3>{{$message2->to}}</h3>
                            <h5>{{$message2->created_at}}</h5>
                        </div>
                       <h4>Тема: {{$message2->subject}}</h4>
                        
                        {{$message2->message}}
                        
                        </div>
                        <button class="reply btn btn-success">Ответить</button>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection
