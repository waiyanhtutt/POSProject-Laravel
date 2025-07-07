@extends('admin.layouts.master')

@section('title','Admin List Page')

@section('content')
     <!-- MAIN CONTENT-->
     <div class="main-content">

        <div class="section__content section__content--p30">
            <div class="container-fluid">
               @if (session('deleteMessage'))
                <div class=" col-md-6 offset-3">
                        <div class=" text-center alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>{{session('deleteMessage')}}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                </div>
               @endif

                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="overview-wrap">
                                <h2 class="title-1">User List</h2>

                            </div>
                        </div>
                    </div>

                    <div class="row my-3">
                        <div class="col">
                            <h5 class=" text-secondary">Search Key : {{ request('searchKey')}}</h5>
                        </div>

                        <div class=" col-auto mb-3">
                            <form class="form-header" action="#" method="GET">
                                @csrf
                                    <input class="au-input au-input--xl" type="text" name="searchKey" placeholder="Search Users..." value="{{request('searchKey')}}" />
                                    <button class="au-btn--submit" type="submit">
                                        <i class="zmdi zmdi-search"></i>
                                    </button>
                            </form>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class=" col-md-3">
                            <h4 class=" text-muted"><i class="fa-solid fa-database"> </i></h4>
                        </div>
                    </div>
                        @if (count($users) !== 0)
                        <div class="table-responsive table-responsive-data2">
                            <table class="table table-data2 text-center">
                                <thead>
                                    <tr>
                                        <th style="width: 5%;">No</th>
                                        <th style="width: 10%;">Image</th>
                                        <th style="width: 12%;">Name</th>
                                        <th style="width: 15%;">Email</th>
                                        <th style="width: 10%;">Phone</th>
                                        <th style="width: 8%;">Gender</th>
                                        <th style="width: 12%;">Address</th>
                                        <th style="width: 10%;">Role</th>
                                        <th style="width: 18%;">Actions</th>

                                    </tr>
                                </thead>
                                <tbody id="tableData">
                                    @foreach ($users as $idx=>$user )
                                    <tr class="tr-shadow my-2">
                                        <td>{{($users->currentPage()-1) * $users->perPage() + $idx + 1}}</td>
                                        <td>
                                            @if ($user->image == null)
                                                @if($user->gender == 'female')
                                                    <img src="{{asset('images/female.png')}}" alt="" class=" img-thumbnail shadow-sm">
                                                @else
                                                    <img src="{{asset('images/defaultuser.jpg')}}" alt="" class=" img-thumbnail shadow-sm">

                                                @endif
                                            @else
                                                <img src="{{asset('storage/'.$user->image)}}" alt="" class=" img-thumbnail shadow-sm">
                                            @endif
                                        </td>
                                        <td>{{$user->name}}
                                            <input type="hidden" class="userId" value="{{$user->id}}">
                                        </td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->phone}}</td>
                                        <td>{{$user->gender}}</td>
                                        <td>{{$user->address}}</td>
                                        <td>{{$user->role}}</td>
                                        <td>
                                            <div class="table-data-feature">
                                                <select name="changeRole" class=" form-select form-select-sm me-2 changeRole" style="min-width: 120px;">
                                                    <option value="admin" @if ($user->role == "admin") selected @endif>Admin</option>
                                                    <option value="user" @if($user->role == "user") selected @endif>User</option>
                                                </select>

                                                <a href="{{route('user#listsDelete',$user->id)}}">
                                                    <button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                                                        <i class="zmdi zmdi-delete"></i>
                                                    </button>
                                                </a>

                                            </div>
                                        </td>

                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            <div>
                               {{ $users->links()}}
                            </div>
                        </div>
                        @else
                            <h3 class=" text-muted text-center">There is no User here!</h3>
                        @endif
                    <!-- END DATA TABLE -->
                </div>

            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
@section('script')
<script>
    $(document).ready(function(){
        $(document).on('change','.changeRole',function(e){

            e.preventDefault();
            // console.log("hello");
            let currentRow = $(this).closest('tr');
            let currentuserId = currentRow.find('.userId').val();
            let currentRole = $(this).val();
            console.log(currentRole);

            $.ajax({
                type : "POST",
                url : "{{route('user#statusUpdate')}}",
                data : {
                    userId : currentuserId,
                    status : currentRole,
                    _token : "{{csrf_token()}}"
                },
                dataType : "json",
                success : function (response){
                    alert (response.message);
                    window.location.reload();
                },
                error : function (xhr){
                    console.error("Role Update Failed! : ", xhr.responseText);
                }
            });
        });



    });
</script>
@endsection
