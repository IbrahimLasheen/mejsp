@extends('admin.layouts.master')
@section('title', $pageTitle)
@section('js')

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

Pusher.logToConsole = false;

var pusher = new Pusher("{{env('PUSHER_APP_KEY')}}", {
  cluster: 'eu'
});

var channel = pusher.subscribe('research-chat.'+"{{$user_researches->user_id}}");
channel.bind('research-chat-message', function(data) {
//   alert(JSON.stringify(data));
let message = data.message


let messageContent = '';
if(message.user_id == 1){
 messageContent = `         <div class="py-1 px-3">
                                        <div class="d-flex flex-row justify-content-start">
                                          <div class=" ml-3 user-img">
                                            <img src="{{asset('admin-assets/images/default-profile-image.png')}}" alt="avatar 2">
                                          </div>
                                          <div>
                                            <p class="ms-3 m-0 rounded-3 user-name">أنت</p>
                                            <p class="small ms-3 m-0 rounded-3 text-muted date"><i class="fa fa-clock fa-regular ml-1"></i>${parseLocalTime(message.created_at)}</p>
                                          </div>
      
                                        </div>
                                        <div class="chat-item">
                                          <p class="p-1 ms-3 mb-1 rounded-3 ${!isRTL(message.message) ? `text-left` : ''}" style="background-color: #f5f6f7;">${message.message}</p>
                                          </p>
                                          ${message.file !="" ? 
                                          `<a href="${message.file}" class="mb-1 small" target="_blank"> الملف المرفق</a>`
                                                : ''
                                        }
                                          
                                        </div>
                                    </div>
                                    <hr>`
}else{
messageContent = `          <div class="py-1 px-3">
                                        <div class="d-flex flex-row justify-content-end pt-1">
                                          <div>
                                            <a href="{{ adminUrl('users/show/'.$user_researches->user->id)}}"><p class="ms-3 m-0 rounded-3 user-name">{{ $user_researches->user->name }} </p></a>
                                            <p class="small ms-3 m-0 rounded-3 text-muted date">${parseLocalTime(message.created_at)}</p>
                                          </div>
                                          <div class="user-img mr-2">
                                            <img src="{{asset('assets/images/defualt-avatar.png')}}" alt="avatar 1" >
                                          </div>
                                         
                                        </div>
                                        <div class="chat-item">
                                          <p class="p-1 me-3 mb-1 text-white rounded-3 bg-primary ${!isRTL(message.message) ? `text-left` : ''}">${message.message}</p>
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
url: "{{adminUrl('users/chat/store')}}",
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
    // let currentContent = research_label.innerHTML;
    //animation
    research_input.disabled=true;
    research_label.innerHTML='<span class="spinner-grow spinner-grow-sm mr-2" role="status" aria-hidden="true" style="    vertical-align: -0.325em;"></span>'
    setTimeout(() => {
      research_input.disabled = false
       // research_label.innerHTML = currentContent;
      document.querySelector('textarea[name="message"]').scrollIntoView()
    }, 2000);
   

    document.querySelector('#file-name').innerText=research_file.name
    document.querySelector('#file-size').innerText=  Math.round(research_file.size/1000) < 1000 
                                     ? Math.round(research_file.size/1000)+" KB"
                                     : Math.round(research_file.size/1000)+" MB"

    document.querySelector('#file-box').classList.remove('d-none')
    const reader = new FileReader()

reader.addEventListener('load', function(event) {
    let research_label = document.querySelector('label[for="research-file"]')
    research_label.innerHTML =`<i class="fa fa-file-upload mr-3" id="file-uploader" style="font-size: 23px;cursor:pointer;
                                margin: 0 2px;    position: relative;top: 4px;"></i>`
})

// Files can be read with the readAs[ArrayBuffer|BinaryString|DataURL|Text] methods
reader.readAsArrayBuffer(research_file)
reader.addEventListener('progress', event => {
   
    const percent = Math.round((event.loaded / event.total) * 100)
        const loadingBar = Array(10)
            .fill('▒')
            .map(function(item, index) {
                document.querySelector('#upload-progress .progress-bar').style.width=Math.round(percent)+"%"
              
               return Math.round(percent / 10) > index ? '█'
                : '▒'   
            } )
            .join('')

        // document.location.hash = `${loadingBar}(${percent}%)`
        

})
// reader.readAsBinaryString(research_file)
// reader.readAsDataURL(research_file)
// reader.readAsText(research_file)
  }
  function removeCurrentFile(){
    document.querySelector('#research-file').value = '';
    document.querySelector('#file-box').classList.add('d-none')
    document.querySelector('#upload-progress .progress-bar').style.width="0%"
    document.querySelector('#file-name').innerText=''
    document.querySelector('#file-size').innerText=''
    let research_label = document.querySelector('label[for="research-file"]')
    research_label.innerHTML =`<i class="fa fa-file-upload mr-3" id="file-uploader" style="font-size: 23px;cursor:pointer;
                                margin: 0 2px;    position: relative;top: 4px;"></i>`
    
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
function deleteSearch(event){
    event.preventDefault();
  let id = event.target.getAttribute('data-researchid')
  let url = event.target.getAttribute('data-url')
  console.log('url: ', url);


  
    swal({
  title: 'أدخل سبب الحدف',
  dangerMode: true,
  content: "input",
  button: {
    text: "حدف",
    closeModal: false,
  },
})
.then(reason => {
    console.log('df')
  if (!reason) throw null;
  return jQuery.ajax({
                  url: url,
                  method: 'delete',
                  data: {
                   reason : reason,
                   id:id
                  },
                  success: function(result){
                    
                     if(result.message == 'deleted'){
                        swal.stopLoading();
                        swal.close();
                        swal("حدف الطلب", "تم حدف الطلب ينجاح", "success");
                        window.location.href = "{{ adminUrl('users/user-researches') }}";

                     }
                  }});
//   return fetch(`https://itunes.apple.com/search?term=${name}&entity=movie`);
})
.catch(err => {
  if (err) {
    swal("Oh noes!", "The AJAX request failed!", "error");
  } else {
    swal.stopLoading();
    swal.close();
  }
});
}
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
.left-side-boxes{
    margin-top: 1rem;
}
@media(min-width:992px){
    /*
    .roww{
        width:50% !important
    }
    */ 
    .left-side-boxes{
        margin-top: 0;
    }
    
}
.bg-primary.text-white a{
    color: #fff;
}
#actions-dropdown .dropdown-menu.show  {
    margin: 0
}
.left-side-boxes .card-body button{
    min-width: 52px;
}
.left-side-boxes hr{
    width: 110%;
    margin-right: -5%;
    margin-bottom: 2rem;
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
.p-1.5{padding: .45rem!important;}
.user-img img{
  /* position: relative;
    top: -3px; */
    width: 45px; 
}
.date .fa-clock{
  position:relative; top: 1px;width: auto !important;
}
.user-name{
    font-size: 14px;
    margin: 6px;
    font-weight: bold;
}
</style>


    <div class="d-flex justify-content-between mb-5">
        <h4 class=" float-right mt-3">
            {{ $pageTitle }}</h4>
        <div class="dropdown  float-left mt-3" id="actions-dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="box-shadow: none">
                    <i class="fa fa-sort-desc ml-3 "></i>
                    تعديل حالة الطلب
                    <i class="fa fa-pencil-square mr-2 " style="    position: relative;
                    top: 2px;"></i>
                </button>
                <div class="dropdown-menu text-right" aria-labelledby="triggerId">
                                            
                                        
                    @if ($user_researches->status == 1)
                    
                        <a class="dropdown-item"
                            href="{{ adminUrl('users/user-researches/edit/2/' . $user_researches->id) }}">تم التحويل للمراجعة </a>
                            
                        <a class="dropdown-item"
                            href="{{ adminUrl('users/user-researches/edit/3/' . $user_researches->id) }}">مقبول</a>
                            
                        <a class="dropdown-item"
                            href="{{ adminUrl('users/user-researches/edit/4/' . $user_researches->id) }}">مرفوض</a>
                            
                        <a class="dropdown-item"
                            href="{{ adminUrl('users/user-researches/edit/5/' . $user_researches->id) }}">مطلوب تعديل</a>

                        <div class="dropdown-divider"></div>

                        <form class="dropdown-item delete d-inline-block"
                            action="{{ adminUrl('users/user-researches/destroy') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" value="{{ $user_researches->id }}" required>
                            <button  class="d-block w-100 text-right" id="delete-research-by-id" data-researchid="{{ $user_researches->id }}" onclick="deleteSearch(event)" data-url="{{ adminUrl('users/user-researches/destroy') }}">حذف</button>
                        </form>
                    
                    @elseif ($user_researches->status == 2)
                        
                        <a class="dropdown-item"
                            href="{{ adminUrl('users/user-researches/edit/3/' . $user_researches->id) }}">مقبول</a>
                            
                        <a class="dropdown-item"
                            href="{{ adminUrl('users/user-researches/edit/4/' . $user_researches->id) }}">مرفوض</a>
                            
                        <a class="dropdown-item"
                            href="{{ adminUrl('users/user-researches/edit/5/' . $user_researches->id) }}">مطلوب تعديل</a>

                        <div class="dropdown-divider"></div>

                        <form class="dropdown-item delete d-inline-block"
                            action="{{ adminUrl('users/user-researches/destroy') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" value="{{ $user_researches->id }}" required>
                            <button  class="d-block w-100 text-right" id="delete-research-by-id" data-researchid="{{ $user_researches->id }}" onclick="deleteSearch(event)" data-url="{{ adminUrl('users/user-researches/destroy') }}">حذف</button>
                        </form>
                        
                    @elseif ($user_researches->status == 3 || $user_researches->status == 4)
                        
                        <div class="dropdown-divider"></div>

                        <form class="dropdown-item delete d-inline-block"
                            action="{{ adminUrl('users/user-researches/destroy') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" value="{{ $user_researches->id }}" required>
                            <button  class="d-block w-100 text-right" id="delete-research-by-id"  onclick="deleteSearch(event)"  data-researchid="{{ $user_researches->id }}" data-url="{{ adminUrl('users/user-researches/destroy') }}">حذف</button>
                        </form>
                        
                    @elseif ($user_researches->status == 5)
                        
                        <a class="dropdown-item"
                            href="{{ adminUrl('users/user-researches/edit/3/' . $user_researches->id) }}">مقبول</a>
                            
                        <a class="dropdown-item"
                            href="{{ adminUrl('users/user-researches/edit/2/' . $user_researches->id) }}">تم التحويل للمراجعة </a>

                        <div class="dropdown-divider"></div>

                        <form class="dropdown-item delete d-inline-block"
                            action="{{ adminUrl('users/user-researches/destroy') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" value="{{ $user_researches->id }}" required>
                            <button   class="d-block w-100 text-right" onclick="deleteSearch(event)" id="delete-research-by-id" data-researchid="{{ $user_researches->id }}" data-url="{{ adminUrl('users/user-researches/destroy') }}">حذف</button>
                        </form>
                    @endif

                </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="result"></div><!-- Result Box -->


    <section id="journals-researches" class="mb-5 mt-3">
        <div class="row justify-content-center">

            <div class="col-12">
                @if (session()->has('deleteMessage'))
                    <div class="alert  box-success alert-dismissible fade show" role="alert">
                        {{ session()->get('deleteMessage') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
            </div>
            
            
            <div class="container p-1.5">
                <div class="row justify-content-center">
                    <div class="col-sm-12  col-lg-7">
                        <div class="card" id="chat2">
                            <div class="card-header d-flex justify-content-between align-items-center p-3">
                              <h5 class="mb-0">الرسائل</h5>
                             
                            </div>
                            <div class="card-body p-0" id="chat-container" data-mdb-perfect-scrollbar="true" style="position: relative; height: 400px;overflow-y:scroll">
                                @if (count($messages) > 0)
                                
                                @foreach ($messages as $row)
                                  @if($row->user_id == 1 )
                                    {{-- <div class="d-flex flex-row justify-content-start">
                                        <div class="user-name  ml-3">أنت</div>
                                        <div class="chat-item">
                                        <p class="p-1 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;">{!! $row->message !!}</p>
                                        </p>
                                        @if($row->file)
                                          <a href="{{$row->file}}" class="mb-1"  target="_blank"> الملف المرفق</a>
                                        @endif
                                        <p class="small ms-3 mb-3 rounded-3 text-muted">{{ parseTime($row->created_at) }}</p>
                                        </div>
                                    </div> --}}
                                    <div class="py-1 px-3">
                                        <div class="d-flex flex-row justify-content-start">
                                          <div class=" ml-3 user-img">
                                            <img src="{{asset('admin-assets/images/default-profile-image.png')}}" alt="avatar 2">
                                          </div>
                                          <div>
                                            <p class="ms-3 m-0 rounded-3 user-name">أنت</p>
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
                                    {{-- <div class="d-flex flex-row justify-content-end mb-4 pt-1">
                                        <div class="chat-item">
                                        <p class="p-1 me-3 mb-1 text-white rounded-3 bg-primary">{!! $row->message !!}</p>
                                        @if($row->file)
                                          <a href="{{$row->file}}" class="mb-1" target="_blank"> الملف المرفق</a>
                                        @endif
                                        <p class="small me-3 mb-3 rounded-3 text-muted d-flex justify-content-end">{{ parseTime($row->created_at) }}</p>
                                        </div>
                                        <div class="user-name mr-3">العميل</div>
                                    </div> --}}
                                    <div class="py-1 px-3">
                                        <div class="d-flex flex-row justify-content-end pt-1">
                                          <div>
                                            <a href="{{ adminUrl('users/show/'.$user_researches->user->id)}}"><p class="ms-3 m-0 rounded-3 user-name">{{ $user_researches->user->name }} </p></a>
                                            <p class="small ms-3 m-0 rounded-3 text-muted date">{{ parseTime($row->created_at) }}</p>
                                          </div>
                                          <div class="user-img mr-2">
                                            <img src="{{asset('assets/images/defualt-avatar.png')}}" alt="avatar 1" >
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
            
                              <textarea type="text" name="message" required minlength="2" oninput="auto_grow(this)" class="form-control form-control-lg" id="exampleFormControlInput1"
                                placeholder="ادخل الرسالة"></textarea>
                                <input type="hidden" name="research_id" value="{{ $research_id }}">
                                {{-- upload file --}}
                                
                                 <label for="research-file" class="m-0"  data-mdb-ripple-color="dark">
                                    <i class="fa fa-file-upload mr-3" id="file-uploader" style="font-size: 23px;cursor:pointer;
                                margin: 0 2px;    position: relative;top: 4px;"></i>
                                   
                                  </label>
                                  <input id="research-file" type="file" name="file" onchange="showFileName()" class="d-none" accept="*"">

                                {{-- direction --}}
                                <i class="fa fa-align-right mr-3" id="direction-btn" onclick="changeTextDirection(event)" style="font-size: 23px;cursor:pointer;
                                margin: 0 2px;"></i>
                                {{-- submit message --}}
                              <a class="" href="#!" id="submit-msg-btn" onclick="submitMessage(event)"><i class="fas fa-paper-plane" style="font-size: 23px;position: relative;
                                top: 4px;
                                margin: 0 9px;"></i></a>
                                <div class="spinner-border text-primary mr-2 d-none" role="status" id="spin-loader">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                            <div class="card-footer p-3 d-none" id="file-box">
                                <div class="d-flex justify-content-between mx-3 mb-2 align-items-center" style="font-size: 13px;">
                                    <span class="d-block d-md-flex" style="flex: 1">
                                        <span id="file-name" class="mx-2 font-weight-bold">ملف.ييخؤس</span>
                                        <span class="mx-2 mx-md-0">حجم الملف : <strong id="file-size">25kb</strong></span>
                                    </span>
                                    <button id="remove-file" onclick="removeCurrentFile()" class="btn btn-danger btn-sm p-1">
                                        X 
                                        حذف
                                    </button>
                                </div>
                                <div class="progress mx-3" id="upload-progress">
                                    <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 0%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                  </div>
                            </div>
                        </div>

                </div>
                
                <div class="col-sm-12 col-lg-5 left-side-boxes">
                      <div class="card ">
                        <div class="card-body">
                            <h5 class="card-title">تفاصيل المحادثة</h5>
                            <hr>
                            
                                
                                <div class="row m-0 mb-2">
                                    <div class="col-5 p-0 " style="line-height: 2">
                                        <h6 class="m-0"> العنوان  </h6>
                                    </div>
                                    <div class="col-7 text-muted pl-2">
                                        {{ $user_researches->title }}
                                    </div>
                                </div>
                                <div class="row m-0 mb-2">
                                    <div class="col-5 p-0 " style="line-height: 2">
                                        <h6 class="m-0"> المجلة   </h6>
                                    </div>
                                    <div class="col-7 text-muted pl-2">
                                        <a target="_blink" href="{{url('journal/' . $user_researches->journal->slug)}}">{{ $user_researches->journal->name }}</a>
                                    </div>
                                </div>
                                <div class="row m-0 mb-2">
                                    <div class="col-5 p-0 " style="line-height: 2">
                                        <h6 class="m-0">  تاريخ الإرسال   </h6>
                                    </div>
                                    <div class="col-7 text-muted pl-2">
                                        {{ Carbon\Carbon::parse($user_researches->created_at)->format('d-m-Y') }}
                                    </div>
                                </div>
                                {{-- <h6 class="card-subtitle mb-2 mt-2 text-muted"> تاريخ آخر تحديث : {{ Carbon\Carbon::parse($user_researches->updated_at)->format('d-m-Y') }} </h6> --}}
                                <div class="row m-0 mb-2">
                                    <div class="col-5 p-0 " style="line-height: 2">
                                        <h6 class="m-0">  تاريخ آخر تحديث    </h6>
                                    </div>
                                    <div class="col-7 text-muted pl-2">
                                        {{ Carbon\Carbon::parse($user_researches->updated_at)->format('d-m-Y') }}
                                    </div>
                                </div>
                                <div class="row m-0 mb-2">
                                    <div class="col-5 p-0 " style="line-height: 2">
                                        <h6 class="m-0"> المؤلف  </h6>
                                    </div>
                                    <div class="col-7 text-muted pl-2">
                                        <a href="{{ adminUrl('users/show/'.$user_researches->user->id)}}">{{$user_researches->user->name}}</a>
                                    </div>
                                </div>
                                <div class="row m-0 mb-2">
                                    <div class="col-5 p-0 " style="line-height: 2">
                                        <h6 class="m-0">  البريد الالكتروني   </h6>
                                    </div>
                                    <div class="col-7 text-muted pl-2">
                                        <a href="mailto:{{$user_researches->user->email}}">{{ $user_researches?->user->email }}</a>
                                    </div>
                                </div>
                               

                        </div>
                      </div>
                      <div class="card mt-3 " >
                        <div class="card-body">
                            <h5 class="card-title">الاجراءات</h5>
                            <hr>
                            {{-- <div class="row m-0 mb-2">
                                <div class="col-8 p-0 " style="line-height: 2">
                                 حذف الدراسة
                                </div>
                                <div class="col-4">
                                    <button type="button" class="btn btn-outline-danger btn-sm bg-default">حذف</button>
                                </div>
                            </div>
                            <div class="row m-0 mb-2">
                                <div class="col-8 p-0" style="line-height: 2">
                                 تعديل حالة الطلب  
                                </div>
                                <div class="col-4">
                                    <button type="button" class="btn btn-outline-info btn-sm bg-default">تعديل</button>
                                </div>
                            </div> --}}
                            <div class="row m-0 mb-2">
                                <span class="col-5 p-0">حالة الفاتورة </span>
                                <div class="col-7 ">
                                           
                                    @if ($user_researches->status == 3)
                                        <span class="  @if($user_researches?->invoice?->payment_response == 0) text-danger @else text-success  @endif font-weight-bold ml-3">
                                            @if ($user_researches->invoice)
                                                {{ $user_researches->invoice->payment_response == 0 ? 'غير مدفوع' :                                                        'مدفوع'}}
                                            @else
                                                غير مدفوع  
                                            @endif
                                            
                                        </span>
                                        
                                        @if($user_researches->invoice)
                                            @if ($user_researches->invoice->payment_response == 0)
                                                @if (time() > $user_researches->invoice->ending)
                                                    <form class=" d-inline-block" action="{{ adminUrl('invoices/active') }}"
                                                        method="POST">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $user_researches->invoice->id }}" required>
                                                        <button type="submit" id="activate-facture" class="btn btn-outline-secondary btn-sm pb-0 d-block mt-2"><i
                                                                class="fa-solid fa-repeat ml-1"></i>إعادة تنشيط الفاتورة</button>
                                                    </form>
                                                @else
                                                    <span class=" text-success  @endif font-weight-bold d-block mt-2">فاتورة نشطة</span>
                                                @endif
                                            @else
                                                <span>لايوجد</span>
                                            @endif
                                        @else 
                                          <span>لاتوجد فاتورة</span>
                                        @endif
                                       
                                        @if($user_researches->id == session('id_send'))
                                                
                                            @if($errors->any())
                                                @foreach($errors->all() as $error)
                                                <ul style="list-style: none;padding: 0;">
                                                <li class="alert alert-danger mt-2 mb-2">{{$error}}</li>
                                                </ul>
                                                @endforeach
                                            @endif
                                            @if(session('success'))
                                                <div class="alert  alert-success alert-dismissible fade show" role="alert">
                                                    {{session('success')}} 
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                            @endif
                                    
                                    
                                                
                                            <form method="POST" class="mt-3 d-none" action="{{route('send_facture') }}">
                                                @csrf
                                                <div class="form-group">
                                                    <input type="hidden" value="{{$user_researches->id}}" name="research_id">
                                                    <input type="url" required placeholder="أدخل رابط الفاتورة ......."  class="form-control" name="link">
                                                        <button class="btn btn-info mt-2 text-white" type="submit">أرسل</button>
                                                </div>
                                            </form>
                                    @endif 
                                </div>
                                <div class="clearfix"></div>
                            </div>

                        </div>
                      </div>
                     
                </div>
            
            </div>
            </div>

        </div>
    </section>
<script>
    window.scrollTo(0, document.body.scrollHeight || document.documentElement.scrollHeight);

</script>



@endsection
