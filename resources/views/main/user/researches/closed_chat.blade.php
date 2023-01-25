@extends('main.layouts.master')
@section('title', $pageTitle)
@section('js')
<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}" defer></script>
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script>
            jQuery(document).ready(function(){
                    jQuery('#ajaxSubmit').click(function(e){
                    e.preventDefault();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    });
                    $("#chat-container").scrollTop($("#chat-container")[0].scrollHeight);
                });
    function auto_grow(element) {
        element.style.height = "5px";
        element.style.height = (element.scrollHeight)+"px";
    }
    //to calculate the time 
    var inSeconds=0;
  // Enable pusher logging - don't include this in production
  Pusher.logToConsole = false;

  var pusher = new Pusher("{{env('PUSHER_APP_KEY')}}", {
    cluster: 'eu'
  });
  let userId = "{{auth('user')->user()->id}}"
  var channel = pusher.subscribe('research-chat.'+userId);
  channel.bind('research-chat-message', function(data) {
    // alert(JSON.stringify(data));
    let message = data.message
    

    let messageContent = '';
    if(message.user_id == userId){
         messageContent = `     <div class="py-1 px-3">
                                  <div class="d-flex flex-row justify-content-start">
                                    <div class=" ml-3 user-img">
                                      <img src="{{asset('assets/images/defualt-avatar.png')}}" alt="avatar 1" >
                                    </div>
                                    <div>
                                      <a href="{{url('u/settings')}}"><p class="ms-3 m-0 rounded-3 user-name">{{ $user_researches->user->name }}</p></a>
                                      <p class="small ms-3 m-0 rounded-3 text-muted date"><i class="fa fa-clock fa-regular ml-1"></i>${parseLocalTime(message.created_at)}</p>
                                    </div>

                                  </div>
                                  <div class="chat-item">
                                    <p class="p-1 ms-3 mb-1 rounded-3 ${!isRTL(message.message) ? `text-left` : ''}" style="background-color: #f5f6f7;">${message.message}</p>
                                    </p>
                                    ${message.file !="" ? 
                                    `<a href="${message.file}" class="mb-1 small " target="_blank"> الملف المرفق</a>`
                                    : ''
                                  }
                                  </div>
                                </div>
                                <hr>`
    }else{
        messageContent = `
                                <div class="py-1  px-3">
                                <div class="d-flex flex-row justify-content-end pt-1">
                                  <div>
                                    <p class="ms-3 m-0 rounded-3 user-name">المراجع</p>
                                    <p class="small ms-3 m-0 rounded-3 text-muted date">${parseLocalTime(message.created_at)}</p>
                                  </div>
                                  <div class="user-img">
                                    <img src="{{asset('admin-assets/images/default-profile-image.png')}}" alt="avatar 2">
                                  </div>
                                 
                                </div>
                                <div class="chat-item">
                                  <p class="p-1 me-3 mb-1 text-white rounded-3 bg-primary  ${!isRTL(message.message) ? `text-left` : ''}">${message.message}</p>
                                  ${message.file !="" ? 
                                  `<a href="${message.file}" class="mb-1 small" target="_blank"> الملف المرفق</a>`
                                  : ''
                                  }
                                  </div>
                                </div>
                                <hr>`
    }
    document.querySelector('#chat-container').innerHTML+=messageContent;
    $("#chat-container").scrollTop($("#chat-container")[0].scrollHeight);
    // /stop loader
    document.querySelector('#spin-loader').classList.add('d-none')
    document.querySelector('#submit-msg-btn').classList.remove('d-none')

    //clear inputs 
    document.querySelector('textarea[name="message"]').value = ''
    document.querySelector('#research-file').value=''
    document.querySelector('#file-box').classList.add('d-none')
  });
  function parseLocalTime(date){
  
    var dif = (new Date(date) - new Date());
                var dif = Math.floor((dif/1000)/60);
                // var inSeconds = Math.floor(((dif/1000)/60)/60);

                if(dif < 10){
                  return `منذ أقل من دقيقة`
                }
                
                return `منذ ${dif} دقيقة`

               

  }

  function submitMessage(event){
    event.preventDefault()
    document.querySelector('textarea[name="message"]').style.border="none"
    
    let message = document.querySelector('textarea[name="message"]').value;
    message = replaceURLWithHTMLLinks(message)
    let research_id = document.querySelector('input[name="research_id"]').value;
    let research_file = document.querySelector('#research-file').files[0];
    if(!message.length){
        document.querySelector('textarea[name="message"]').style.border=" 1px solid red"
    }


    let formData = new FormData();

    formData.append('message', message)
    formData.append('research_id', research_id)
    if(!message.length){
        return
    }
    if(research_file){
        formData.append('file',research_file)
    }
    
    document.querySelector('#spin-loader').classList.remove('d-none')
    document.querySelector('#submit-msg-btn').classList.add('d-none')
    //calculate passed time
    var start = Date.now();
    var end = Date.now();

    jQuery.ajax({
        url: "{{userUrl('chat/store')}}",
        method: 'post',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(result){
            console.log('result',result)
            end =Date.now();
            inSeconds = end - start;
            console.log('inSeconds: ', inSeconds);

        },
        fail: function(xhr, textStatus, errorThrown){
          alert('request failed');
        }
    });

  }
  function showFileName(){
    let research_input =document.querySelector('#research-file')
    let research_file = research_input.files[0];
    let research_label = document.querySelector('label[for="research-file"]')
    let currentContent = research_label.innerHTML;
    //animation
    research_input.disabled=true;
    research_label.innerHTML='<span class="spinner-grow spinner-grow-sm ml-2" role="status" aria-hidden="true" style="    vertical-align: -0.325em;"></span>جاري الرفع ...'
    setTimeout(() => {
      research_input.disabled = false
      research_label.innerHTML = currentContent;
      document.querySelector('textarea[name="message"]').scrollIntoView()
    }, 3000);
    document.querySelector('#file-name').innerText=research_file.name
    document.querySelector('#file-size').innerText=  Math.round(research_file.size/1000) < 1000 
                                     ? Math.round(research_file.size/1000)+" KB"
                                     : Math.round(research_file.size/1000)+" MB"

    document.querySelector('#file-box').classList.remove('d-none')
  }
  function removeCurrentFile(){
    document.querySelector('#research-file').value = '';
    document.querySelector('#file-box').classList.add('d-none')
    
  }
  function changeTextDirection(event){

    event.preventDefault();

    let inputMessage = document.querySelector('textarea[name="message"]')

    if(event.target.classList.contains('fa-align-right')){
        inputMessage.classList.remove('text-right')
        inputMessage.classList.add('text-left')

        event.target.classList.remove('fa-align-right')
         event.target.classList.add('fa-align-left')
       
    }else{
        inputMessage.classList.remove('text-left')
        inputMessage.classList.add('text-right')

        event.target.classList.remove('fa-align-left')
         event.target.classList.add('fa-align-right')
    }
  }
  function replaceURLWithHTMLLinks(text)
    {
      var exp = /(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
      return text.toString().replace(exp,`<a href="$1">$1</a>`);
    }
  function isRTL(s){           
    var ltrChars    = 'A-Za-z\u00C0-\u00D6\u00D8-\u00F6\u00F8-\u02B8\u0300-\u0590\u0800-\u1FFF'+'\u2C00-\uFB1C\uFDFE-\uFE6F\uFEFD-\uFFFF',
        rtlChars    = '\u0591-\u07FF\uFB1D-\uFDFD\uFE70-\uFEFC',
        rtlDirCheck = new RegExp('^[^'+ltrChars+']*['+rtlChars+']');

    return rtlDirCheck.test(s);
}
</script>
<script type="text/javascript">
  jQuery(document).ready(function(){
             jQuery('#ajaxSubmit').click(function(e){
                e.preventDefault();
                $.ajaxSetup({
                   headers: {
                       'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                   }
               });
             });
 
           });
var delId = document.querySelectorAll(".delete-research");
delId.forEach(item => {
 item.addEventListener('click',function(e){
     e.preventDefault();
   let id = "{{$user_researches->id}}"
   let url = "{{route('research.delete_demande')}}"
 
   
     swal({
   title: 'أدخل سبب الحذف',
   dangerMode: true,
   content: "input",
   button: {
     text: "حذف",
     closeModal: false,
   },
 })
 .then(reason => {
   if (!reason) throw null;
   return jQuery.ajax({
                   url: url,
                   method: 'post',
                   data: {
                    reason : reason,
                    id:id
                   },
                   success: function(result){
 
                      if(result.message == 'ok'){
                         swal.stopLoading();
                         swal.close();
                         swal("طلب حذف الدراسة", "تم ارسال الطلب بنجاح", "success");
 
                      }
                   }});
 })
 .catch(err => {
   if (err) {
     swal("خطأ داخلي!", "حصل خطأ أثناء الارسال يرجى إعادة المحاولة مرة أخرى", "error");
   } else {
     swal.stopLoading();
     swal.close();
   }
 });
 })
})
</script> 
@endsection
@section('content')

<style>
    
    /*#journals-researches{*/
    /*    color: #007bff;*/
    /*    font-size: 18px !important;*/
    /*}*/
    
    /*#journals-researches .title {*/
    /*    color: #007bff;*/
    /*    font-size: 20px !important;*/
    /*}*/
    
    .status{
        padding: 0 20px;
        font-size: 17px !important;
    }
    .bolld{
        font-weight: 600 !important;
    }
    .ico{
        font-size:12px !important;
    }
    
    .message-s {
        display: flex;
        justify-content: flex-start;
        flex-diretion: column;
    }
    
.message-r {
  display: flex;
  justify-content: flex-end;
}

@media(min-width:992px){
    /*
    .roww{
        width:50% !important;
        margin:40 auto !important;
    }
    */
}
   
#chat2 .form-control {
border-color: transparent;
}

#chat2 .form-control:focus {
border-color: transparent;
box-shadow: inset 0px 0px 0px 1px transparent;
}

