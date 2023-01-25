@extends('admin.layouts.master')
@section('title', $pageTitle)
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
    
    .roww{
        width:50% !important
    }
}
</style>

   
    <h4 class=" float-right mt-3">
        {{ $pageTitle }}</h4>
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
            
            
            <div class="container">
                
                <div class="roww">
                    
                    @if (count($messages) > 0)
                    
                        @foreach ($messages as $row)
                        
                            @if($row->user_id == 1 )
                            
                            <div class="mt-3 mr-2 message-s" style="">
                        
                                <p class="msg px-3 py-2" style="background:#444;border-radius:10px;max-width:80%;color:white;margin-bottom:1px !important">
                                    <small style="boder-bottom:2px solid white;font-size:10px"> المراجع </small><br>
                                    {{ $row->message}} 
                                <br>
                                <span style="boder-top:1px solid white;font-size:10px">
                                    {{ parseTime($row->created_at) }}
                                </span>
                                
                                </p>
                            </div><!--end message--> 
                            
                            @else
                            <div class="mt-3 mr-2 message-r" style="">
                            
                                <p class="msg px-3 py-2" style="background:#fff;border-radius:10px;max-width:80%;margin-bottom:1px !important">
                                    <small style="boder-bottom:2px solid white;font-size:10px"> العميل </small><br>
                                    {{ $row->message}}  
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
                        <div class="send row" style="margin-top:10px">
                            <form style="width:100%" action="{{adminUrl('users/chat/store')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mt-2 message col-sm-12 col-lg-8 float-right">
                                    <textarea rows="6" name="message" class="form-control"></textarea>
                                    <input type="hidden" name="research_id" value="{{ $research_id }}">
                                </div>
                                
                                <div class=" mt-2 col-sm-12 col-lg-4 float-left">
                                    <input name="file" style="background:none !important" type="file" class="form-control">
                                    <input type="submit" class="mt-2 btn btn-info" value="ارسال الرسالة">
                                </div>
                            </form>
                            
                        </div>
                </div>
            
            </div>

        </div>
    </section>




@endsection
