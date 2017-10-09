@if(Auth::user()->id != $review->user_id)

  <button id="yy-agree" class="yy-review-evaluation btn btn-primary {{ isset($review->myEvaluation) ? ' yy-clicked' : '' }}" type="button" value="{{Config::get('enum.evaluation.AGREE')}}">
    {{ (isset($review->myEvaluation) && $review->myEvaluation->is_agree == 1) ? 'レビューに賛成済' : 'レビューに賛成' }}
  </button>
  <button id="yy-disagree" class="yy-review-evaluation btn btn-danger {{isset($review->myEvaluation) ? ' yy-clicked' : ''}}" type="button" value="{{Config::get('enum.evaluation.DISAGREE')}}">
    {{ (isset($review->myEvaluation) && $review->myEvaluation->is_agree == 0) ? 'レビューに反対済' : 'レビューに反対' }}
  </button>

@endif