.divider:after,
.divider:before {
content: "";
flex: 1;
height: 1px;
background: #eee;
}
.user-image{
   
    height: 100%;
    border-radius: 50%;
    height: 42px;
    width: 40px;
    margin-left: 5px;
    margin-right: 2px;
    border: 2px solid #007bff;
   
}  
.admin-image{
    background: url({{env('APP_LOGO')}});
    background-position: center;
    background-size: initial;
    background-repeat: no-repeat;
}
.user-name{
    font-size: 14px;
    margin: 6px;
    font-weight: bold;
}
#exampleFormControlInput1:focus{
    background:#fff;
    border:1px solid #007bff !important;
}
textarea{
    resize: none;
    overflow: hidden;
    min-height: 50px;
    max-height: 100px;
}
#services-section img{
    width: 50px;
    height: 50px;
    margin-left: 8px;
}
@media(max-width:768px){
    .min-side-cards{
        margin-top: 2rem; 
    }
}
@media(min-width:768px){
    /* .min-side-cards{
        width: 20rem; 
    } */
}
#services-section .svg-inline--fa{
    font-size: 1.6rem;margin-right: 1.5rem!important;margin-left: 1rem!important;
}
#chat-container .bg-primary a{
  color: #fff
}
#chat-container .bg-primary a:hover{
  color: #fff;    font-weight: 600;
}
.chat-item{
  padding: 0 5px;
  overflow: hidden;
  margin-top: 15px;
}
.p-15{padding: .45rem!important;}
#chat-container p.date{
  line-height: 2.7;font-size: 0.8rem;
}
/* #chat-container hr{
  width: 110%;
    position: relative;
    right: -5%;
} */

