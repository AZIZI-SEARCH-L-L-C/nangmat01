@extends('admin.layout')

@section('title', 'User details: '.$user->username)
@section('Ausers', 'active')

@section('header')
    <section class="content-header">
        <h1>
            User details
            <small>{{ $user->username }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.simple') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">User details</li>
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

    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">User Ads campaigns: </h3>
                </div>
                <div class="box-body table-responsive">
                    @if(!$campaigns->isEmpty())
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Compain name</th>
                                <th>Username</th>
                                <th>#ads</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($campaigns as $compain)
                                <tr>
                                    <td>{{ $compain['name'] }}</td>
                                    <td>{{ $compain->user->username }}</td>
                                    <td>{{ $compain->ads->count() }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <center><a href="{{ action('admin\UserInfoController@getCampaigns', $user->id) }}">See All</a></center>
                    @else
                        <p class="text-center">There are no ads campaigns right now.</p>
                    @endif
                </div><!--end .card-body -->
            </div><!--end .card -->
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 col-md-6">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">User comments: </h3>
                </div>
                <div class="box-body table-responsive">
                    @if(!$comments->isEmpty())
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Comment</th>
                                <th>Result</th>
                                <th>Engine</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($comments as $comment)
                                <tr>
                                    <td>{{ $comment->comment }}</td>
                                    <td>{{ $comment->url }}</td>
                                    <td>{{ $comment->engine->name }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <center><a href="{{ action('admin\UserInfoController@getComments', $user->id) }}">See All</a></center>
                    @else
                        <p class="text-center">There are no comments right now.</p>
                    @endif
                </div><!--end .card-body -->
            </div><!--end .card -->
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">User bookmarks: </h3>
                </div>
                <div class="box-body table-responsive">
                    @if(!$bookmarks->isEmpty())
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Url</th>
                                <th>Category</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($bookmarks as $bookmark)
                                <tr>
                                    <td>{{ $bookmark->url }}</td>
                                    <td>@if($bookmark->category) {{ $bookmark->category->name }} @endif</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <center><a href="{{ action('admin\UserInfoController@getBookmarks', $user->id) }}">See All</a></center>
                    @else
                        <p class="text-center">There are no comments right now.</p>
                    @endif
                </div><!--end .card-body -->
            </div><!--end .card -->
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">User payments: </h3>
                </div>
                <div class="box-body table-responsive">
                    @if(!$payments->isEmpty())
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Payment method</th>
                                <th>Needs review</th>
                                <th>Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($payments as $payment)
                                <tr>
                                    <td>{{ $payment->payment_id }}</td>
                                    <td>{{ $payment->method }}</td>
                                    <td>@if($payment->review) Yes @else No @endif</td>
                                    <td>${{ $payment->total }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <center><a href="{{ action('admin\UserInfoController@getPayments', $user->id) }}">See All</a></center>
                    @else
                        <p class="text-center">There are no payments right now.</p>
                    @endif
                </div><!--end .card-body -->
            </div><!--end .card -->
        </div>
    </div>
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