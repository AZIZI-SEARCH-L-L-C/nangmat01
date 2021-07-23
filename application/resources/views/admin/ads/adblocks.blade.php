@extends('admin.layout')

@section('title', 'Manage Primary Keywords')
@section('Amonetize', 'active')

@section('css')

@endsection

@section('header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Manage Ads blocks
            <small>custom ads</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.searchcompains.get') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Manage ads blocks</li>
        </ol>
    </section>
@endsection


@section('content')

    <div class="row">
        <div class="col-sm-12">
            <button type="button" class="btn ink-reaction btn-primary" data-toggle="modal" data-target="#newAdBlockModal"><i class="fa fa-plus"></i> New Ad Block</button>
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
            <h3 class="box-title">Manage ads blocks</h3>
        </div>
        <div class="box-body table-responsive">
            @if(empty($adblocks))
                <center>You have no ads blocks right now.</center>
            @else
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Placement</th>
                        <th>Code</th>
                        <th class="text-right">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($adblocks as $adblockname => $adblock)
                        <tr>
                            <td>{{ str_replace('ad_block_'.array_get(explode('_', $adblockname), '2').'_', '', $adblockname) }}</td>
                            <td>{{ $placements[array_get(explode('_', $adblockname), '2')] }}</td>
                            <td>&#x7B;!! ${{ str_replace('block_', '', $adblockname) }} !!&#x7D;</td>
                            <td class="text-right">
                                <button data-content="{{ $adblock }}" onclick="editModal(this, '{{ str_replace('ad_block_'.array_get(explode('_', $adblockname), '2').'_', '', $adblockname) }}', '{{ array_get(explode('_', $adblockname), '2') }}');" type="button" data-toggle="modal" data-target="#editModal" class="btn btn-icon-toggle"><i class="fa fa-pencil"></i></button>
                                <button onclick="deleteModel('{{ $adblockname }}');" type="button" data-toggle="modal" data-target="#deletModel" class="btn btn-icon-toggle"><i class="fa fa-trash-o"></i></button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div><!--end .card-body -->
    </div><!--end .card -->

    <!-- BEGIN FORM MODAL MARKUP -->
    <div class="modal fade" id="deletModel" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="formModalLabel">Delete Ad Block</h4>
                </div>
                <form class="form-horizontal" role="form" action="{{ route('admin.adsblocks.get') }}" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <p>Are you sure you want to delete this Ad Block?</p>
                            </div>
                            <input type="hidden" name="id" id="deleteAdBlockId">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="submitDeleteAdBlock" value="submit" class="btn btn-primary">Delete</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- END FORM MODAL MARKUP -->

    <!-- BEGIN FORM MODAL MARKUP -->
    <div class="modal fade" id="newAdBlockModal" tabindex="false" role="dialog" aria-labelledby="formModalLabelnewCompainModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="formModalLabel">New Ad Block</h4>
                </div>
                <form class="form-horizontal" role="form" action="{{ route('admin.adsblocks.get') }}" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label for="newkeyword" class="control-label">Name:</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" name="name" id="newkeyword" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label for="placement" class="control-label">Placement:</label>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-control" name="placement" style="margin: 0 auto;width:100%">
                                    @foreach($placements as $placementId => $placement)
                                        <option value="{{ $placementId }}">
                                            {{ $placement }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label for="newleverage" class="control-label">Ad content</label>
                            </div>
                            <div class="col-sm-9">
                                <textarea col="3" name="adcontent" id="newleverage" class="form-control"></textarea>
                                <p>HTML tags are allowed.</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="submitNewAdBlock" value="submit" class="btn btn-primary">New</button>
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
                    <h4 class="modal-title" id="formModalLabel">Edit Ad Block</h4>
                </div>
                <form class="form-horizontal" role="form" action="{{ route('admin.adsblocks.get') }}" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label for="editname" class="control-label">Name:</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="hidden" name="name" id="editnameHidden">
                                <input type="text" disabled id="editname" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label for="editplacement" class="control-label">Placement:</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="hidden" name="placement" id="editplacementHidden">
                                <select class="form-control" id="editplacement" disabled style="margin: 0 auto;width:100%">
                                    @foreach($placements as $placementId => $placement)
                                        <option value="{{ $placementId }}">
                                            {{ $placement }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label for="editblock" class="control-label">Ad content</label>
                            </div>
                            <div class="col-sm-9">
                                <textarea col="3" name="adcontent" id="editblock" class="form-control"></textarea>
                                <p>HTML tags are allowed.</p>
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
        function editModal($this, $name, $placement){
            $block = $($this).data('content');
            $('#editname').val($name);
            $('#editnameHidden').val($name);
            $('#editblock').val($block);
            $('#editplacement').val($placement);
            $('#editplacementHidden').val($placement);
        }

        function deleteModel($id){
            $('#deleteAdBlockId').val($id);
        }

    </script>
@endsection