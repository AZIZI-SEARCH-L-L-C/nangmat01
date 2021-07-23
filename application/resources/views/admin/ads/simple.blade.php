@extends('admin.layout')

@section('title', 'Manage ads')
@section('Amonetize', 'active')

@section('css')
    <link href="//fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="{{ asset('assets/templates/default/css/materialize-tags.css') }}" rel="stylesheet"/>
@endsection

@section('header')
    <section class="content-header">
        <h1>
            search ads
            <small>Internal ads</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.simple') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Search ads</li>
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
            <button class="btn ink-reaction btn-primary btn-icon-toggle" href="#" data-toggle="modal" data-target="#newModal"><i class="fa fa-plus"></i> New Ad</button>
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
            <h3 class="box-title">Ads</h3>
        </div>
        <div class="box-body table-responsive">

            @if(!$ads->isEmpty())
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>email</th>
                        <th>Statu</th>
                        <th class="text-right">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($ads as $ad)
                        <tr>
                            <td>{{ $ad['title'] }}</td>
                            <td>{{ $ad->email }}</td>
                            <td>@if($ad->turn) <span class="label label-success">Active</span> @else <span class="label label-danger">Unactive</span> @endif</td>
                            <td class="text-right">
                                <button type="button" data-toggle="modal" data-target="#showModal-{{ $ad->id }}" class="btn btn-icon-toggle"><i class="fa fa-eye"></i></button>
                                <button type="button" data-toggle="modal" data-target="#editModal-{{ $ad->id }}" class="btn btn-icon-toggle"><i class="fa fa-pencil"></i></button>
                                <button onclick="deleteAd({{ $ad['id'] }});" type="button" class="btn"><i class="fa fa-trash-o"></i></button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <center>{{ $ads->render() }}</center>
            @else
                <p class="text-center">There is no ads in this compain.</p>
            @endif
        </div><!--end .card-body -->
    </div><!--end .card -->
    <p>*Unlimited budget means the ad will continue until the funds in the account of user ends.</p>

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

    @foreach($ads as $ad)
        <div class="modal fade" id="showModal-{{ $ad->id }}" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="formModalLabel">Preview ad: {{ $ad->title }}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <p>Basic information:</p>
                                <p><strong>Owner Email:</strong> {{ $ad->email }}</p>
                                <p><strong>Ad URL:</strong> <a href="{{ $ad->url }}" target="_blank" id="showAdURL" class="text-info">{{ $ad->url }}</a></p>
                                <p><strong>Ad Visible URL:</strong> {{ $ad->Vurl }}</p>
                                <p><strong>Ad keywords:</strong> {{ $ad->keywords }}</p>
                                <p><strong>Ad Statu:</strong> @if($ad->turn) <span class="label label-success">Active</span> @else <span class="label label-danger">Unactive</span> @endif</p>
                            </div>
                            <div class="col-sm-6">
                                <p>How users will see this ad:</p>
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <a class="text-info" target="_blank" href="{{ $ad->url }}">{{ $ad->title }}</a>
                                        <p class="text-success"><span class="badge style-warning">Ad</span> {{ $ad->Vurl }}</p>
                                        <p id="showDemoAdDescription">{{ $ad->description }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- BEGIN FORM MODAL MARKUP -->
        <div class="modal fade" id="editModal-{{ $ad->id }}" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="formModalLabel">Edit advertisement</h4>
                    </div>
                    <form class="form-horizontal" role="form" action="{{ URL::action('admin\AdvertisementsController@postSimpleAds') }}" method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <label for="editOwnerEmail" class="control-label">Owner email:</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="hidden" name="adId" id="editAdId" value="{{ $ad->id }}">
                                    <input type="email" name="ownerEmail" id="editOwnerEmail" value="{{ $ad->email }}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <label for="editAdTitle" class="control-label">Ad Title:</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" name="adTitle" id="editAdTitle" value="{{ $ad->title }}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <label for="editAdURL" class="control-label">Ad URL:</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="url" name="adURL" id="editAdURL" value="{{ $ad->url }}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <label for="editAdVURL" class="control-label">Ad visible URL:</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" name="adVURL" id="editAdVURL" value="{{ $ad->Vurl }}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <label for="editAdDescription" class="control-label">Ad Description:</label>
                                </div>
                                <div class="col-sm-9">
                                    <textarea name="adDescription" id="editAdDescription" class="form-control" rows="3">{{ $ad->description }}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <label for="editAdKeywords" class="control-label">Ad Keywords:</label>
                                </div>
                                <div class="col-sm-9">
                                    <textarea name="adKeywords" id="editAdKeywords" class="form-control" rows="3">{{ $ad->keywords }}</textarea>
                                    <p class="help-block">keywords should be separated by comma.</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <label for="editAdStatu" class="control-label">Ad statu:</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="checkbox">
                                        <input type="checkbox" name="adStatu" @if($ad->turn) checked @endif id="editAdStatu">
                                        <label for="editAdStatu">Active</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button type="submit" name="submitEditAd" value="submit" class="btn btn-primary">Edit</button>
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
                    <h4 class="modal-title" id="formModalLabel">Create new advertisement</h4>
                </div>
                <form class="form-horizontal" role="form" action="{{ URL::action('admin\AdvertisementsController@postSimpleAds') }}" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label for="CeditOwnerEmail" class="control-label">Owner email:</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="email" name="ownerEmail" id="CeditOwnerEmail" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label for="CeditAdTitle" class="control-label">Ad Title:</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" name="adTitle" id="CeditAdTitle" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label for="CeditAdURL" class="control-label">Ad URL:</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="url" name="adURL" id="CeditAdURL" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label for="CeditAdVURL" class="control-label">Ad visible URL:</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" name="adVURL" id="CeditAdVURL" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label for="CeditAdDescription" class="control-label">Ad Description:</label>
                            </div>
                            <div class="col-sm-9">
                                <textarea name="adDescription" id="CeditAdDescription" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label for="CeditAdKeywords" class="control-label">Ad Keywords:</label>
                            </div>
                            <div class="col-sm-9">
                                <textarea name="adKeywords" id="CeditAdKeywords" class="form-control" rows="3"></textarea>
                                <p class="help-block">keywords should be separated by comma.</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label for="CeditAdStatu" class="control-label">Ad statu:</label>
                            </div>
                            <div class="col-sm-9">
                                <div class="checkbox">
                                    <input type="checkbox" name="adStatu" id="CeditAdStatu">
                                    <label for="CeditAdStatu">Active</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="submitNew" value="submit" class="btn btn-primary">Create new</button>
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
        function deleteAd($id){
            c = confirm("Are you sure you want to delete this ad?");
            if(c){
                window.location.href = "{{ route('admin.simpleAds.delete', '') }}/" + $id;
            }
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