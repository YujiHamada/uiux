@extends('layouts.app')

@section('leftSideBar')
<div class="col mx-3">
    <h3>退会申請</h3>
    <div class="col-12 py-3" style="border: 1px solid #aaa;border-radius: 3px;">
        <form action="/left" method="post">
            {{ csrf_field() }}
            <div class="mb-3 p-3">
                <div>
                    <input id="trouble" type="checkbox" name="reasons[]" value="サービス内で対人トラブルがあった"><label for="trouble">サービス内で対人トラブルがあった</label>
                </div>
                <div>
                    <input id="unpleasant" type="checkbox" name="reasons[]" value="このサービスによって不快な思いをした"><label for="unpleasant">このサービスによって不快な思いをした</label>
                </div>
                <div>
                    <input id="operation" type="checkbox" name="reasons[]" value="操作がしづらかった"><label for="operation">操作がしづらかった</label>
                </div>
                <div>
                    <input id="useless" type="checkbox" name="reasons[]" value="役に立たなかった"><label for="useless">役に立たなかった</label>
                </div>
                <div>
                    <input id="inferior" type="checkbox" name="reasons[]" value="他のQ＆Aサービスの方が魅力的だった"><label for="inferior">他のレビューサービスの方が魅力的だった</label>
                </div>
                <div>
                    <input id="handle" type="checkbox" name="reasons[]" value="使い方がわからなかった"><label for="handle">使い方がわからなかった</label>
                </div>
                <div>
                    <input id="tired" type="checkbox" name="reasons[]" value="サービスの利用に飽きた"><label for="tired">サービスの利用に飽きた</label>
                </div>
                <div>
                    <input id="other" type="checkbox" name="reasons[]" value="その他の理由"><label for="other">その他の理由</label>
                </div>
            </div>
            <h6>その他ご意見などございましたら、ご記入ください。</h6>

            <textarea name="otherReasons" maxlength="1000" cols="30" rows="6" id="UserLeaveComment" style="width: 100%"></textarea>

            <div class="alert alert-danger my-3" role="alert">
                退会処理を行うと、あなたのプロフィール情報、スコア等が全て削除されます。<br>レビューやコメントなどの投稿情報は「退会済みユーザー」として残りますので、ご了承ください。
            </div>

            <div class="text-center">
                <button type=" submit" class="yy-pointer btn btn-warning">退会する</button>
            </div>
        </form>
    </div>
</div>
@endsection

{{-- 右サイドバーは不要のため、空で上書き --}}
@section('rightSideBar')
@endsection

@section('foot')
  @parent
@endsection
