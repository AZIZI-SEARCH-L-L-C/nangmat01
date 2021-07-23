$(document).ready(function() {
    var input = document.getElementById($main_input_id);
    if(input) {
        var len = input.value.length;
        input.focus();
        input.setSelectionRange(len, len);
    }
});