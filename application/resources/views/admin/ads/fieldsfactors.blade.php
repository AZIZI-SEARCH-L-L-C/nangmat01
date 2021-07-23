@extends('admin.layout')

@section('title', 'Manage Primary Keywords')
@section('Amonetize', 'active')

@section('css')

@endsection

@section('header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Manage Fiels cost factors
            <small>to control costs</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.searchcompains.get') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Manage Fiels cost factors</li>
        </ol>
    </section>
@endsection


@section('content')

    <div class="row">
        <div class="col-sm-12">
            <button type="button" class="btn ink-reaction btn-primary" data-toggle="modal" data-target="#newPrimaryModal"><i class="fa fa-plus"></i> New Field factor</button>
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
            <h3 class="box-title">Manage Fiels cost factors</h3>
        </div>
        <div class="box-body table-responsive">
            @if($keywords->isEmpty())
                <center>You have no Fiels cost factors right now.</center>
            @else
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Field</th>
                        <th>Leverage</th>
                        <th>Operation</th>
                        <th class="text-right">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($keywords as $keyword)
                        <tr>
                            <td>{{ $fields[$keyword->keyword] }}</td>
                            <td>{{ $keyword->leverage }}%</td>
                            <td>@if(empty($keyword->operation)) {{ $keyword->advancedOperation }} @else {{ $keyword->operation }} @endif</td>
                            <td class="text-right">
                                <button onclick="editModal({{ $keyword->id }}, '{{ $keyword->keyword }}', '{{ $keyword->leverage }}', '{{ $keyword->operation }}', '{{ $keyword->advancedOperation }}');" type="button" data-toggle="modal" data-target="#editModal" class="btn btn-icon-toggle"><i class="fa fa-pencil"></i></button>
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
                    <h4 class="modal-title" id="formModalLabel">Delete Field factor</h4>
                </div>
                <form class="form-horizontal" role="form" action="{{ route('admin.primary.factors.get') }}" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <p>Are you sure you want to delete this Field factor?</p>
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
                    <h4 class="modal-title" id="formModalLabel">Edit Field factor</h4>
                </div>
                <form class="form-horizontal" role="form" action="{{ route('admin.primary.factors.get') }}" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label for="editkeyword" class="control-label">Field:</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="hidden" name="id" id="editkeywordid">
                                <select class="form-control" id="editkeyword" name="keyword" style="margin: 0 auto;width:100%">
                                    @foreach($fields as $fieldKey => $fieldValue)
                                        <option value="{{ $fieldKey }}">{{ $fieldValue }}</option>
                                    @endforeach
                                </select>
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
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label for="editoperationtype" class="control-label">Operation type:</label>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-control" id="editoperationtype" name="operationtype" style="margin: 0 auto;width:100%">
                                    <option value="simple">Simple operation</option>
                                    <option value="advanced">Advanced operation</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" id="editoperationsimpleblock">
                            <div class="col-sm-3">
                                <label for="editoperationsimpletype" class="control-label">Simple operation:</label>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-control" id="editoperationsimpletype" name="simpleoperation" style="margin: 0 auto;width:100%">
                                    <option value="+">(+) Sum of leverege percentage and initial cost</option>
                                    <option value="-">(-) Difference of leverege percentage and initial cost</option>
                                    <option value="*">(*) Product of leverege percentage and initial cost</option>
                                    <option value="/">(/) Quotient of leverege percentage and initial cost</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" id="editoperationadvancedblock" style="display: none;">
                            <div class="col-sm-3">
                                <label for="editoperationadvancedtype" class="control-label">Advanced operation</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" name="advancedoperatin" id="editoperationadvancedtype" class="form-control">
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
                    <h4 class="modal-title" id="formModalLabel">New Field factor</h4>
                </div>
                <form class="form-horizontal" role="form" action="{{ route('admin.primary.factors.get') }}" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label for="newkeyword" class="control-label">Field:</label>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-control" id="newkeyword" name="keyword" style="margin: 0 auto;width:100%">
                                    @foreach($fields as $fieldKey => $fieldValue)
                                        <option value="{{ $fieldKey }}">{{ $fieldValue }}</option>
                                    @endforeach
                                </select>
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
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label for="newoperationtype" class="control-label">Operation type:</label>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-control" id="newoperationtype" name="operationtype" style="margin: 0 auto;width:100%">
                                    <option value="simple">Simple operation</option>
                                    <option value="advanced">Advanced operation</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" id="newoperationsimpleblock">
                            <div class="col-sm-3">
                                <label for="newoperationsimpletype" class="control-label">Simple operation:</label>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-control" id="newoperationsimpletype" name="simpleoperation" style="margin: 0 auto;width:100%">
                                    <option value="+">(+) Sum of leverege percentage and initial cost</option>
                                    <option value="-">(-) Difference of leverege percentage and initial cost</option>
                                    <option value="*">(*) Product of leverege percentage and initial cost</option>
                                    <option value="/">(/) Quotient of leverege percentage and initial cost</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" id="newoperationadvancedblock" style="display: none;">
                            <div class="col-sm-3">
                                <label for="newoperationadvancedtype" class="control-label">Advanced operation</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" name="advancedoperatin" id="newoperationadvancedtype" class="form-control">
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
        $('#newoperationtype').change(function(){
            var $val = $(this).val();
            if($val == 'simple'){
                $('#newoperationsimpleblock').show();
                $('#newoperationadvancedblock').hide();
            }else if($val == 'advanced'){
                $('#newoperationsimpleblock').hide();
                $('#newoperationadvancedblock').show();
            }
        });
        $('#editoperationtype').change(function(){
            var $val = $(this).val();
            if($val == 'simple'){
                $('#editoperationsimpleblock').show();
                $('#editoperationadvancedblock').hide();
            }else if($val == 'advanced'){
                $('#editoperationsimpleblock').hide();
                $('#editoperationadvancedblock').show();
            }
        });
        function editModal($id, $name, $leverage, $simple, $advanced){
            $('#editkeywordid').val($id);
            $('#editkeyword').val($name);
            $('#editleverage').val($leverage);
            if($simple == '0'){
                $('#editoperationtype').val('advanced');
                $('#editoperationsimpleblock').hide();
                $('#editoperationadvancedblock').show();
                $('#editoperationadvancedtype').val($advanced);
            }else{
                $('#editoperationtype').val('simple');
                $('#editoperationsimpleblock').show();
                $('#editoperationadvancedblock').hide();
                $('#editoperationsimpletype').val($simple);
            }
        }

        function deleteModel($id){
            $('#deleteKeywordId').val($id);
        }

    </script>
@endsection