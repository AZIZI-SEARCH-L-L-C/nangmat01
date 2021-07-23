@extends('admin.layout')

@section('title', 'Templates settings')
@section('Aplugins', 'active')

@section('content')

<div class="row">
	<a style="margin-left:15px;" href="" class="btn btn-primary" data-toggle="modal" data-target="#templateUpload">Upload template</a>
</div><br/>

@if(Session::has('message'))
	<div class="alert @if(Session::get('messageType') == 'success') alert-success @else alert-danger @endif" role="alert">
		{{ Session::get('message') }}
	</div>
@endif
<div class="row">
  @foreach($templates as $Ctemplate)
	<div class="col-md-4">
      <div class="box box-primary box-solid">
        <div class="box-header">
          <div class="card-title">{{ $Ctemplate }} template</div>
			<div class="box-tools pull-right">
				<a @if($Ctemplate != $template) href="{{ action('admin\TemplatesController@setTemplate', $Ctemplate) }}" @endif class="btn btn-box-tool" title="Make template default">
					<i @if($Ctemplate == $template) style="color:green;" @endif class="fa fa-check-circle"></i></a>
			</div>
          {{--<ul class="card-action">--}}
            {{--<li class="dropdown">--}}
              {{--<a @if($Ctemplate != $template) href="{{ action('admin\TemplatesController@setTemplate', $Ctemplate) }}" @endif>--}}
                {{--<i @if($Ctemplate == $template) style="color:green;" @endif class="fa fa-check-circle" aria-hidden="true"></i>--}}
              {{--</a>--}}
            {{--</li>--}}
          {{--</ul>--}}
        </div>
        <div class="box-body">
            <img src="{{ Asset('assets/templates/'.$Ctemplate.'/show.png') }}" width="100%" />
        </div>
      </div>
    </div>
  @endforeach
</div>


<div class="modal fade" id="templateUpload" tabindex="-1" role="dialog" aria-labelledby="templateUpload">
    <form class="form" method="post" id="form" action="{{ action('admin\TemplatesController@upload') }}" enctype="multipart/form-data">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Upload new template</h4>
				</div>
			<div style="display:block;" class="modal-body" id="uploadBlock">
			<div id="statuBlock" class="row statuBlock" style="display:none;">
				<div class="col-sm-12">
					<div id="statu" class="alert alert-dismissible statu" role="alert">
						the template installed, please reload this page.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
					</div>
				</div>
			</div>

			<div class="row" style="text-align:center;" id="upBlock">
				<p>If you have a template in a .zip format, you may install it by uploading it here.</p>
				<a onclick="select_file()" class="btn btn-primary">Choose File</a>
				<p style="display: inline-block;margin-left: 15px;" id="fileName"></p>
				<input style="display:none;" id="template" type="file" name="template">
			</div>


			<div class="row" id="progressBlock" style="display:none;">
				<div class="progress">
					<div id="progress" class="progress-bar  progress-bar-striped active" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
					<span class="sr-only">80% Complete (danger)</span>
					</div>
				</div>
			</div>

			</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</form>
</div>

@endsection


@section('javascript')
<link type="text/css" rel="stylesheet" href="https://demo.azizisearch.com/starter/google/assets/admin/css/dropzone/dropzone-theme.css"/>
<script type="text/javascript" src="https://demo.azizisearch.com/starter/google/assets/admin/js/dropzone/dropzone.js"></script>
<!-- jQuery Library--
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript" src="//malsup.github.com/jquery.form.js" /></script-->
<script>
@if($uploadTemplate)
    $(window).on('load',function(){
		$('#templateUpload').modal('show');
	});
@endif

function select_file(){
    $('#template').click();
    return false;
}

var name = '';
var upBlock = $id("upBlock");
var fileselect = $id("template");
var form = $id("form");
var submit = $id("submit");
var statu = $id("statu");
var progressBlock = $id("progressBlock");
var statuBlock = $id("statuBlock");
var fileName = $id("fileName");
var uploadBlock = $id("uploadBlock");
var blockPluginInfo = $id("blockPluginInfo");

$("input[type=file]").on('change',function(e){
    fileName.innerHTML = e.target.files[0].name;
	FileSelectHandler(e.target.files[0]);
});

$("#submit").on('click',function(e){
    StartInstaller(name);
});
			

// upload JPEG files
function UploadFile(file) {

	var xhr = new XMLHttpRequest();
	if (xhr.upload) {
	    
		var progress = $id("progress");
		xhr.upload.addEventListener("progress", function(e) {
			var pc = parseInt(e.loaded / e.total * 100);
			progress.style.width = pc + "%";
		}, false);
		xhr.onreadystatechange = function(e) {
			progressBlock.style.display = 'block';
			if (xhr.readyState == 4) {
				if(xhr.status == 200){
					progressBlock.style.display = 'block';
					statuBlock.style.display = 'block';
					progress.className += " progress-bar-success";
					statu.className += " alert-success";
					upBlock.style.display = 'none';
					progressBlock.style.display = 'none';
					obj = JSON.parse(xhr.response);
				    statu.innerHTML = obj.msg;
				}else{
					progressBlock.style.display = 'block';
					statuBlock.style.display = 'block';
					progress.className += " progress-bar-danger";
					statu.className += " alert-danger";
					statu.innerHTML = xhr.response;
				}
			}else{
				// not ready yet
			}
		};
		xhr.open("POST", form.action, true);
		var formData = new FormData();
		formData.append('template', file);
		xhr.send(formData);

	}

}
	
    // file selection
    function FileSelectHandler(f) {
		
		// fetch FileList object
		// var files = e.target.files || e.dataTransfer.files;
		// var files = fileselect.files;

		// process all File objects
		// for (var i = 0, f; f = files[i]; i++) {
			// ParseFile(f);
			UploadFile(f);
		// }

	}
	
	// getElementById
	function $id(id) {
		return document.getElementById(id);
	}
	
	// getElementsByClassName
	function $getClass($class1) {
		return document.getElementsByClassName($class1);
	}
</script>
@endsection