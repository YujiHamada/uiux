<script>
  //エンター押下時の制御
  $("#tag-btn").on('click',function(){
      var typedTag = $("#tag").val();
      if(typedTag.length > 0) {
        inputTag(typedTag);
        //オートコンプリートをクローズすることでオートコンプリートのセレクトを呼び出さないようにしている
        $('#tag').autocomplete('close');
        $("#tag").val('');
      }
    }
  );
</script>
