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
                                    <!--<a href="" class=" title">{{ $row->title }}</a>-->
                                    
                                
                                    <div class="mb-2 mt-3">
                                        <i class="fa-solid fa-user"></i> {{ $row->user->name }} 
                                        |  {{ $row->user->email }} 
                                        | {{ $row->user->phone }} 
                                    </div>

                                    <div class="px-3 mb-1">
                                        <span class="bolld float-right text-secondary">?????????? ??????????</span>
                                        <span class=" float-left">{{ $row->title }}</span>
                                        <div class="clearfix"></div>
                                    </div>
                                    
                                    <div class="px-3 mb-1">
                                        <span class="bolld float-right text-secondary">???????? ?????????? ?????????????? </span>
                                        <span class=" float-left">
                                            @if ($row->status == 1)
                                                <a href="#" class="status btn btn-warning"> ?????? ???????????????? </a>
                                            @elseif ($row->status == 2)
                                                <a href="#" class="status btn btn-warning"> ???? ?????????????? ???????????????? </a>
                                            @elseif ($row->status == 3)
                                                <a href="#" class="status btn btn-success"> ??????????
                                                |
                                                @if ($row->invoice)
                                                {{ $row->invoice->payment_response == 0 ? '?????? ??????????' :
                                                '??????????'}}
                                                @else
                                                ?????? ??????????  
                                                @endif
                                                </a>
                                                @if($row->invoice)
                                                @if ($row->invoice->payment_response == 0)
                                                    @if (time() > $row->invoice->ending)
                                                        <form class=" d-inline-block" action="{{ adminUrl('invoices/active') }}"
                                                            method="POST">
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{ $row->invoice->id }}" required>
                                                            <button type="submit" class="btn btn-outline-secondary btn-sm pb-0"><i
                                                                    class="fa-solid fa-repeat ml-1"></i>?????????? ?????????? ????????????????</button>
                                                        </form>
                                                    @else
                                                        <span>???????????? ????????</span>
                                                    @endif
                                                @else
                                                    <span>-</span>
                                                @endif
                                                @endif
                                               
                                       @if($row->id == session('id_send'))
                                           
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
                                                        <input type="hidden" value="{{$row->id}}" name="research_id">
                                                        <input type="url" required placeholder="???????? ???????? ???????????????? ......."  class="form-control" name="link">
                                                            <button class="btn btn-info mt-2 text-white" type="submit">????????</button>
                                                    </div>
                                                </form>
                                            @elseif ($row->status == 4)
                                                <a href="#" class="status btn btn-danger"> ?????????? </a>
                                            @elseif ($row->status == 5)
                                                <span class="status btn btn-info"> ?????????? ?????????? </span>
                                                <a href="{{ adminUrl('users/chat/'.$row->id)}}" class="status btn btn-info"> <i class="fa fa-message"></i> {{$value}}</a>
                                            @endif 
                                            
                                        </span>
                                        <div class="clearfix"></div>
                                    </div>
                                  
                                    
                                    <div class="px-3 mb-1">
                                        <span class="bolld text-secondary"> ?????????????? ?????????????????? </span>
                                        | <span class="">{{ $row->keywords }}</span>
                                        <div class="clearfix"></div>
                                    </div>
                                    
                                    <div class="px-3 mb-1">
                                        <span class="bolld float-right text-secondary">?????? ??????????</span>
                                        <span class=" float-left">
                                            @if ($row->type == 0)
                                                {{ '?????????? ????????????' }}
                                            @else
                                                {{ '???????? ????????????' }}
                                            @endif
                                        </span>
                                        <div class="clearfix"></div>
                                    </div>
                                    
                                    <div class="px-3 mb-1">
                                        <span class="bolld float-right text-secondary">?????????? ??????????????  </span>
                                        <span class=" float-left">{{ parseTime($row->created_at) }}</span>
                                        <div class="clearfix"></div>
                                    </div>
                                    
                                    <div class="px-3 mb-1">
                                        <span class="bolld float-right text-secondary">???????????? </span>
                                        <span class=" float-left">{{ $row->journal ? $row->journal->name : '???? ?????? ????????????' }}</span>
                                        <div class="clearfix"></div>
                                    </div>
                                    
                                    <hr>
                                    
                                    <!--<a href="" class="mx-3 mb-1 btn btn-info status" type="button" data-toggle="collapse" data-target="#collapseExample{{ $row->id }}" aria-expanded="false" aria-controls="collapseExample{{ $row->id }}">-->
                                    <!--    ???????? ??????????-->
                                    <!--</a>-->
                                    


                                            <a data-toggle="collapse" data-target="#collapseExample{{ $row->id }}" aria-expanded="false" aria-controls="collapseExample{{ $row->id }}" target="__blank"
                                                href="{{ asset('assets/uploads/users-researches/' . $row->file) }}"
                                                class="btn btn-info status"> ???????? ??????????</a>
                                    
                                    
                                        @if (checkFile('assets/uploads/users-researches/' . $row->file))
                                            <a target="__blank"
                                                href="{{ asset('assets/uploads/users-researches/' . $row->file) }}"
                                                class="btn btn-info status"> ?????????? ?????? ?????????????? </a>
                                        @else
                                            <small class=" font-weight-bold text-danger">???? ???????? ?????? !</small>
                                        @endif
                                  
                                    <div class="collapse mx-2" id="collapseExample{{ $row->id }}">
                                      <div class="card card-body">
                                        {{ $row->abstract }}
                                      </div>
                                    </div>


                                    <div class="dropdown open ">
                                        <button class="dropdown-toggle " type="button" id="triggerId" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu text-right" aria-labelledby="triggerId">
                                            
                                        
                                            @if ($row->status == 1)
                                            
                                                <a class="dropdown-item"
                                                    href="{{ adminUrl('users/user-researches/edit/2/' . $row->id) }}">???? ?????????????? ???????????????? </a>
                                                    
                                                <a class="dropdown-item"
                                                    href="{{ adminUrl('users/user-researches/edit/3/' . $row->id) }}">??????????</a>
                                                    
                                                <a class="dropdown-item"
                                                    href="{{ adminUrl('users/user-researches/edit/4/' . $row->id) }}">??????????</a>
                                                    
                                                <a class="dropdown-item"
                                                    href="{{ adminUrl('users/user-researches/edit/5/' . $row->id) }}">?????????? ??????????</a>
    
                                                <div class="dropdown-divider"></div>
    
                                                <form class="dropdown-item delete d-inline-block"
                                                    action="{{ adminUrl('users/user-researches/destroy') }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="id" value="{{ $row->id }}" required>
                                                    <button type="submit" class="d-block w-100 text-right">??????</button>
                                                </form>
                                            
                                            @elseif ($row->status == 2)
                                                
                                                <a class="dropdown-item"
                                                    href="{{ adminUrl('users/user-researches/edit/3/' . $row->id) }}">??????????</a>
                                                    
                                                <a class="dropdown-item"
                                                    href="{{ adminUrl('users/user-researches/edit/4/' . $row->id) }}">??????????</a>
                                                    
                                                <a class="dropdown-item"
                                                    href="{{ adminUrl('users/user-researches/edit/5/' . $row->id) }}">?????????? ??????????</a>
    
                                                <div class="dropdown-divider"></div>
    
                                                <form class="dropdown-item delete d-inline-block"
                                                    action="{{ adminUrl('users/user-researches/destroy') }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="id" value="{{ $row->id }}" required>
                                                    <button type="submit" class="d-block w-100 text-right">??????</button>
                                                </form>
                                                
                                            @elseif ($row->status == 3 || $row->status == 4)
                                                
                                                <div class="dropdown-divider"></div>
    
                                                <form class="dropdown-item delete d-inline-block"
                                                    action="{{ adminUrl('users/user-researches/destroy') }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="id" value="{{ $row->id }}" required>
                                                    <button type="submit" class="d-block w-100 text-right">??????</button>
                                                </form>
                                                
                                            @elseif ($row->status == 5)
                                                
                                                <a class="dropdown-item"
                                                    href="{{ adminUrl('users/user-researches/edit/3/' . $row->id) }}">??????????</a>
                                                    
                                                <a class="dropdown-item"
                                                    href="{{ adminUrl('users/user-researches/edit/2/' . $row->id) }}">???? ?????????????? ???????????????? </a>
    
                                                <div class="dropdown-divider"></div>
    
                                                <form class="dropdown-item delete d-inline-block"
                                                    action="{{ adminUrl('users/user-researches/destroy') }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="id" value="{{ $row->id }}" required>
                                                    <button type="submit" class="d-block w-100 text-right">??????</button>
                                                </form>
                                            @endif

                                        </div>
                                    </div><!-- Controls -->
                                </div>
                            </div>
                            
                        @endforeach

                        <div class="col-12 mb-4">
                            {{ $researches->links() }}
                        </div>

                    </div>
                </div>
            @else
                <div class="col-lg-8">
                    <div class="box-white py-5">
                        <h5 class=" text-center">???? ?????? ???????????? ?????? ?????????? !</h5>
                    </div>
                </div>
            @endif
        </div>
    </section>




@endsection
