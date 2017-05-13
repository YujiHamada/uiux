@extends('layouts.app')

@section('content')
  <div class="col mx-0 px-0">
    <div class="yy-about">
      <img class="mx-auto d-block" src="/images/app_images/yyuxlogo_black.png" alt="yyUXネコ">
      <h1 class="text-center">yyUXについて</h1>
      <div class="mt-5">
        <h2>yyUXは<span class="yy-emphasis">世の中のすべてのUXを良くしたい</span>と願っています。このサイトはそのための<span class="yy-emphasis">議論の場を提供</span>します</h2>
        <p>WEBサイト・アプリを使用していて、使いづらいなと感じることはありませんか？またサービス自体はいいのに、サービスではない別の部分で損をしていると感じるものはありませんでしたか？</p>
        <p>またサービス全体を通して素晴らしい体験を経験したことはありませんか？</p>
        <p>私たちはyyUXを通して、世の中のUXを改善、そして素晴らしい体験を広めたいと考えています。</p>
        <p>yyUXでは<span class="yy-emphasis">レビュー</span>と<span class="yy-emphasis">レビュー依頼機能</span>を用意してあります。世の中のありとあらゆるUXについてレビューし、そしてしてもらいましょう！。UXについてyy（ワイワイ）議論しましょう！</p>
      </div>

      <div class="mt-5">
        <h2>yyUXでは<span class="yy-emphasis">レビューの種類を大きく３つ</span>に分けています</h2>
        <h3 class="good_ux">GOOD UX</h3>
        <p>「GOOD UX」では素晴らしいUXに対するレビューです。何が優れていたのか、何を持って良いと感じたかを明確にすることで、他サイト等に活かすことができます。</p>
        <p>また誰かが素晴らしいと思っていてもそうではないと感じることはあると思います。どうすれば更に良くなるか、議論を深めましょう。</p>
        <h3 class="good_ux">KAIZEN UX</h3>
        <p>「KAIZEN UX」は改善が必要だと思われるUXに対するレビューです。どこが悪いUXにさせているのかレビューしましょう。</p>
        <p>ただ、単に何が悪いのかを提示するだけでは、改善方法が不明確です。できればどうすれば良くなるか？に焦点をあててレビューしましょう。</p>
        <h3 class="good_ux">OPINION UX</h3>
        <p>「OPINION UX」は良いか悪いか意見が別れるUXについてのレビューです。</p>
        <p>どこが良いと思うのか悪いと思うのか、どこが評価の別れる点なのか明確にしてレビューをしましょう。</p>
        <p></p>
      </div>

      <div class="mt-5">
        <h2>レビュー依頼機能</h2>
        <p>yyUXではレビューの依頼機能を備えています。</p>
        <p>自サイト・アプリのUXをより良いものにするために、自サイトについてのレビューをyyUXのみんなに聞いてみましょう。</p>
        <p>レビューする際は単にサイトを紹介するだけではなくて</p>
        <ul>
          <li>どのUXで悩んでいるのか</li>
          <li>そのサイト・商品は何を目的としているのか</li>
          <li>UX改善のために何に取り組んだのか</li>
        </ul>
        <p>を明確にすることで、より具体的なレビューを受けることができます。</p>
      </div>

      <div class="mt-5">
        <h2>レビュアーをフォローしよう！</h2>
        <p>yyUXではレビュアーをフォローできます。yyUX内ではスコア機能があります。スコア機能が高ければ高いほどUXに対する関心度が高く、周りの評価も高いという意味になります。</p>
        <p>より優れたレビュアーの意見を見ることで自分自身のUXに対する知見を高めていきましょう！</p>
      </div>

      <div class="mt-5">
        <h2>さあ始めましょう！</h2>
        <div class="row">
          @if(Auth::check())
            <div class="col-4">
              <div class="yy-outline mb-3">
                <div class="bg-primary text-white px-3 py-2">
                  <p class="m-0">
                    投稿する
                  </p>
                </div>
                <div class="px-3 py-2">
                  <small>
                    サービス、プロダクトのUXについてレビュー評価しよう！
                  </small>
                  <a href="{{ url('/review/create') }}" class="mt-2 btn btn-outline-primary d-block">UXレビューする</a>
                </div>
              </div>
            </div>

            <div class="col-4">
              <div class="yy-outline mb-3">
                <div class="bg-primary text-white px-3 py-2">
                  <p class="m-0">
                    依頼する
                  </p>
                </div>
                <div class="px-3 py-2">
                  <small>
                    自分のサービス、プロダクトのレビューを依頼しよう！
                  </small>
                  <a href="{{ url('/request/create') }}" class="mt-2 btn btn-outline-primary d-block">UXレビュー依頼する</a>
                </div>
              </div>
            </div>
          @else
            <div class="col-4">
              <div class="yy-outline mb-3">
                <div class="bg-primary text-white px-3 py-2">
                  <p class="m-0">
                    　登録する
                  </p>
                </div>
                <div class="px-3 py-2">
                  <small>
                    登録してレビューを投稿・依頼してみよう！
                  </small>
                  <a href="{{ url('/register') }}" class="mt-2 btn btn-outline-primary d-block">yyUXに登録する</a>
                </div>
              </div>
            </div>
          @endif
          <div class="col-4">
            <div class="yy-outline mb-3">
              <div class="bg-primary text-white px-3 py-2">
                <p class="m-0">
                  見る
                </p>
              </div>
              <div class="px-3 py-2">
                <small>
                  みんなのレビューをみてみよう！
                </small>
                <a href="{{ url('/') }}" class="mt-2 btn btn-outline-primary d-block">レビュー一覧へ</a>
              </div>
            </div>
          </div>
        </div>
    </div>
  </div>
@endsection

@section('rightSideBar')
@endsection
