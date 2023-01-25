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
        padding: 0 10px;
        font-size: 17px !important;
    }
    .bolld{
        font-weight: 600 !important;
    }
    .ico{
        font-size:12px !important;
    }
    .research-date{
        left: 3rem;
        top: 45px;
        position: absolute;
        font-weight: 600;
        opacity: 0.9;
    }
    .user-name{
        style="font-size: 1.2rem;"
    }
    @media(max-width:500px){
       .user-name{
        style="font-size: 1rem;"
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


            @if (count($researches) > 0)
                <div class="col-lg-8">
                    <div class="row">
                        @foreach ($researches as $row)
                        
                            @php 
                                $value = \App\Models\Message::where(['a_show' => 0, 'research_id'=>$row->id ])->get();
                                $value = $value->count();
                            @endphp
                             <div class="col-12 mb-4">
                                <div class="box-white pl-4">
                                   
                                    
                                
                                    <div class="mb-2 mt-3 d-flex  align-items-center">
                                          <i class="fa-solid fa-user bg-warning rounded" style="padding: 0.7rem;"></i> 
                                         <span class=" font-weight-bold user-name" >{{$row->user->name}} | {{$row->user->email}}</span>
                                    </div>
                                    <span class="research-date d-none d-sm-block">{{ date('Y-m-d',strtotime($row->created_at)) }}</span>
    
                                    <div class="px-3 mb-1 my-4  d-flex justify-content-start">
                                        <span class="bolld float-right text-secondary" style="min-width: 93px;">عنوان البحث :</span>
                                        <a href="{{route('research_details',['id'=>$row->id])}}" class="mx-3 font-weight-bold
                                            @if(preg_match("/^[\w\d\s.,-]*$/", $row->title))
                                            text-left
                                            @endif
                                            ">{{$row->title}}</a>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="px-3 mb-1 my-4  d-flex justify-content-start d-sm-none">
                                        <span class="bolld float-right text-secondary" style="min-width: 93px;">تاريخ الارسال :</span>
                                        <span class="mx-3">{{ date('Y-m-d',strtotime($row->created_at)) }}</span>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="d-flex justify-content-center justify-content-md-end">
                                        <a href="{{route('research_details',['id'=>$row->id])}}" type="button" class="btn btn-outline-info btn-sm bg-default mx-2">التفاصيل</a>
                                        <a href="" type="button" class="btn btn-outline-danger btn-sm bg-default delete-research-by-id" 
                                         data-researchid="{{ $row->id }}" data-url="{{ adminUrl('users/user-researches/destroy') }}"
                                        style="min-width:55px">حذف</a>
                                    </div>
                                    
                                </div>
    
                            </div>
                            
                        @endforeach
                       
                </div>
            @else
                <div class="col-lg-8">
                    <div class="box-white py-5">
                        <h5 class=" text-center">لم يتم العثور علي ابحاث !</h5>
                    </div>
                </div>
            @endif
            <div class="col-12 my-4 d-flex justify-content-center">
                {{$researches->onEachSide(0)->links()}}
            </div>
        </div>
    </section>
    {{-- <div class="container-fluid">
        <div class="row">
        <div class="col-12">
        <div class="card">
        <div class="card-header">
        <h3 class="card-title">DataTable with minimal features &amp; hover style</h3>
        </div>
        
        <div class="card-body">
        <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4"><div class="row"><div class="col-sm-12 col-md-6"></div><div class="col-sm-12 col-md-6"></div></div><div class="row"><div class="col-sm-12"><table id="example2" class="table table-bordered table-hover dataTable dtr-inline" aria-describedby="example2_info">
        <thead>
        <tr><th class="sorting sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column descending" aria-sort="ascending">Rendering engine</th><th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Browser</th><th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Platform(s)</th><th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">Engine version</th><th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">CSS grade</th></tr>
        </thead>
        <tbody>
        
        <tr class="odd">
            <td class="dtr-control sorting_1" tabindex="0">Gecko</td>
            <td>Firefox 1.0</td>
            <td>Win 98+ / OSX.2+</td>
            <td>1.7</td>
            <td>A</td>
        </tr>
        <tr class="even">
            <td class="dtr-control sorting_1" tabindex="0">Gecko</td>
            <td>Firefox 1.5</td>
            <td>Win 98+ / OSX.2+</td>
            <td>1.8</td>
            <td>A</td>
        </tr>
        <tr class="odd">
            <td class="dtr-control sorting_1" tabindex="0">Gecko</td>
            <td>Firefox 2.0</td>
            <td>Win 98+ / OSX.2+</td>
            <td>1.8</td>
            <td>A</td>
        </tr>
        <tr class="even">
            <td class="dtr-control sorting_1" tabindex="0">Gecko</td>
            <td>Firefox 3.0</td>
            <td>Win 2k+ / OSX.3+</td>
            <td>1.9</td>
            <td>A</td>
        </tr>
        <tr class="odd">
            <td class="dtr-control sorting_1" tabindex="0">Gecko</td>
            <td>Camino 1.0</td>
            <td>OSX.2+</td>
            <td>1.8</td>
            <td>A</td>
        </tr>
        <tr class="even">
       </tbody>
        <tfoot>
        <tr><th rowspan="1" colspan="1">Rendering engine</th><th rowspan="1" colspan="1">Browser</th><th rowspan="1" colspan="1">Platform(s)</th><th rowspan="1" colspan="1">Engine version</th><th rowspan="1" colspan="1">CSS grade</th></tr>
        </tfoot>
        </table></div></div><div class="row"><div class="col-sm-12 col-md-5"><div class="dataTables_info" id="example1_info" role="status" aria-live="polite">Showing 1 to 10 of 57 entries</div></div><div class="col-sm-12 col-md-7"><div class="dataTables_paginate paging_simple_numbers" id="example1_paginate"><ul class="pagination"><li class="paginate_button page-item previous disabled" id="example1_previous"><a href="#" aria-controls="example1" data-dt-idx="0" tabindex="0" class="page-link">Previous</a></li><li class="paginate_button page-item active"><a href="#" aria-controls="example1" data-dt-idx="1" tabindex="0" class="page-link">1</a></li><li class="paginate_button page-item "><a href="#" aria-controls="example1" data-dt-idx="2" tabindex="0" class="page-link">2</a></li><li class="paginate_button page-item "><a href="#" aria-controls="example1" data-dt-idx="3" tabindex="0" class="page-link">3</a></li><li class="paginate_button page-item "><a href="#" aria-controls="example1" data-dt-idx="4" tabindex="0" class="page-link">4</a></li><li class="paginate_button page-item "><a href="#" aria-controls="example1" data-dt-idx="5" tabindex="0" class="page-link">5</a></li><li class="paginate_button page-item "><a href="#" aria-controls="example1" data-dt-idx="6" tabindex="0" class="page-link">6</a></li><li class="paginate_button page-item next" id="example1_next"><a href="#" aria-controls="example1" data-dt-idx="7" tabindex="0" class="page-link">Next</a></li></ul></div></div></div></div>
        </div>
        
        </div>
        
        </div>
        
        </div>
        
    </div> --}}



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
document.querySelectorAll('.delete-research-by-id').forEach(item =>{

item.addEventListener('click',function(e){
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
})
</script>
@endsection