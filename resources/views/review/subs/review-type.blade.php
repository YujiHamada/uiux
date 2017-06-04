@if(Config::get('enum.type.GOOD_UX') == $review->type)
  <span class="badge badge-success align-middle">GOOD UX!!</span>
@elseif(Config::get('enum.type.KAIZEN_UX') == $review->type)
  <span class="badge badge-danger align-middle">KAIZEN UX</span>
@elseif(Config::get('enum.type.OPINION') == $review->type)
  {{-- <p><span class="badge badge-default">OPINION</span></p> --}}
@elseif(!empty($review->is_request))
  <span class="badge badge-danger">レビュー依頼</span>
@endif
