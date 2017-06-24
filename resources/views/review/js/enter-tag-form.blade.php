<script>
  //エンター押下時の制御
  $("#tag").keydown(function(event){
    if(event.keyCode == 13) {
      var typedTag = $("#tag").val();
      event.preventDefault();
      if(typedTag.length > 0) {
        inputTag(typedTag);
        event.preventDefault();
        //オートコンプリートをクローズすることでオートコンプリートのセレクトを呼び出さないようにしている
        $('#tag').autocomplete('close');
        $(this).val('');
      }
    }
  });
</script>
