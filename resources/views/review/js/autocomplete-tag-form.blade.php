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

    //画像ファイルプレビュー表示のイベント追加 fileを選択時に発火するイベントを登録
    $('form').on('change', 'input[type="file"]', function(e) {
      let file = e.target.files[0]
      let reader = new FileReader()
      let $preview = $(".preview");
      let t = this;

      // 画像ファイル以外の場合は何もしない
      if(file.type.indexOf("image") < 0){
        return false;
      }

      // ファイル読み込みが完了した際のイベント登録
      reader.onload = (function(file) {
        return function(e) {
          //既存のプレビューを削除
          $preview.empty();
          // .prevewの領域の中にロードした画像を表示するimageタグを追加
          $preview.append($('<img>').attr({
                    src: e.target.result,
                    width: "150px",
                    class: "preview",
                    title: file.name
                }));
        };
      })(file);
      reader.readAsDataURL(file);
    });
  });
</script>
