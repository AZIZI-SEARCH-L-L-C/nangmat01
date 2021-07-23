// Donut Chart
  var browsers = new Morris.Donut({
    element  : 'topBrowsers-chart',
    resize   : true,
    colors   : ['{!! implode("','",$colors) !!}'],
    data     : [
	@foreach($browsers as $browser)
      { label: '{{ $browser->browser }}', value: {{ $browser->total }} },
	@endforeach
    ],
    hideHover: 'auto'
  });


@foreach($browsers as $browser)
    $('#browsersLabels').append('<li><i class="fa fa-circle-o text-red" style="color:{{ $colors[$i] }} !important;"></i> {{ $browser->browser }}</li>');
	<?php $i++ ?>
@endforeach