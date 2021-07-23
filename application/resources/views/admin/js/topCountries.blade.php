// jvectormap data
  var visitorsData = {
	@foreach($countries as $country)
		{{ $country->country }}: {{ $country->total }},
	@endforeach
  };
	
  // World map by jvectormap
  $('#world-map').vectorMap({
    map              : 'world_mill_en',
    backgroundColor  : '#fff',
    regionStyle      : {
      initial: {
        fill            : '#d2d6de',
        'fill-opacity'  : 1,
        stroke          : 'none',
        'stroke-width'  : 1,
        'stroke-opacity': 1
      }
    },
    series           : {
      regions: [
        {
          values           : visitorsData,
          scale            : ['#ebf4f9', '#0073b7'],
          normalizeFunction: 'polynomial'
        }
      ]
    },
    onRegionLabelShow: function (e, el, code) {
		$("#country-selected").html(el.html());
        if (typeof visitorsData[code] != 'undefined'){
		    $("#country-total-selected").html(visitorsData[code]);
	    }else{
			$("#country-total-selected").html(0);
		}
    }
  });