@extends('layouts.app')

@section('content')
  <div id="example"></div>
  <form class="form-horizontal" role="form" method="POST" action="{{ url('review/create') }}" enctype="multipart/form-data">
  	{{ csrf_field() }}
  	タイトル：
    <input id="title" type="text" class="form-control" name="title" value="{{ old('title') }}" required autofocus>
  	詳細：
    @if ($errors->has('title'))
      <span class="help-block">
        <strong>{{ $errors->first('title') }}</strong>
      </span>
    @endif
      <textarea id="description" type="text" class="form-control" name="description">{{ old('description') }}</textarea>
    @if ($errors->has('description'))
      <span class="help-block">
          <strong>{{ $errors->first('description') }}</strong>
      </span>
    @endif
    URL：
    <input id="url" type="text" class="form-control" name="url" value="{{ old('url') }}">
    @if ($errors->has('url'))
      <span class="help-block">
          <strong>{{ $errors->first('url') }}</strong>
      </span>
    @endif
    カテゴリー：
    <select name="category" class="form-control">
      <?php foreach($categories as $category): ?>
        <option value="{{$category->id}}">{{$category->name}}</option>
      <?php endforeach; ?>
    </select>

    <label class="radio-inline">
      <input type="radio" name="good_or_bad" value="1">Good
    </label>
    <label class="radio-inline">
      <input type="radio" name="good_or_bad" value="0">BAD
    </label>
    <label class="radio-inline">
      <input type="radio" name="good_or_bad" value="2">SoSo...
    </label>
    @if ($errors->has('good_or_bad'))
      <span class="help-block">
          <strong>{{ $errors->first('good_or_bad') }}</strong>
      </span>
    @endif
    <input type="file" name="uiImage">
    <button type="submit" class="btn btn-primary">投稿</button>
  </form>
  <div class="preview">
  </div>
@endsection

@section('foot')
  @parent
  <script>
    $(function(){
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
@endsection
