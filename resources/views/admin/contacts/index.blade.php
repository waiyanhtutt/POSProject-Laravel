@extends('admin.layouts.master')

@section('title','Contact List Page')

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
                                <h2 class="title-1">Contact List</h2>

                            </div>
                        </div>
                    </div>

                    <div class="row my-3">
                        <div class="col">
                            <h5 class=" text-secondary">Search Key : {{request('searchKey')}}</h5>
                        </div>

                        <div class=" col-auto mb-3">
                            <form class="form-header" action="{{route('contact#list')}}" method="GET">
                                @csrf
                                    <input class="au-input au-input--xl" type="text" name="searchKey" placeholder="Search Contacts..." id="search" value="{{request('searchKey')}}" />
                                    <button class="au-btn--submit" type="submit">
                                        <i class="zmdi zmdi-search"></i>
                                    </button>
                            </form>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class=" col-md-3">
                            <h4 class=" text-muted"><i class="fa-solid fa-database"> </i>
                                {{$contacts->total()}}
                            </h4>
                        </div>
                    </div>

                        @if (count($contacts) !== 0)
                        <div class="table-responsive table-responsive-data2">
                            <table class="table table-data2 text-center">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Message</th>
                                        <th>Date</th>
                                        <th>actions</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($contacts as $idx=>$contact)
                                    <tr class="tr-shadow my-2">

                                        <td class="col-1">{{($contacts->currentPage()-1) * $contacts->perPage() + $idx + 1}} </td>
                                        <td class="col-2">{{$contact->name}}</td>
                                        <td class="col-2">{{$contact->email}}</td>
                                        <td class="col-3">
                                           <a href="#" class=" text-decoration-none viewMessage" data-id="{{$contact->id}}" >{{Str::limit($contact->message,16)}}</a>
                                        </td>
                                        <td class="col-2">{{$contact->created_at->format('d M Y')}}</td>

                                        <td class="col-2">
                                            <form action="{{route('contact#destroy',$contact->id)}}" method="POST" onsubmit="return confirm('Are You Sure to delete this message?')" >
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"><i class="zmdi zmdi-delete"></i></button>
                                            </form>

                                        </td>

                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            <div>
                               {{$contacts->links()}}
                             </div>
                        </div>
                        @else
                            <h3 class=" text-muted text-center">There is no contact here!</h3>
                        @endif
                    <!-- END DATA TABLE -->
                </div>

            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
    @include('admin.contacts.show')
@endsection


