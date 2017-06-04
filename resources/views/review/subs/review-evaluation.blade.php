@if(Auth::user()->id != $review->user_id)

  <button id="yy-agree" class="yy-review-evaluation btn btn-primary {{ isset($evaluation) ? ' clicked' : '' }}" type="button" value="{{Config::get('enum.evaluation.AGREE')}}">
    {{ (isset($evaluation) && $evaluation->is_agree == 1) ? '賛成済' : 'レビューに賛成' }}
  </button>
  <button id="yy-disagree" class="yy-review-evaluation btn btn-danger {{isset($evaluation) ? ' clicked' : ''}}" type="button" value="{{Config::get('enum.evaluation.DISAGREE')}}">
    {{ (isset($evaluation) && $evaluation->is_agree == 0) ? '反対済' : 'レビューに反対' }}
  </button>

@endif
