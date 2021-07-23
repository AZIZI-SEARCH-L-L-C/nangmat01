@extends('admin.layout')

@section('title', 'Manage users')
@section('Ausers', 'active')

@section('header')
    <section class="content-header">
        <h1>
            Manage users
            <small>of results</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.simple') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Manage users</li>
        </ol>
    </section>
@endsection


@section('content')

    <div class="row" id="statu">
        <div class="col-sm-12">
            <div class="alert alert-dismissible" role="alert"><span></span> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></div>
        </div>
    </div>

    @if(Session::has('message'))
        <div class="row">
            <div class="col-sm-12">
                <div class="alert @if(Session::get('messageType') == 'success') alert-success @else alert-danger @endif" role="alert">
                    {{ Session::get('message') }}
                </div>
            </div>
        </div>
    @endif

    <div class="box box-primary box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">Manage users</h3>
        </div>
        <div class="box-body table-responsive">

            @if(!$users->isEmpty())
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Balance</th>
                        <th class="text-right">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>${{ $user->credit }}</td>
                            <td class="text-right">
                                <a href="{{ route('admin.users.one', $user->id) }}"><button type="button" class="btn btn-icon-toggle"><i class="fa fa-eye"></i></button></a>
{{--                                <button onclick="deleteComment({{ $user->id }});" type="button" class="btn"><i class="fa fa-trash-o"></i></button>--}}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <center>{{ $users->render() }}</center>
            @else
                <p class="text-center">There is no sites ranked right now.</p>
            @endif
        </div><!--end .card-body -->
    </div><!--end .card -->

@endsection

@section('javascript')
    <script src="{{ asset('assets/templates/default/js/typeahead.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/templates/default/js/materialize-tags.js') }}"></script>
    <script>
        function deleteComment($id){
            c = confirm("Are you sure you want to delete this comment?");
            if(c){
                window.location.href = "{{ route('admin.sites.comments.delete', '') }}/" + $id;
            }
        }

    </script>
@endsection