.user-img img{
  /* position: relative;
    top: -3px; */
    width: 45px; 
}
.date .fa-clock{
  position:relative; top: 1px
}
#fixed-alert{
  width: 100%;
}
@media(min-width:768px){
  #fixed-alert{
    width: 75.5%;
    position: relative;
    right: 14px;
}
}
</style>

    <div class="clearfix"></div>
    <div class="result"></div><!-- Result Box -->


    <section id="journals-researches" class="mb-5 mt-3">
        <div class="container">
           
         <div class="row justify-content-center">
             

            
            </div>
            
            
            <div class="container px-0">
                <h4 class="mt-3 pr-4">
                        {{ $pageTitle }}</h4>
                        
                
                <div class="row d-flex justify-content-center " style="clear:both">
                    
                        
              
                    <!-- Include Aside -->
                @include('main.user.aside')
                <div class="col-sm-12 col-md-3 col-lg-3 mb-3 d-md-none">
                
                    <div class="card min-side-cards" style="">
                        <div class="card-body">
                          <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">تفاصيل المحادثة</h5>
                            <div class="dropdown mb-3" id="actions-dropdown">
                              <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="box-shadow: none">
                                  <span class="ml-2"> إجراءات</span>
                               
                              </button>
                              <div class="dropdown-menu text-center m-0 bg-light w-100" style="    min-width: 180px;" aria-labelledby="triggerId">
                                <a class="dropdown-item p-2 "
                                href="{{ userUrl('researches') }}">تقديم دراسة جديدة </a>
                                <hr class="my-0">
                                <a class="dropdown-item p-2 delete-research"
                                href="#" >طلب حذف الدراسة</a>              
                                                      

              
                              </div>
                            </div>
                          </div>
                            <hr>
                            <div class="row m-0 mb-2">
                                <div class="col-4 p-0 " style="line-height: 2">
                                    <h6 class="m-0">العنوان</h6>
                                </div>
                                <div class="col-8 text-muted pl-2">
                                    <a href="">{{ $user_researches->title }}</a>
                                </div>
                            </div>
                            <div class="row m-0 mb-2">
                                <div class="col-4 p-0 " style="line-height: 2">
                                    <h6 class="m-0">المجلة</h6>
                                </div>
                                <div class="col-8 text-muted pl-2">
                                    <a href="{{url('journal/' . $user_researches->journal->slug)}}">{{ $user_researches->journal->name }}</a>
                                </div>
                            </div>
                            <div class="row m-0 mb-2">
                                <div class="col-4 p-0 " style="line-height: 2">
                                    <h6 class="m-0">تاريخ الإرسال</h6>
                                </div>
                                <div class="col-8 text-muted pl-2">
                                  {{ Carbon\Carbon::parse($user_researches->created_at)->format('d-m-Y') }}
                                </div>
                            </div>
                            <div class="row m-0 mb-2">
                                <div class="col-4 p-0 " style="line-height: 2">
                                    <h6 class="m-0">تاريخ آخر تحديث</h6>
                                </div>
                                <div class="col-8 text-muted pl-2">
                                  {{ Carbon\Carbon::parse($user_researches->updated_at)->format('d-m-Y') }}
                                </div>
                            </div>
                        </div>
                    </div>
                
                </div> 
                <div class="col-sm-12 d-md-none">
                  <div class="alert bg-warning  my-3 " role="alert">
                    {!! \App\Models\Settings::first()->alert_in_chat !!}
                  </div>
                </div>
                <div class="col-sm-12 col-md-5 col-lg-5">
                  
                    <div class="card" id="chat2">
                        <div class="card-header d-flex justify-content-between align-items-center p-3">
                          <h5 class="mb-0">الرسائل</h5>
                          <input id="research-file" type="file" name="file" onchange="showFileName()" class="d-none" accept=".docx,.doc"">
                        </div>
                        <div class="card-body p-0" id="chat-container" data-mdb-perfect-scrollbar="true" style="position: relative; height: 400px;overflow-y:scroll">
                            @if (count($messages) > 0)
                            
                            @foreach ($messages as $row)
                              @if($row->user_id == \Auth::guard('user')->user()->id )
                                <div class="py-1 px-3">
                                  <div class="d-flex flex-row justify-content-start">
                                    <div class=" ml-3 user-img">
                                      <img src="{{asset('assets/images/defualt-avatar.png')}}" alt="avatar 1" >
                                    </div>
                                    <div>
                                      <a href="{{url('u/settings')}}"><p class="ms-3 m-0 rounded-3 user-name">{{ $user_researches->user->name }}</p></a>
                                      <p class="small ms-3 m-0 rounded-3 text-muted date"><i class="fa fa-clock fa-regular ml-1"></i>{{ parseTime($row->created_at) }}</p>
                                    </div>

                                  </div>
                                  <div class="chat-item">
                                    <p class="p-1 ms-3 mb-1 rounded-3 @if(preg_match("/^[\w\d\s.,-]*$/", $row->message))
                                      text-left
                                      @endif" style="background-color: #f5f6f7;">{!! $row->message !!}</p>
                                    </p>
                                    @if($row->file)
                                          <a href="{{$row->file}}" class="mb-1 small" target="_blank"> الملف المرفق</a>
                                    @endif
                                    
                                  </div>
                                </div>
                                <hr>
                              @else 
                               
                               <div class="py-1 px-3">
                                <div class="d-flex flex-row justify-content-end pt-1">
                                  <div>
                                    <p class="ms-3 m-0 rounded-3 user-name">المراجع</p>
                                    <p class="small ms-3 m-0 rounded-3 text-muted date">{{ parseTime($row->created_at) }}</p>
                                  </div>
                                  <div class="user-img">
                                    <img src="{{asset('admin-assets/images/default-profile-image.png')}}" alt="avatar 2">
                                  </div>
                                 
                                </div>
                                <div class="chat-item">
                                  <p class="p-1 me-3 mb-1 text-white rounded-3 bg-primary @if(preg_match("/^[\w\d\s.,-]*$/", $row->message))
                                    text-left
                                    @endif">{!! $row->message !!}</p>
                                  @if($row->file)
                                        <a href="{{$row->file}}" class="mb-1 small" target="_blank"> الملف المرفق</a>
                                  @endif
                                  
                                  </div>
                                </div>
                                <hr>
                              @endif 
                            @endforeach
        
                            @endif
              
              
                        </div>
                        <div class="card-footer text-muted d-flex justify-content-end align-items-center p-3">
        
                          <h6 style="line-height:1.5 ;color: #3e3737;
                          font-weight: bold;" class="alert bg-warning my-3  d-md-block">قام المحكم المسؤول عن مراجعة الدراسة بإغلاق هذه المحادثة</h6>
                        </div>
                    </div>
                    {{-- <div class="roww">
                            
                        
                        @if (count($messages) > 0)
                        
                            @foreach ($messages as $row)
                            
                                @if($row->user_id == \Auth::guard('user')->user()->id )
                                
                                <div class="mt-3 mr-2 message-s" style="">
                            
                                    <p class="msg px-3 py-2" style="background:#fff;border-radius:10px;max-width:80%;margin-bottom:1px !important">
                                        <small style="boder-bottom:2px solid white;font-size:10px"> انت </small><br>
                                        {!! $row->message !!}
                                    <br>
                                    @if (!empty($row->file))
                                    
                                    <a href="{{$row->file}}" target="_blank">ملفك المرسل </a>
                                    
                                    @endif
                                    <br>
                                    <span style="boder-top:1px solid white;font-size:10px">
                                        {{ parseTime($row->created_at) }}
                                    </span>
                                    
                                    </p>
                                </div><!--end message--> 
                                
                                @else
                                <div class="mt-3 mr-2 message-r" style="">
                                
                                    <p class="msg px-3 py-2" style="background:#444;border-radius:10px;max-width:80%;color:white;margin-bottom:1px !important">
                                        <small style="boder-bottom:2px solid white;font-size:10px"> المراجع </small><br>
                                        {!! $row->message !!}
                                        
                                    <br>
                                    @if (!empty($row->file))
                                    
                                    <a href="{{$row->file}}" target="_blank">اضغط لرؤية الملف </a>
                                    
                                    @endif
                                    <br>
                                    <span style="boder-top:1px solid white;font-size:10px">
                                        {{ parseTime($row->created_at) }}
                                    </span>
                                    
                                    </p>
                                </div><!--end message--> 
                                @endif
                                
                            @endforeach


                            @else
                                <div class="col-lg-8">
                                    <div class="py-1">
                                        <h5 class=" text-center">لا يوجد رسائل   !</h5>
                                    </div>
                                </div>
                            @endif
                        
                            <hr style="margin-top:50px">
                            <div class="send row" id="message" style="margin-top:10px">
                                <form style="width:100%" action="{{userUrl('chat/store')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mt-2 message col-sm-12 col-lg-8 float-right">
                                        <textarea rows="6" name="message" required minlength="2" class="form-control" style="
                                        white-space: pre-wrap;
                                        "></textarea>
                                        <input type="hidden" name="research_id" value="{{ $research_id }}">
                                    </div>
                                    
                                    <div class=" mt-2 col-sm-12 col-lg-4 float-left">
                                        <input name="file" style="background:none !important" type="file" class="form-control">
                                        <input type="submit" class="mt-2 btn btn-info" value="ارسال الرسالة">
                                    </div>
                                </form>
                            </div>
                    </div> --}}
                </div>
                <!-- part info -->
                <div class="col-sm-12 col-md-4 col-lg-4 ">
                    
                        <div class="card min-side-cards d-none d-md-block" style="">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                  <h5 class="card-title">تفاصيل المحادثة</h5>
                                  <div class="dropdown mb-3" id="actions-dropdown">
                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="box-shadow: none">
                                        <span class="ml-2"> إجراءات</span>
                                     
                                    </button>
                                    <div class="dropdown-menu text-center m-0 bg-light w-100" style="    min-width: 180px;" aria-labelledby="triggerId">
                                      <a class="dropdown-item p-2 "
                                      href="{{ userUrl('researches') }}">تقديم دراسة جديدة </a>
                                      <hr class="my-0">
                                      <a class="dropdown-item p-2 delete-research"
                                      href="#" >طلب حذف الدراسة</a>              
                                                            
  
                    
                                    </div>
                                  </div>
                                </div>
                                <hr>
                                <div class="row m-0 mb-2">
                                    <div class="col-4 p-0 " style="line-height: 2">
                                        <h6 class="m-0">العنوان</h6>
                                    </div>
                                    <div class="col-8 text-muted pl-2">
                                        <a href="{{route('current_user_researches',['id'=>$user_researches->id])}}">{{ $user_researches->title }}</a>
                                    </div>
                                </div>
                                <div class="row m-0 mb-2">
                                    <div class="col-4 p-0 " style="line-height: 2">
                                        <h6 class="m-0">المجلة</h6>
                                    </div>
                                    <div class="col-8 text-muted pl-2">
                                        <a href="{{url('journal/' . $user_researches->journal->slug)}}">{{ $user_researches->journal->name }}</a>
                                    </div>
                                </div>
                                <div class="row m-0 mb-2">
                                    <div class="col-4 p-0 " style="line-height: 2">
                                        <h6 class="m-0">تاريخ الإرسال</h6>
                                    </div>
                                    <div class="col-8 text-muted pl-2">
                                      {{ Carbon\Carbon::parse($user_researches->created_at)->format('d-m-Y') }}
                                    </div>
                                </div>
                                <div class="row m-0 mb-2">
                                    <div class="col-4 p-0 " style="line-height: 2">
                                        <h6 class="m-0">تاريخ آخر تحديث</h6>
                                    </div>
                                    <div class="col-8 text-muted pl-2">
                                      {{ Carbon\Carbon::parse($user_researches->updated_at)->format('d-m-Y') }}
                                    </div>
                                </div>
                                {{-- actions --}}
                               
                            </div>
                        </div>
                        <div class="alert bg-warning my-3 d-none d-md-block" role="alert">
                          {!! \App\Models\Settings::first()->alert_in_chat !!}
                        </div>
                        <div class="card mt-3 min-side-cards" id="services-section" style="">
                            <h5 class="card-header">خدمات تهمك</h5>
                            <ul class="list-unstyled">
                                @if($services)
                                @foreach($services as $service)
                                <li class="media mt-3 mb-2 align-items-center">
                                  {{-- <img class="mr-3 mt-2 " src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%2264%22%20height%3D%2264%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2064%2064%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_183af373011%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A10pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_183af373011%22%3E%3Crect%20width%3D%2264%22%20height%3D%2264%22%20fill%3D%22%23777%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%2213.547256469726562%22%20y%3D%2236.5%22%3E64x64%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" alt="Generic placeholder image"> --}}
                                    {{-- <i class="fa fa-book  fa-2x mx-3 mr-4 align-self-cente "></i> --}}
                                    {!!$service->icon!!}
                                  <div class="media-body ml-2">
                                    <a href="{{$service->link}}" class="mt-0 mb-1 font-weight-bold text-uppercase " style="font-size: 0.9rem;">{{$service->name}}</a>
                                    {{-- <p style="font-size: 0.9rem">بعض الوصف حق الخدمة هنا يسبسيب سيبسيب</p> --}}
                                    
                                  </div>
                                </li>
                                @if(!$loop->last)
                                <hr class="m-0">
                                @endif
                                @endforeach
                                @endif
                                
                              </ul>
                        </div>
                        <div class="card mt-3 min-side-cards" id="services-section" style="">
                            <h5 class="card-header">مقالات مفيدة</h5>
                            <ul class="list-unstyled">
                                  @if($articles)
                                @foreach($articles as $art)
                                <li class="media mt-3 mb-1 mx-2">
                                  {{-- <img class="mr-3 mt-2 " src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%2264%22%20height%3D%2264%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2064%2064%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_183af373011%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A10pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_183af373011%22%3E%3Crect%20width%3D%2264%22%20height%3D%2264%22%20fill%3D%22%23777%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%2213.547256469726562%22%20y%3D%2236.5%22%3E64x64%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" alt="Generic placeholder image"> --}}
                                  <div class="media-body">
                                    <a target="_blink" href="{{url("article/$art->slug")}}" class="mt-0 mb-1 font-weight-bold text-uppercase mr-3 " style="font-size: 0.9rem;">{{$art->title}}</a>
                                    {{-- <p style="font-size: 0.9rem">بعض الوصف حق الخدمة هنا يسبسيب سيبسيب</p> --}}
                                    
                                  </div>
                                </li>
                                @if(!$loop->last)
                                <hr class="m-0">
                                @endif
                                @endforeach
                                @endif
                                                            
                              </ul>
                        </div>
                    
                </div>
            
            </div>
            </div>

        </div>
        
    </section>
    {{-- <section style="background-color: #eee;">
        <div class="container py-5">
      
          <div class="row d-flex justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-6">
      
              <div class="card" id="chat2">
                <div class="card-header d-flex justify-content-between align-items-center p-3">
                  <h5 class="mb-0">الرسائل</h5>
                  <button type="button" class="btn btn-info btn-sm" data-mdb-ripple-color="dark">
                    <i class="fa fa-file-upload ml-2"></i>
                    ارفاق تعديل الدراسة
                  </button>
                </div>
                <div class="card-body" data-mdb-perfect-scrollbar="true" style="position: relative; height: 400px;overflow:scroll">
                    @if (count($messages) > 0)
                    
                    @foreach ($messages as $row)
                      @if($row->user_id == \Auth::guard('user')->user()->id )
                        <div class="d-flex flex-row justify-content-start">
                            <div class="user-name ml-3">أنت</div>
                            <div>
                            <p class="p-1 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;">{!! $row->message !!}</p>
                            </p>
                            <p class="small ms-3 mb-3 rounded-3 text-muted">{{ parseTime($row->created_at) }}</p>
                            </div>
                        </div>
                      @else 
                        <div class="d-flex flex-row justify-content-end mb-4 pt-1">
                            <div class="">
                            <p class="p-1 me-3 mb-1 text-white rounded-3 bg-primary">{!! $row->message !!}</p>
                            <p class="small me-3 mb-3 rounded-3 text-muted d-flex justify-content-end">{{ parseTime($row->created_at) }}</p>
                            </div>
                            <div class="user-name">المراجع</div>
                        </div>
                      @endif 
                    @endforeach

                    @endif
      
      
                </div>
                <div class="card-footer text-muted d-flex justify-content-end align-items-center p-3">

                  <input type="text" class="form-control form-control-lg" id="exampleFormControlInput1"
                    placeholder="ادخل الرسالة">
                  
                  <a class="ms-3" href="#!"><i class="fas fa-paper-plane" style="font-size: 23px;
                    margin: 0 9px;"></i></a>
                </div>
              </div>
      
            </div>
          </div>
      
        </div>
    </section> --}}
<script>
    window.scrollTo(0, document.body.scrollHeight || document.documentElement.scrollHeight);

</script>



@endsection

