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

               @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="overview-wrap">
                                <h2 class="title-1">Admin List</h2>

                            </div>
                        </div>
                        {{-- <div class="table-data__tool-right">
                            <a href="{{route('product#create')}}">
                                <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                    <i class="zmdi zmdi-plus"></i>add Pizza
                                </button>
                            </a>
                            <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                CSV download
                            </button>
                        </div> --}}
                    </div>

                    <div class="row my-3">
                        <div class="col">
                            <h5 class=" text-secondary">Search Key : {{ request('searchKey')}}</h5>
                        </div>

                        <div class=" col-auto mb-3">
                            <form class="form-header" action="#" method="GET">
                                @csrf
                                    <input class="au-input au-input--xl" type="text" name="searchKey" placeholder="Search Admin..." value="{{request('searchKey')}}" />
                                    <button class="au-btn--submit" type="submit">
                                        <i class="zmdi zmdi-search"></i>
                                    </button>
                            </form>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class=" col-md-3">
                            <h4 class=" text-muted"><i class="fa-solid fa-database"> {{$adminLists->total()}}</i></h4>
                        </div>
                    </div>
                        @if (count($adminLists) !== 0)
                        <div class="table-responsive table-responsive-data2">
                            <table class="table table-data2 text-center">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Gender</th>
                                        <th>Address</th>
                                        <th>Actions</th>

                                    </tr>
                                </thead>
                                <tbody id="tableData">
                                    @foreach ($adminLists as $adminList )
                                    <tr class="tr-shadow my-2">
                                        <td class=" col-2">
                                            @if ($adminList->image == null)
                                                @if($adminList->gender == 'female')
                                                    <img src="{{asset('images/female.png')}}" alt="" class=" img-thumbnail shadow-sm">
                                                @else
                                                    <img src="{{asset('images/defaultuser.jpg')}}" alt="" class=" img-thumbnail shadow-sm">

                                                @endif
                                            @else
                                                <img src="{{asset('storage/'.$adminList->image)}}" alt="" class=" img-thumbnail shadow-sm">
                                            @endif
                                        </td>
                                        <td>{{$adminList->name}}
                                            <input type="hidden" class="roleId" value="{{$adminList->id}}">
                                        </td>
                                        <td>{{$adminList->email}}</td>
                                        <td>{{$adminList->phone}}</td>
                                        <td>{{$adminList->gender}}</td>
                                        <td>{{$adminList->address}}</td>
                                        <td class=" col-3">
                                            <div class="table-data-feature">

                                                @if (Auth::user()->id == $adminList->id)

                                                @else
                                                   {{-- method 1 --}}
                                                    {{-- <a href="{{route('admin#editRole',$adminList->id)}}">
                                                        <button class="item mr-2" data-toggle="tooltip" data-placement="top" title=" Change Role">
                                                            <i class="fa-solid fa-toggle-on"></i>
                                                        </button>
                                                    </a> --}}

                                                    {{-- method 2 (with ajax) --}}

                                                    {{-- <select name="changeRole" class=" form-select form-select-sm me-2 changeRole">
                                                        <option value="admin" @if ($adminList->role == "admin") selected @endif>Admin</option>
                                                        <option value="user" @if ($adminList->role == "user") selected @endif>User</option>
                                                    </select> --}}

                                                    {{-- method 3 (with btn group) --}}
                                                    <div class="btn-group me-2">
                                                        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            {{ ucfirst($adminList->role) }}
                                                        </button>
                                                        <ul class="dropdown-menu changeRoleMenu">
                                                            <li><a class="dropdown-item change-role-item" href="#" data-role="admin">Admin</a></li>
                                                            <li><a class="dropdown-item change-role-item" href="#" data-role="user">User</a></li>
                                                        </ul>
                                                    </div>


                                                    <a href="{{route('admin#delete',$adminList->id)}}">
                                                        <button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                                                            <i class="zmdi zmdi-delete"></i>
                                                        </button>
                                                    </a>
                                                @endif

                                            </div>
                                        </td>

                                    </tr>
                                    @endforeach


                                </tbody>
                            </table>
                            <div>
                               {{ $adminLists->links()}}
                            </div>
                        </div>
                        @else
                            <h3 class=" text-muted text-center">There is no Admin here!</h3>
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
        // $(document).on('change','.changeRole',function(){
        //     // console.log("hello");
        //     let currentRow = $(this).closest('tr');
        //     let currentroleId = currentRow.find('.roleId').val();
        //     let currentStatus = $(this).val();
        //     console.log(currentStatus);

        //     $.ajax({
        //         type : "POST",
        //         url : "{{route('role#update')}}",
        //         data : {
        //             roleId : currentroleId,
        //             status : currentStatus,
        //             _token : "{{csrf_token()}}"
        //         },
        //         dataType : "json",
        //         success : function (response){
        //             alert (response.message);
        //             window.location.reload();
        //         },
        //         error : function (xhr){
        //             console.error("Role Update Failed! : ", xhr.responseText);
        //         }
        //     });
        // });

        $(document).on('click', '.change-role-item', function (e) {
            e.preventDefault();

            const selectedRole = $(this).data('role');
            const currentRow = $(this).closest('tr');
            const userId = currentRow.find('.roleId').val();

            $.ajax({
                type: "POST",
                url: "{{ route('role#update') }}",
                data: {
                    roleId: userId,
                    status: selectedRole,
                    _token: "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function (response) {
                    alert(response.message);
                    window.location.reload();
                    // optionally update the button label without reload
                    // currentRow.find('.dropdown-toggle').text(selectedRole.charAt(0).toUpperCase() + selectedRole.slice(1));
                },
                error: function (xhr) {
                    console.error("Role Update Failed:", xhr.responseText);
                }
            });
        });


    });
</script>
@endsection
