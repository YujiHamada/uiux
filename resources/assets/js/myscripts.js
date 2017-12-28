$.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
});
$(function() {
  $(document).on("keypress", "input:not(.allow_submit)", function(event) {
    return event.which !== 13;
  });
});
$(function () {
    $('form').submit(function () {
        $(this).find('.non-double-click').attr('disabled', 'disabled');
    });
});
