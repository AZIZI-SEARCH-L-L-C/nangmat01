@extends('admin.layout')

@section('title', 'Manage Primary Keywords')
@section('Amonetize', 'active')

@section('css')

@endsection

@section('header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Manage Premium Keywords
            <small>to control costs</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.searchcompains.get') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Manage Premium Keywords</li>
        </ol>
    </section>
@endsection


@section('content')

    <div class="row">
        <div class="col-sm-12">
            <button type="button" class="btn ink-reaction btn-primary" data-toggle="modal" data-target="#newPrimaryModal"><i class="fa fa-plus"></i> New Premium keyword</button>
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
            <h3 class="box-title">Manage Premium Keywords</h3>
        </div>
        <div class="box-body table-responsive">
            @if($keywords->isEmpty())
                <center>You have no Premium keywords right now.</center>
            @else
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Keyword</th>
                        <th>Leverage</th>
                        <th class="text-right">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($keywords as $keyword)
                        <tr>
                            <td>{{ $keyword->keyword }}</td>
                            <td>{{ $keyword->leverage }}%</td>
                            <td class="text-right">
                                <button onclick="editModal({{ $keyword->id }}, '{{ $keyword->keyword }}', '{{ $keyword->leverage }}');" type="button" data-toggle="modal" data-target="#editModal" class="btn btn-icon-toggle"><i class="fa fa-pencil"></i></button>
                                <button onclick="deleteModel({{ $keyword->id }});" type="button" data-toggle="modal" data-target="#deletModel" class="btn btn-icon-toggle"><i class="fa fa-trash-o"></i></button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <center>{{ $keywords->render() }}</center>
            @endif
        </div><!--end .card-body -->
    </div><!--end .card -->

    <!-- BEGIN FORM MODAL MARKUP -->
    <div class="modal fade" id="deletModel" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="formModalLabel">Delete Premium keyword</h4>
                </div>
                <form class="form-horizontal" role="form" action="{{ route('admin.primary.keywords.get') }}" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <p>Are you sure you want to delete this Premium keyword?</p>
                            </div>
                            <input type="hidden" name="id" id="deleteKeywordId">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="submitDeletePrimary" value="submit" class="btn btn-primary">Delete</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- END FORM MODAL MARKUP -->

    <!-- BEGIN FORM MODAL MARKUP -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="formModalLabel">Edit Premium keyword</h4>
                </div>
                <form class="form-horizontal" role="form" action="{{ route('admin.primary.keywords.get') }}" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label for="editkeyword" class="control-label">Premium keyword:</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="hidden" name="id" id="editkeywordid">
                                <input type="text" name="keyword" id="editkeyword" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label for="editleverage" class="control-label">Leverage (%):</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="number" name="leverage" id="editleverage" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="submitEditPrimary" value="submit" class="btn btn-primary">Edit</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- END FORM MODAL MARKUP -->

    <!-- BEGIN FORM MODAL MARKUP -->
    <div class="modal fade" id="newPrimaryModal" tabindex="false" role="dialog" aria-labelledby="formModalLabelnewCompainModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="formModalLabel">New Premium keyword</h4>
                </div>
                <form class="form-horizontal" role="form" action="{{ route('admin.primary.keywords.get') }}" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label for="newkeyword" class="control-label">Premium keyword:</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" name="keyword" id="newkeyword" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label for="newleverage" class="control-label">Leverage (%):</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="number" name="leverage" id="newleverage" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="submitNewPrimary" value="submit" class="btn btn-primary">New</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- END FORM MODAL MARKUP -->
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

@endsection

@section('javascript')
    <script>
        function editModal($id, $name, $leverage){
            $('#editkeywordid').val($id);
            $('#editkeyword').val($name);
            $('#editleverage').val($leverage);
        }

        function deleteModel($id){
            $('#deleteKeywordId').val($id);
        }

    </script>
@endsection