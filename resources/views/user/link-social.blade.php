@extends('layouts.user')

@section('content')
  <div class="col mx-3">

    @include('subs.flash-message-success')

    <h4>ソーシャル連携</h4>
    
    <p>
      他サイトとの連携は以下から管理してください。連携すると簡単にログインができるようになります。
    </p>
    <div class="row justify-content-center">
      <div class="col-6 p-2">
        <div class="yy-outline p-3">
          <h5 class="yy-outline-bottom pb-3 mb-3">
            Twitter連携
          </h5>
          <p class="mb-0">
            {{ $socials->contains('twitter') ? 'Twitter連携済み。' : 'まだTwitter連携していません。' }}
          </p>
          <div class="py-3">
            <a class="btn btn-block btn-social btn-twitter {{ $socials->contains('twitter') ? 'disabled' : '' }}" href="/login/twitter">
                <span class="fa fa-twitter"></span> Sign in with Twitter
            </a>
          </div>
          @if($socials->contains('twitter'))
            <div class="py-3 mt-3 yy-outline-top">
              <p>
                Twitter連携を解除するには<br/>以下のボタンをクリックしてください。
              </p>
              <a class="unlink-btn btn btn-outline-success btn-block active text-white" href="/settings/link/twitter">
                連携中
              </a>
            </div>
          @endif
        </div>
      </div>
      <div class="col-6 p-2">
        <div class="yy-outline p-3">
          <h5 class="yy-outline-bottom pb-3 mb-3">
            Facebook連携
          </h5>
          <p class="mb-0">
            {{ $socials->contains('facebook') ? 'Facebook連携済み。' : 'まだFacebook連携していません。' }}
          </p>
          <div class="py-3">
            <a class="btn btn-block btn-social btn-facebook {{ $socials->contains('facebook') ? 'disabled' : '' }}" href="/login/facebook">
              <span class="fa fa-facebook"></span> Sign in with Facebook
            </a>
          </div>
          @if($socials->contains('facebook'))
            <div class="py-3 mt-3 yy-outline-top">
              <p>
                Facebook連携を解除するには<br/>以下のボタンをクリックしてください。
              </p>
              <a class="unlink-btn btn btn-outline-success btn-block active text-white" href="/settings/link/facebook">
                連携中
              </a>
            </div>
          @endif
        </div>
      </div>
      <div class="col-6 p-2">
        <div class="yy-outline p-3">
          <h5 class="yy-outline-bottom pb-3 mb-3">
            Google連携
          </h5>
          <p class="mb-0">
            {{ $socials->contains('google') ? 'Google連携済み。' : 'まだGoogle連携していません。' }}
          </p>
          <div class="py-3">
            <a class="btn btn-block btn-social btn-google {{ $socials->contains('google') ? 'disabled' : '' }}" href="/login/google">
              <span class="fa fa-google"></span> Sign in with Google
            </a>
          </div>
          @if($socials->contains('google'))
            <div class="py-3 mt-3 yy-outline-top">
              <p>
                Google連携を解除するには<br/>以下のボタンをクリックしてください。
              </p>
              <a class="unlink-btn btn btn-outline-success btn-block active text-white">
                連携中
              </a>
            </div>
          @endif
        </div>
      </div>
      <div class="col-6 p-2">
        <div class="yy-outline p-3">
          <h5 class="yy-outline-bottom pb-3 mb-3">
            Github連携
          </h5>
          <p class="mb-0">
            {{ $socials->contains('github') ? 'Github連携済み。' : 'まだGithub連携していません。' }}
          </p>
          <div class="py-3">
            <a class="btn btn-block btn-social btn-github {{ $socials->contains('github') ? 'disabled' : '' }}" href="/login/github">
              <span class="fa fa-github"></span> Sign in with Github
            </a>
          </div>
          @if($socials->contains('github'))
            <div class="py-3 mt-3 yy-outline-top">
              <p>
                Github連携を解除するには<br/>以下のボタンをクリックしてください。
              </p>
              <a class="unlink-btn btn btn-outline-success btn-block active text-white">
                連携中
              </a>
            </div>
          @endif
        </div>
      </div>
  </div>
@endsection

@section('foot')
  @parent
  <script>
    $(function() {
      //
      $('.unlink-btn').mouseenter(function() {$(this).text('解除する').css('background-color','red');})
                      .mouseleave(function() {$(this).text('連携中').css('background-color','');});
    });
  </script>
@endsection
