<link rel="stylesheet" type="text/css" href="/css/jquery-ui.min.css">
<script src="/js/jquery-ui.min.js"></script>
<script>
  $(function(){
    // autocompleteで使用する値候補
    var name = [{!! $tagNames !!}];

    $('#tag').autocomplete({
      source: name,
      change: function(event, ui) {
        //警告メッセージの削除
        $('.alert-warning').remove();
      },
      search: function(event, ui) {
        //警告メッセージの削除
        $('.alert-warning').remove();
      },
      select: function(event, ui) {
        inputTag(ui.item.value);
        $('#tag').val('');
        //jquery autocompleteの機能でtextが保管されるのでpreventDefault()。jquery-ui.jsの5860行目あたり
        event.preventDefault();
      },
    });
  });
</script>
