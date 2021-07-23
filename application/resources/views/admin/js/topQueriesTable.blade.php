var area = new Morris.Area({
    element   : 'topQueries-chart',
    resize    : true,
    data      : [
	@foreach($QueriesPerday as $QueryPerday)
      { y: {{ strtotime($QueryPerday->created_at) * 1000 }}, item1: {{ $QueryPerday->total }} },
	@endforeach
    ],
    xkey      : 'y',
    ykeys     : ['item1'],
    labels    : ['Queries'],
    xLabels   : "day",
    lineColors: ['#3c8dbc'],
    hideHover : 'auto',
	xLabelFormat : function (x) { 
		var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
		return months[x.getMonth()] + ' ' + x.getDate();
	}
	// return x.getMonth() + 1; }
  });