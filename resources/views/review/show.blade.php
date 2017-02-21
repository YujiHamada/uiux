@extends('layouts.app')

@section('head')
  @parent
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
      img {
        width: auto;
        height: auto;
        max-width: 120px;
        max-height: 150px;
      }
      .clicked{
        /*bootstrapのdisabledとほぼ同じだけどカーソルにnot-allowedをつけたくないのでここに書きました*/
        filter: alpha(opacity=65);
        -webkit-box-shadow: none;
        box-shadow: none;
        opacity: .65;
      }
  </style>
@endsection

@section('content')
  <img src="/{{Config::get('const.IMAGE_FILE_DIRECTORY')}}{{$review->image_name }}" alt="">
  <h4>タイトル：{{ $review->title }}</h4>
  <p>詳細：{{ $review->description }}</p>
  @if(Auth::user()->id != $review->user_id)
    <p>
    賛成数：{{$review->agreeCount()->count()}}
    反対数：{{$review->disagreeCount()->count()}}
    </p>
    <p>↓このレビューに↓</p>
    <button id="agree" class="agree btn btn-primary {{ isset($agree) ? ' clicked' : '' }}" type="button" value="{{Config::get('enum.agree.AGREE')}}">
      {{ (isset($agree) && $agree->is_agree == 1) ? '賛成済' : '賛成' }}
    </button>
    <button id="disagree" class="agree btn btn-warning {{isset($agree) ? ' clicked' : ''}}" type="button" value="{{Config::get('enum.agree.DISAGREE')}}">
      {{ (isset($agree) && $agree->is_agree == 0) ? '反対済' : '反対' }}
    </button>
  @endif
@endsection

@section('foot')
  @parent
  <script>
  $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
  });

  $('.agree').on('click',function(){
    var userID = {{Auth::user()->id}};
    var reviewID = {{$review->id}};
    var agree = $(this).val();
    $.ajax({
      url: "/review/agree",
      type:'POST',
      dataType: 'json',
      data : {
        user_id : userID,
        review_id : reviewID,
        agree : agree
        },
      success: function(data) {
        $('.agree').toggleClass('clicked');
        if(data.isDeleted){
          $('#agree').text('賛成');
          $('#disagree').text('反対');
        }else if(data.isAgree == {{Config::get('enum.agree.AGREE')}}){
          $('#agree').text('賛成済');
        }else if(data.isAgree == {{Config::get('enum.agree.DISAGREE')}}){
          $('#disagree').text('反対済');
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown){
        alert('賛成・反対の送信に失敗しました');
      }
    });
  });
  </script>
@endsection
