<script>
  function inputTag(selectedTag){
    var selectedTags = $(':hidden[name="review_tag_names[]"]').map(function() {
      return $(this).val();
    }).get();
    //選択したタグがすでに選択されているか判定
    if($.inArray(selectedTag, selectedTags) >= 0){
      if(document.getElementsByClassName('alert-warning').length == 0){
        //エラーメッセージがすでにあるか一応判定（jqueryでDOM判定は遅いそうなのでgetElementsByClassNameを使用
        $('.tags').append('<div class="alert alert-warning">' + selectedTag + 'はすでに登録されています</div>');
      }
    }else{
      $('.tags').append('<span class="badge badge-pill badge-default">' + selectedTag + '<span class="removeTag"> ✕</span>'+ '<input name="review_tag_names[]" type="hidden" value="' + selectedTag + '">' +'</span>');
    }
  }
</script>
