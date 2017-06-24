<script>
  //追加したタグを削除する。jqueryでの追加要素なので、$(document)から指定している。
  $(document).on('click', '.removeTag', function(){
    //removeに動作つけるためコールバックしている
    $(this).parent().hide('slow', function(){
      $(this).remove();
    });
  });
</script>
