@extends('layouts.app')

@section('content')
  <div class="col mx-3">
    <h1>レビュー依頼する</h1>
    <form class="form-horizontal" role="form" method="POST" action="{{ url('/request') }}" enctype="multipart/form-data">
    	{{ csrf_field() }}
    	タイトル：
      <input id="title" type="text" class="form-control" name="title" value="{{ old('title', isset($review->title) ? $review->title : '') }}" required autofocus>
    	詳細：
      @if ($errors->has('title'))
        <span class="help-block">
          <strong>{{ $errors->first('title') }}</strong>
        </span>
      @endif
      <textarea id="description" type="text" class="form-control" name="description">{{ old('description', isset($review->description) ? $review->description : '') }}</textarea>
      @if ($errors->has('description'))
        <span class="help-block">
            <strong>{{ $errors->first('description') }}</strong>
        </span>
      @endif
      URL：
      <input id="url" type="text" class="form-control" name="url" value="{{ old('url', isset($review->url) ? $review->url : '') }}">
      @if ($errors->has('url'))
        <span class="help-block">
            <strong>{{ $errors->first('url') }}</strong>
        </span>
      @endif
      タグ：
      <div class="tags">
        <input type="text" id="tag">
        @if(isset($review))
          @foreach($review->reviewTag as $reviewTag)
            <span class="badge badge-pill badge-default">{{ $reviewTag->tag->name }}</span>
            <input name="review_tag_names[]" type="hidden" value="{{$reviewTag->tag->name}}">
          @endforeach
        @endif
      </div>
      @if ($errors->has('tags'))
        <span class="help-block">
            <strong>{{ $errors->first('tags') }}</strong>
        </span>
      @endif

      <input type="file" name="uiImage" value="{{ old('uiImage') }}">
      <button type="submit" class="btn btn-primary">投稿</button>
    </form>
    <div class="preview">
    </div>
  </div>
@endsection

@section('foot')
  @parent
  <link rel="stylesheet" type="text/css" href="/css/jquery-ui.min.css">
  <script src="/js/jquery-ui.min.js"></script>
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
    //追加したタグを削除する。jqueryでの追加要素なので、$(document)から指定している。
    $(document).on('click', '.removeTag', function(){
      //removeに動作つけるためコールバックしている
      $(this).parent().hide('slow', function(){
        $(this).remove();
      });
    });

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
@endsection
