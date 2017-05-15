@if(Auth::user()->id != $review->user_id)

  <p>
    賛成数：{{$review->agreeCount()->count()}}
    反対数：{{$review->disagreeCount()->count()}}
  </p>
  <button id="yy-agree" class="yy-review-evaluation btn btn-primary {{ isset($evaluation) ? ' clicked' : '' }}" type="button" value="{{Config::get('enum.evaluation.AGREE')}}">
    {{ (isset($evaluation) && $evaluation->is_agree == 1) ? '賛成済' : '賛成' }}
  </button>
  <button id="yy-disagree" class="yy-review-evaluation btn btn-warning {{isset($evaluation) ? ' clicked' : ''}}" type="button" value="{{Config::get('enum.evaluation.DISAGREE')}}">
    {{ (isset($evaluation) && $evaluation->is_agree == 0) ? '反対済' : '反対' }}
  </button>

@endif
