@extends('admin.layout')

@section('title', 'Manage Ranked sites')
@section('Asites', 'active')

@section('css')
    <link href="//fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="{{ asset('assets/templates/default/css/materialize-tags.css') }}" rel="stylesheet"/>
@endsection

@section('header')
    <section class="content-header">
        <h1>
            Manage ranked sites
            <small>results order</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.simple') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Ranked sites</li>
        </ol>
    </section>
@endsection


@section('content')

    <div class="row" id="statu">
        <div class="col-sm-12">
            <div class="alert alert-dismissible" role="alert"><span></span> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <button class="btn ink-reaction btn-primary btn-icon-toggle" href="#" data-toggle="modal" data-target="#newModal"><i class="fa fa-plus"></i> New Site</button>
        </div>
    </div><br/>

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
            <h3 class="box-title">Ranked Sites</h3>
        </div>
        <div class="box-body table-responsive">

            @if(!$sites->isEmpty())
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>Keyword</th>
                        <th>Rank</th>
                        <th>Statu</th>
                        <th class="text-right">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($sites as $site)
                        <tr>
                            <td>{{ $site['title'] }}</td>
                            <td>{{ $site->keyword->keyword }}</td>
                            <td>@if($site->rank) page: {{ $site->page }} / rank: {{ $site->rank }} @else <span class="label label-danger">Removed</span> @endif</td>
                            <td>@if($site->enabled) <span class="label label-success">Active</span> @else <span class="label label-danger">Unactive</span> @endif</td>
                            <td class="text-right">
                                <button type="button" data-toggle="modal" data-target="#editModal-{{ $site->id }}" class="btn btn-icon-toggle"><i class="fa fa-pencil"></i></button>
                                <button onclick="deleteSite({{ $site['id'] }});" data-toggle="modal" data-target="#deleteModal" type="button" class="btn btn-icon-toggle"><i class="fa fa-trash-o"></i></button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <center>{{ $sites->render() }}</center>
            @else
                <p class="text-center">There is no sites ranked right now.</p>
            @endif
        </div><!--end .card-body -->
    </div><!--end .card -->

    <style>
        .badge.style-warning {
            background-color: #FF9800;
            border-color: #FF9800;
            color: #fff;
        }
        .text-success {
            color: #4CAF50;
        }
        .modal-content {
            font-size: 13px !important;
        }
    </style>

    @foreach($sites as $site)
        <!-- BEGIN FORM MODAL MARKUP -->
        <div class="modal fade" id="editModal-{{ $site->id }}" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="formModalLabel">Edit site rank</h4>
                    </div>
                    <form class="form-horizontal" role="form" action="{{ URL::action('admin\SitesController@postRankedSites') }}" method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <label for="editOwnerEmail" class="control-label">Title:</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="hidden" name="id" id="editAdId" value="{{ $site->id }}">
                                    <input type="text" name="title" id="editOwnerEmail" value="{{ $site->title }}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <label for="editAdDescription" class="control-label">Site Description:</label>
                                </div>
                                <div class="col-sm-9">
                                    <textarea name="description" id="editAdDescription" class="form-control" rows="3">{{ $site->description }}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <label for="editurl" class="control-label">Site Url:</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="url" name="url" id="editurl" value="{{ $site->url }}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <label for="page" class="control-label">Page:</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="number" name="page" id="page" value="{{ $site->page }}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <label for="rank" class="control-label">Rank on page:</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="number" name="rank" id="rank" value="{{ $site->rank }}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <label for="editAdStatu" class="control-label">Ad statu:</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="checkbox">
                                        <input type="checkbox" class="minimal" name="enabled" @if($site->enabled) checked @endif id="adStatu">
                                        <label for="adStatu">Active</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button type="submit" name="submitEditSite" value="submit" class="btn btn-primary">Edit</button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <!-- END FORM MODAL MARKUP -->
    @endforeach

    <!-- BEGIN FORM MODAL MARKUP -->
    <div class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="formModalLabel">New site rank</h4>
                </div>
                <form class="form-horizontal" role="form" action="{{ URL::action('admin\SitesController@postApprove') }}" method="get">
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label for="newurl" class="control-label">Site Url:</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="url" name="url" id="newurl" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" value="submit" class="btn btn-primary">New</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- END FORM MODAL MARKUP -->

    <!-- BEGIN FORM MODAL MARKUP -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="formModalLabel">Delete Site</h4>
                </div>
                <form class="form-horizontal" role="form" action="{{ URL::action('admin\SitesController@postRankedSites') }}" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <p>Are you sure you want to delete this site?</p>
                                <input type="hidden" name="id" id="deleteSiteId" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="submitDeleteSite" value="submit" class="btn btn-primary">Delete</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- END FORM MODAL MARKUP -->
@endsection

@section('javascript')
    <script src="{{ asset('assets/templates/default/js/typeahead.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/templates/default/js/materialize-tags.js') }}"></script>
    <script>
        function deleteSite($id){
            $('#deleteSiteId').val($id);
        }
        function showModel($email, $url, $Vurl, $keywords, $statu, $title, $desc){
            // email
            $('#showOwnerEmail').html($email);
            // URL
            $('#showAdURL').html($url);
            $('#showAdURL').attr("href", $url)
            $('#showDemoAdURL').attr("href", $url)
            // VURL
            $('#showAdVURL').html($Vurl);
            $('#showDemoVURL').html($Vurl);
            // Keywords
            $('#showAdKeywords').html($keywords);
            // statu
            $('#showAdStatu').html($statu);
            // Title
            $('#showDemoAdURL').html($title);
            // dsecription
            $('#showDemoAdDescription').html($desc);
        }

        function editModel($id, $email, $url, $Vurl, $keywords, $statu, $title, $desc){
            // id
            $('#editAdId').val($id);
            // email
            $('#editOwnerEmail').val($email);
            // URL
            $('#editAdURL').val($url);
            // VURL
            $('#editAdVURL').val($Vurl);
            // Keywords
            $('#editAdKeywords').val($keywords);
            // statu
            $('#editAdStatu').prop('checked', $statu);
            // Title
            $('#editAdTitle').val($title);
            // dsecription
            $('#editAdDescription').val($desc);
        }

        function approveAd(e){
            var $ad = $("#approveAdId").val();
            var dataIn = {adId: $ad};
            var $url = '{{ route("admin.api.ajax.searchads.approve") }}';
            $.ajax({
                type: "POST",
                url: $url,
                data: dataIn,
                success: function(data){
                    sendMessage('alert-success', data);
                    $('#approveModal').modal('hide');
                    $('#approveButton-' + $ad).hide();
                },
                error: function(e){
                    sendMessage('alert-danger', e.responseText);
                    $('#approveButton-' + $ad).hide();
                }
            });
            return false;
        }

        function toggleBlock($activator, $target){
            if($($activator).prop( "checked" )){
                $($target).show();
            }else{
                $($target).hide();
            }
        }

        $("#geoTurn").on('ifChecked ifUnchecked', function (){toggleBlock("#geoTurn", "#geoTargeting");});
        $("#continentTurn").on('ifChecked ifUnchecked', function (){toggleBlock("#continentTurn", "#continentsContainer");});
        $("#countriesTurn1").on('ifChecked ifUnchecked', function (){toggleBlock("#countriesTurn1", "#countriesContainer1");});
        $("#countriesTurn2").on('ifChecked ifUnchecked', function (){toggleBlock("#countriesTurn2", "#countriesContainer2");});


    </script>
@endsection