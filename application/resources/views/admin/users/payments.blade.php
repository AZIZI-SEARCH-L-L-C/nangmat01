@extends('admin.layout')

@section('title', 'User payments')
@section('Ausers', 'active')

@section('header')
    <section class="content-header">
        <h1>
            User payments
            <small>of results</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.simple') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">User payments</li>
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
            <h3 class="box-title">User Payments</h3>
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
                <center>{{ $payments->render() }}</center>
            @else
                <p class="text-center">There is no payments right now.</p>
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