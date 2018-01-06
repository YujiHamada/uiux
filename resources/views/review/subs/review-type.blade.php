<div class="">
    @if(Config::get('enum.type.GOOD_UX') == $review->type)
      <span class="badge badge-success text-white p-1">GOOD UX!!</span>
    @elseif(Config::get('enum.type.KAIZEN_UX') == $review->type)
      <span class="badge badge-danger text-white p-1">KAIZEN UX</span>
    @elseif(Config::get('enum.type.OPINION') == $review->type)
      {{-- <p><span class="badge badge-secondary text-white p-1">OPINION</span></p> --}}
    @elseif(!empty($review->is_request))
      <span class="badge badge-danger text-white p-1">レビュー依頼</span>
    @endif
</div>
