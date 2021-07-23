// Donut Chart
  var devices = new Morris.Donut({
    element  : 'devices-chart',
    resize   : true,
    colors   : ['{!! implode("','",$colors) !!}'],
    data     : [
	@foreach($devices as $device)
      { label: '{{ $device->device }}', value: {{ $device->total }} },
	@endforeach
    ],
    hideHover: 'auto'
  });

@foreach($devices as $device)
    $('#devicesLabels').append('<li><i class="fa fa-circle-o text-red" style="color:{{ $colors[$i] }} !important;"></i> {{ $device->device }}</li>');
	<?php $i++ ?>
@endforeach