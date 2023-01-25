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
    #journals-researches .dropdown {
        left: 2rem;
        top: 2.5rem;
    }
    #journals-researches svg, #journals-researches i {
    font-size: 16px;
    }
    .status{
        padding: 0 10px;
        font-size: 17px !important;
    }
    .bolld{
        font-weight: 600 !important;
    }
    .ico{
        font-size:12px !important;
    }
    @media(max-width:500px){
        .facture-box{
            padding-left: 0 !important;
        }
        .facture-box span{
            white-space: nowrap
        }
        .row.my-3{
            padding-left: 0 !important;
        }
    }
    .chip {
    display: inline-block;

    border-radius: 19px;
    background-color: #f1f1f1;
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


                <div class="col-lg-10">
                    <div class="row">
                        
                            @php 
                                $value = \App\Models\Message::where(['a_show' => 0, 'research_id'=>$research->id ])->get();
                                $value = $value->count();
                            @endphp
                            <div class="col-12 mb-4">
                                <div class="box-white pl-4">
                                    
                                
                                    <div class="mb-2 mt-3 mb-4 d-flex  align-items-center">
                                        <i class="fa-solid fa-user bg-warning rounded" style="padding: 0.7rem;"></i> 
                                         <span class=" font-weight-bold" style="font-size: 1.1rem;">
                                            <a href="{{ adminUrl('users/show/'.$research->user->id)}}">{{$research->user->name}}</a>
                                             |
                                             <a href="mailto:{{$research->user->email}}">{{$research->user->email}}</a>
                                            </span>
                                    </div>
                                    <div class="row my-3 px-5">
                                        <div class="col-4 p-0 bolld " >
                                            عنوان البحث 
                                        </div>
                                        <div class="col-8">
                                            <span class=" 
                                            @if(preg_match("/^[\w\d\s.,-]*$/", $research->title))
                                            text-left
                                            @endif">{{ $research->title }}</span>
                                        </div>
                                    </div>
                                    <div class="row my-3 px-5">
                                        <div class="col-4 p-0 bolld  " >
                                            نوع البحث 
                                        </div>
                                        <div class="col-8">
                                            <span > 
                                                @if ($research->type == 0)
                                                {{ 'مفتوح المصدر' }}
                                                @else
                                                    {{ 'مقيد الوصول' }}
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row my-3 px-5">
                                        <div class="col-4 p-0 bolld  " >
                                            تاريخ الارسال  
                                        </div>
                                        <div class="col-8">
                                            <span > 
                                                {{ parseTime($research->created_at) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row my-3 px-5">
                                        <div class="col-4 p-0 bolld  " >
                                            تاريخ آخر تعديل  
                                        </div>
                                        <div class="col-8">
                                            <span > 
                                                {{ parseTime($research->updated_at) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row my-3 px-5">
                                        <div class="col-4 p-0 bolld  " >
                                            المجلة 
                                        </div>
                                        <div class="col-8">
                                            <span > 
                                                {{ $research->journal ? $research->journal->name : 'تم حذف المجله' }}
                                            </span>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row my-3 px-5">
                                        <div class="col-4 p-0 bolld  " >
                                            الكلمات المفتاحية  
                                        </div>
                                        <div class="col-8">
                                            {{-- @if( strpos($research->keywords, '،') !== false )
                                                @foreach(explode('،',$research->keywords) as $keyword)
                                                <span class="badge badge-pill badge-secondary mx-1 p-2 my-1" style="font-size: 0.9rem">{{  $keyword}}</span>
                                                @endforeach
                                            @else
                                            <span class=" mx-1 p-2 my-1" style="font-size: 0.9rem">{{  $research->keywords}}</span>
                                            @endif --}}
                                            @if($research->keywords)
                                            @foreach (explode(',',$research->keywords) as $k)
                                              <div class="chip mx-1 px-2 mt-1 keyword-element" >
                                                  {{$k}}                                                      
                                              </div>
                                            @endforeach
                                          @endif
                                        </div>
                                    </div>
                                    
                                    <hr>
                                    <div class="row my-3 px-5">
                                        <div class="col-4 p-0 bolld  " >
                                            حالة الطلب الحالية 
                                        </div>
                                        <div class="col-8">
                                            @if ($research->status == 1)
                                                <span class="ml-2"  style="line-height:2">قيد المعالجة </span>
                                            @elseif ($research->status == 2)
                                                <span class="ml-2"  style="line-height:2">تم التحويل للمراجعة </span>
                                            @elseif ($research->status == 3)
                                                <span class="ml-2"  style="line-height:2" >مقبول </span> 
                                            @elseif ($research->status == 4)
                                               <span class="ml-2"  style="line-height:2">مرفوض </span>
                                            @elseif ($research->status == 5)
                                              <span class="d-flex justify-content-start">
                                                <span class="ml-2"  style="line-height:2"> مطلوب تعديل </span>
                                                
                                              </span>
                                              <a href="{{ adminUrl('users/chat/'.$research->id)}}" class="bolld" style="    padding-top: 3px;"> 
                                                عرض المحادثة
                                              </a>
                                            @endif
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row my-3 px-5 facture-box">
                                        <div class="col-4 p-0 bolld  " >
                                            حالة الفاتورة 
                                        </div>
                                        <div class="col-8 ">
                                           
                                            @if ($research->status == 3)
                                                <span class="  @if($research?->invoice?->payment_response == 0) text-danger @else text-success  @endif font-weight-bold ml-3">
                                                    @if ($research->invoice)
                                                        {{ $research->invoice->payment_response == 0 ? 'غير مدفوع' :                                                        'مدفوع'}}
                                                    @else
                                                        غير مدفوع  
                                                    @endif
                                                    
                                                </span>
                                                
                                                @if($research->invoice)
                                                    @if ($research->invoice->payment_response == 0)
                                                        @if (time() > $research->invoice->ending)
                                                            <form class=" d-inline-block" action="{{ adminUrl('invoices/active') }}"
                                                                method="POST">
                                                                @csrf
                                                                <input type="hidden" name="id" value="{{ $research->invoice->id }}" required>
                                                                <button type="submit" id="activate-facture" class="btn btn-outline-secondary btn-sm pb-0 d-block mt-2"><i
                                                                        class="fa-solid fa-repeat ml-1"></i>إعادة تنشيط الفاتورة</button>
                                                            </form>
                                                        @else
                                                            <span class=" text-success  font-weight-bold d-block mt-2">فاتورة نشطة</span>
                                                        @endif
                                                        @endif
                                                    @else
                                                        <span>لايوجد</span>
                                                    @endif
                                                @else 
                                                  <span>لاتوجد فاتورة</span>
                                                @endif
                                               
                                                @if($research->id == session('id_send'))
                                                        
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
                                                            <input type="hidden" value="{{$research->id}}" name="research_id">
                                                            <input type="url" required placeholder="أدخل رابط الفاتورة ......."  class="form-control" name="link">
                                                                <button class="btn btn-info mt-2 text-white" type="submit">أرسل</button>
                                                        </div>
                                                    </form>
                                            @endif 
                                        </div>
                                    </div>
                                    <hr>
                                    @if(\App\Models\Message::where('research_id',$research->id)->count() &&
                                    $research->status != 5)
                                    <div class="row my-3 px-5">
                                        <div class="col-4 p-0 bolld  " >
                                            المحادثة 
                                        </div>
                                        <div class="col-8">
                                              <a href="{{ adminUrl('users/chat/'.$research->id)}}" class="bolld" style="    padding-top: 3px;"> 
                                                عرض المحادثة
                                              </a>
                                        </div>
                                    </div>
                                    @endif
                                    {{-- <div class="px-3  my-3 mb-4 d-flex justify-content-start">
                                        <span class="bolld float-right text-secondary ml-3">حالة الفاتورة : </span>
                                        <span class=" float-left  mx-3">
                                           
                                            @if ($research->status == 3)
                                                <a href="#" class="status btn @if($research?->invoice?->payment_response == 0) btn-danger @else btn-success @endif"> 
                                                @if ($research->invoice)
                                                {{ $research->invoice->payment_response == 0 ? 'غير مدفوع' :
                                                'مدفوع'}}
                                                @else
                                                غير مدفوع  
                                                @endif
                                                </a>
                                                @if($research->invoice)
                                                @if ($research->invoice->payment_response == 0)
                                                    @if (time() > $research->invoice->ending)
                                                        <form class=" d-inline-block" action="{{ adminUrl('invoices/active') }}"
                                                            method="POST">
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{ $research->invoice->id }}" required>
                                                            <button type="submit" class="btn btn-outline-secondary btn-sm pb-0"><i
                                                                    class="fa-solid fa-repeat ml-1"></i>إعادة تنشيط الفاتورة</button>
                                                        </form>
                                                    @else
                                                        <span>فاتورة نشطة</span>
                                                    @endif
                                                @else
                                                    <span>-</span>
                                                @endif
                                                @endif
                                               
                                            @if($research->id == session('id_send'))
                                                
                                            @if($errors->any())
                                                @foreach($errors->all() as $error)
                                                <ul style="list-style: none;padding: 0;">
                                                <li class="alert alert-danger mt-2 mb-2">{{$error}}</li>
                                                </ul>
                                            @endforeach
                                            @endif
                                            @if(session('success'))
                                                <div class="alert alert-success mt-2 mb-2">
                                                {{session('success')}} 
                                                </div>
                                            @endif
                                            
                                            @endif
                                            
                                                        
                                                    <form method="POST" class="mt-3 d-none" action="{{route('send_facture') }}">
                                                        @csrf
                                                        <div class="form-group">
                                                            <input type="hidden" value="{{$research->id}}" name="research_id">
                                                            <input type="url" required placeholder="أدخل رابط الفاتورة ......."  class="form-control" name="link">
                                                                <button class="btn btn-info mt-2 text-white" type="submit">أرسل</button>
                                                        </div>
                                                    </form>
                                        @endif 
                                                    
                                        </span>
                                        <div class="clearfix"></div>
                                    </div> --}}
                                  
                                    
                                    
                                    
                                    
                                    <!--<a href="" class="mx-3 mb-1 btn btn-info status" type="button" data-toggle="collapse" data-target="#collapseExample{{ $research->id }}" aria-expanded="false" aria-controls="collapseExample{{ $research->id }}">-->
                                    <!--    ملخص البحث-->
                                    <!--</a>-->
                                    

                                    <hr>
                                    <div class="d-flex justify-content-center  my-4">
                                        <a data-toggle="collapse" data-target="#collapseExample{{ $research->id }}" aria-expanded="false" aria-controls="collapseExample{{ $research->id }}" target="__blank"
                                            href="{{ asset('assets/uploads/users-researches/' . $research->file) }}"
                                            class="btn btn-info status mx-1"> 
                                            <i class="fa fa-file-word"></i>
                                            ملخص البحث
                                        </a>      
                                    
                                    
                                        @if (checkFile('assets/uploads/users-researches/' . $research->file))
                                           
                                            <a target="__blank"
                                                href="{{ asset('assets/uploads/users-researches/' . $research->file) }}"
                                                class="btn btn-info status mx-1"> 
                                                <i class="fa fa-download"></i>
                                                تحميل ملف الدراسة 
                                            </a>
                                        @else
                                            <span class=" font-weight-bold text-danger mx-1" style="line-height:2">لا يوجد ملف !</span>
                                        @endif
                                    </div>
                                    
                                  
                                    <div class="collapse mx-2" id="collapseExample{{ $research->id }}">
                                      <div class="card card-body">
                                        {{ $research->abstract }}
                                      </div>
                                    </div>


                                    <div class="dropdown open ">
                                        <button class="dropdown-toggle " type="button" id="triggerId" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu text-right" aria-labelledby="triggerId">
                                            
                                        
                                            @if ($research->status == 1)
                                            
                                                <a class="dropdown-item"
                                                    href="{{ adminUrl('users/user-researches/edit/2/' . $research->id) }}">تم التحويل للمراجعة </a>
                                                    
                                                <a class="dropdown-item"
                                                    href="{{ adminUrl('users/user-researches/edit/3/' . $research->id) }}">مقبول</a>
                                                    
                                                <a class="dropdown-item"
                                                    href="{{ adminUrl('users/user-researches/edit/4/' . $research->id) }}">مرفوض</a>
                                                    
                                                <a class="dropdown-item"
                                                    href="{{ adminUrl('users/user-researches/edit/5/' . $research->id) }}">مطلوب تعديل</a>
    
                                                <div class="dropdown-divider"></div>
    
                                                <form class="dropdown-item delete d-inline-block"
                                                    action="{{ adminUrl('users/user-researches/destroy') }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="id" value="{{ $research->id }}" required>
                                                    <button  class="d-block w-100 text-right" id="delete-research-by-id" data-researchid="{{ $research->id }}" data-url="{{ adminUrl('users/user-researches/destroy') }}">حذف</button>
                                                </form>
                                            
                                            @elseif ($research->status == 2)
                                                
                                                <a class="dropdown-item"
                                                    href="{{ adminUrl('users/user-researches/edit/3/' . $research->id) }}">مقبول</a>
                                                    
                                                <a class="dropdown-item"
                                                    href="{{ adminUrl('users/user-researches/edit/4/' . $research->id) }}">مرفوض</a>
                                                    
                                                <a class="dropdown-item"
                                                    href="{{ adminUrl('users/user-researches/edit/5/' . $research->id) }}">مطلوب تعديل</a>
    
                                                <div class="dropdown-divider"></div>
    
                                                <form class="dropdown-item delete d-inline-block"
                                                    action="{{ adminUrl('users/user-researches/destroy') }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="id" value="{{ $research->id }}" required>
                                                    <button type="submit" class="d-block w-100 text-right" id="delete-research-by-id" data-researchid="{{ $research->id }}" data-url="{{ adminUrl('users/user-researches/destroy') }}">حذف</button>
                                                </form>
                                                
                                            @elseif ($research->status == 3 || $research->status == 4)
                                                
                                                <div class="dropdown-divider"></div>
    
                                                <form class="dropdown-item delete d-inline-block"
                                                    action="{{ adminUrl('users/user-researches/destroy') }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="id" value="{{ $research->id }}" required>
                                                    <button  class="d-block w-100 text-right" id="delete-research-by-id"  data-researchid="{{ $research->id }}" data-url="{{ adminUrl('users/user-researches/destroy') }}">حذف</button>
                                                </form>
                                                
                                            @elseif ($research->status == 5)
                                                
                                                <a class="dropdown-item"
                                                    href="{{ adminUrl('users/user-researches/edit/3/' . $research->id) }}">مقبول</a>
                                                    
                                                <a class="dropdown-item"
                                                    href="{{ adminUrl('users/user-researches/edit/2/' . $research->id) }}">تم التحويل للمراجعة </a>
    
                                                <div class="dropdown-divider"></div>
    
                                                <form class="dropdown-item delete d-inline-block"
                                                    action="{{ adminUrl('users/user-researches/destroy') }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="id" value="{{ $research->id }}" required>
                                                    <button  class="d-block w-100 text-right" id="delete-research-by-id" data-researchid="{{ $research->id }}" data-url="{{ adminUrl('users/user-researches/destroy') }}">حذف</button>
                                                </form>
                                            @endif

                                        </div>
                                    </div><!-- Controls -->
                                </div>
                            </div>
                            
                </div>

        </div>
    </section>



@endsection
@section('js')
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
document.querySelector('#delete-research-by-id').addEventListener('click',function(e){
    e.preventDefault();
  let id = e.target.getAttribute('data-researchid')
  let url = e.target.getAttribute('data-url')

  
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
                  method: 'delete',
                  data: {
                   reason : reason,
                   id:id
                  },
                  success: function(result){
                    
                     if(result.message == 'deleted'){
                        swal.stopLoading();
                        swal.close();
                        swal("حذف الطلب", "تم حذف الطلب ينجاح", "success");
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
})

// document.querySelector('#activate-facture').addEventListener('click',function(event){
// event.preventDefault()
// let url = "{{ adminUrl('invoices/active') }}"
// console.log('url: ', url);
// let id = document.querySelector('input[name="id"]').value;
// console.log('id: ', id);
//             //    jQuery.ajax({
//             //       url: url,
//             //       method: 'delete',
//             //       data: {
//             //        reason : reason,
//             //        id:id
//             //       },
//             //       success: function(result){
                    
//             //          if(result.message == 'deleted'){
//             //             swal.stopLoading();
//             //             swal.close();
//             //             swal("حذف الطلب", "تم حذف الطلب ينجاح", "success");
//             //             window.location.href = "{{ adminUrl('users/user-researches') }}";

//             //          }
//             //       }});
// })
</script>
@endsection