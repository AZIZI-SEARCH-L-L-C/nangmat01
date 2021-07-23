// Donut Chart
  var oss = new Morris.Donut({
    element  : 'oss-chart',
    resize   : true,
    colors   : ['{!! implode("','",$colors) !!}'],
    data     : [
	@foreach($OSs as $os)
      { label: '{{ $os->os }}', value: {{ $os->total }} },
	@endforeach
    ],
    hideHover: 'auto'
  });


@foreach($OSs as $os)
    $('#ossLabels').append('<li><i class="fa fa-circle-o text-red" style="color:{{ $colors[$i] }} !important;"></i> {{ $os->os }}</li>');
	<?php $i++ ?>
@endforeach