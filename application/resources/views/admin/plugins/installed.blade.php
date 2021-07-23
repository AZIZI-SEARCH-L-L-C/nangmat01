@extends('admin.layout')

@section('title', 'Plugins manager')
@section('Aplugins', 'active')

@section('content')

    <div class="row">
		<a style="margin-left:15px;" href="" class="btn btn-primary" data-toggle="modal" data-target="#pluginUpload">Upload plugin</a>
	</div><br>

	<form class="form" method="post" id="form" action="{{ action('admin\PluginsController@upload') }}" enctype="multipart/form-data">
		<div class="box box-primary box-solid">
			<div class="box-body">
				@if(Session::has('message'))
					<div class="row">
						<div class="alert @if(Session::get('messageType') == 'success') alert-success @else alert-danger @endif" role="alert">
							{{ Session::get('message') }}
				        </div>
				    </div>
				@endif

                <div class="row">
				@if($plugins)
				    @foreach($plugins as $plugin)
				    <div class="col-md-3 col-sm-6">
					    <div class="thumbnail">
						    <img src="{{ asset('assets/plugins/'.$plugin['thumbnail']) }}" class="img-responsive">
                            <div class="caption">
                                <h3 class="title">{{ $plugin['title'] }}<a class="anchorjs-link" href="#thumbnail-label"><span class="anchorjs-icon"></span></a></h3>
                                <p class="description">{{ $plugin['description'] }}</p>
                                <div><a href="{{ action('admin\PluginsController@activate', ['plugin' => $plugin['id']]) }}" class="btn @if($plugin['active']) btn-warning @else btn-success @endif btn-xs" role="button">@if($plugin['active']) Disactivate @else Activate @endif</a> @if($plugin['hasAdmin']) <a href="{{ action($plugin['manageAction']) }}" class="btn btn-light btn-default btn-xs" role="button">Manage</a> @endif </div>
                            </div>
					    </div>
				    </div>
					@endforeach
				@else
				    <p style="text-align:center;">No plugin installed right now.</p>
				@endif
                </div>
				
				
    <div class="modal fade" id="pluginUpload" tabindex="-1" role="dialog" aria-labelledby="pluginUpload">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Upload new plugin</h4>
          </div>
          <div style="display:block;" class="modal-body" id="uploadBlock">
			<div id="statuBlock" class="row statuBlock" style="display:none;">
			    <div class="col-sm-12">
    			    <div id="statu" class="alert alert-dismissible statu" role="alert">
     				    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    			    </div>
			    </div>
			</div>
			
			<div class="row" style="text-align:center;">
			    <p>If you have a plugin in a .zip format, you may install it by uploading it here.</p>
				<a onclick="select_file()" class="btn btn-primary">Choose File</a>
				<p style="display: inline-block;margin-left: 15px;" id="fileName"></p>
    			<input style="display:none;" id="plugin" type="file" name="plugin">
			</div>
			
			
            <div class="row" id="progressBlock" style="display:none;">
            <div class="progress">
                <div id="progress" class="progress-bar  progress-bar-striped active" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                <span class="sr-only">80% Complete (danger)</span>
                </div>
            </div>
            </div>
	  
          </div>
          <div style="display:none;" class="modal-body" id="blockPluginInfo">
		    <div id="statuBlock2" class="row" style="display:none;">
			    <div class="col-sm-12">
    			    <div id="statu2" class="alert alert-dismissible" role="alert">
     				    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    			    </div>
			    </div>
			</div>
			
		    <p>Plugin name: <span id="pluginName"></span></p>
		    <p>Plugin description: <span id="pluginDescription"></span></p>
		    <p>Plugin publisher: <span id="pluginPublisher"></span></p>
		  </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
            <button style="display:none;" type="button" name="submit" id="submit" type="submit" class="btn btn-sm btn-success">Install Now</button>
          </div>
        </div>
      </div>
    </div>
				
				
			</div>
		</div>
	</form>
@endsection

@section('javascript')
<link type="text/css" rel="stylesheet" href="https://demo.azizisearch.com/starter/google/assets/admin/css/dropzone/dropzone-theme.css"/>
<script type="text/javascript" src="https://demo.azizisearch.com/starter/google/assets/admin/js/dropzone/dropzone.js"></script>
<!-- jQuery Library--
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript" src="//malsup.github.com/jquery.form.js" /></script-->
<script>
@if($uploadPlug)
    $(window).on('load',function(){
		$('#pluginUpload').modal('show');
	});
@endif

function select_file(){
    $('#plugin').click();
    return false;
}

var name = '';
var fileselect = $id("plugin");
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
			if (xhr.readyState == 4) {
				if(xhr.status == 200){
					progressBlock.style.display = 'block';
			        statuBlock.style.display = 'block';
					progress.className += " progress-bar-success";
					statu.className += " alert-success";
					obj = JSON.parse(xhr.response);
					statu.innerHTML = obj.msg;
					getPluginInfo(obj.file);
				}else{
					progressBlock.style.display = 'block';
			        statuBlock.style.display = 'block';
					progress.className += " progress-bar-danger";
					statu.className += " alert-danger";
					statu.innerHTML = xhr.response;
				}
			}
		};
		xhr.open("POST", form.action, true);
		var formData = new FormData();
		formData.append('plugin', file);
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
	
	// start installer
    function StartInstaller(name) {
        console.log(name);
		var xhhtp2 = new XMLHttpRequest();
		if (xhhtp2.upload) {
			
			xhhtp2.onreadystatechange = function(e) {
				if (xhhtp2.readyState == 4 && xhhtp2.status == 200) {
					$id('statu2').className += " alert-success";
					$id('statu2').innerHTML = xhhtp2.response + ', Please refresh the page.';
					$id('statuBlock2').style.display = 'block';
				}
			}
				
			xhhtp2.open("POST", "{{ action('admin\PluginsController@install') }}", true);
		    var formData = new FormData();
		    formData.append('file', name);
		    xhhtp2.send(formData);
		}
	}
	
	function getPluginInfo (f) {
		var xhhtp = new XMLHttpRequest();
		if (xhhtp.upload) {
			
			xhhtp.onreadystatechange = function(e) {
				if (xhhtp.readyState == 4 && xhhtp.status == 200) {
					data = JSON.parse(xhhtp.response);
					uploadBlock.style.display = 'none';
					blockPluginInfo.style.display = 'block';
					submit.style.display = 'inline-block';
					name = f;
					$id("pluginName").innerHTML = data.name;
					$id("pluginDescription").innerHTML = data.description;
					$id("pluginPublisher").innerHTML = data.publisher;
				}
			}
				
			xhhtp.open("POST", "{{ action('admin\PluginsController@pluginManifest') }}", true);
		    var formData = new FormData();
		    formData.append('name', f);
		    xhhtp.send(formData);
		}
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
