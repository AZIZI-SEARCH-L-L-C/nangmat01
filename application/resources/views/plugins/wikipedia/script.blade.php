$.get( "{{ route('plugin.wikipedia.query') }}", { q : '{{ $query }}', e : '{{ $engine }}' }, function( data ) {
    $('#wiki-info').html(data);
});