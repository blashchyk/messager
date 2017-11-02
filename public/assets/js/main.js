$(document).ready(function(){
    $('a.show').on('click', function(e){
        e.preventDefault();
        $('.message').slideDown("slow");
    });
    $('.close').on('click', function(){
        $('.message').slideUp(300);
    });
    var display = $('.messages').css('display');
    if(display === 'block'){
        $('.messages').slideDown("slow");
        $('.messages').slideUp(2000);
    }

   $('.closer_text').on('click', function(){
       $('.text').css('display', 'none');
   });
   $('.reply').on('click', function(){
       var from = $('.text_mes div h3').text();
       var subject = $('.text_mes h4').text();
       
       $('.message input[name=email]').val(from);
       $('.message input[name=subject]').val(subject);
       $('.text').css('display', 'none');
       $('.message').slideDown("slow");
   });
    $('.outgoing').on('click', function(e){
        e.preventDefault();
        $('.messages_body').css('display', 'none');
        $('.messages_body2').css('display', 'block');
        
    });
    $('.incoming').on('click', function(){
        $('.messages_body').css('display', 'block');
        $('.messages_body2').css('display', 'none');
    });
    $('.messages_body').on('click', 'input',function(){
        var inputs = $('.messages_body input:checked').val();
        if(inputs){
            $('.delete').slideDown("slow");
        }else{
            $('.delete').slideUp(2000);
        }
    });
    $('.messages_body2').on('click', 'input',function(){
     
        var inputs = $('.messages_body2 input:checked').val();
        if(inputs){
            $('.delete2').slideDown("slow");
        }else{
            $('.delete2').slideUp(2000);
        }
    });
    
});