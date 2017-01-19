$(document).ready(function() {
    $('.editable').editable();

    $('.editable').on('shown', function(e, editable) {
        var csrf = $('meta[name="_token"]').attr('content');
        var input = '<input type="hidden" name="_token" value="';
        input += csrf;
        input += '">';
        // $('.editableform').prepend(input);
        // $(".editable").submit( function(eventObj) {
        //     $('<input />').attr('type', 'hidden')
        //         .attr('name', "_token")
        //         .attr('value', csrf)
        //         .appendTo($this);
        //     return true;
        // });

    });
});