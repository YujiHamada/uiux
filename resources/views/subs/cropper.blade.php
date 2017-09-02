{{-- 使い方
<div id="crop-avatar">
  ~~~
  <form ~~~>
    ~~~
    <div class="avatar-view" title="Change the avatar">
      <img src="..." alt="Avatar"> ← クロップ先
    </div>
    ~~~
  </form>
  ~~~
  @include('subs.cropper') ← 当ファイル
  ~~~
</div>
上記の形で組み込む --}}


<!-- Cropping modal -->
<div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form class="avatar-form" action="{{ action('HomeController@crop') }}" enctype="multipart/form-data" method="post">
        {{ csrf_field() }}

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          {{-- <h4 class="modal-title" id="avatar-modal-label">Change Avatar</h4> --}}
        </div>

        <div class="modal-body">
          <div class="avatar-body">

            <!-- Upload image and data -->
            <div class="avatar-upload">
              <input type="hidden" class="avatar-src" name="avatar_src">
              <input type="hidden" class="avatar-data" name="avatar_data">
              {{-- <label for="avatarInput">Local upload</label> --}}
              <input type="file" class="avatar-input ml-0" id="avatarInput" name="avatar_file">
            </div>

            <!-- Crop and preview -->
            <div class="row">
              <div class="col-9">
                <div class="avatar-wrapper"></div>
              </div>
              <div class="col-3 d-flex justify-content-end">
                <div class="avatar-preview yy-preview-size mx-0"></div>
                {{-- <div class="avatar-preview preview-lg"></div> --}}
                {{-- <div class="avatar-preview preview-md"></div> --}}
                {{-- <div class="avatar-preview preview-sm"></div> --}}
              </div>
            </div>

            {{-- <div class="row avatar-btns">
              <div class="col-md-9">
                <div class="btn-group">
                  <button type="button" class="btn btn-primary" data-method="rotate" data-option="-90" title="Rotate -90 degrees">Rotate Left</button>
                  <button type="button" class="btn btn-primary" data-method="rotate" data-option="-15">-15deg</button>
                  <button type="button" class="btn btn-primary" data-method="rotate" data-option="-30">-30deg</button>
                  <button type="button" class="btn btn-primary" data-method="rotate" data-option="-45">-45deg</button>
                </div>
                <div class="btn-group">
                  <button type="button" class="btn btn-primary" data-method="rotate" data-option="90" title="Rotate 90 degrees">Rotate Right</button>
                  <button type="button" class="btn btn-primary" data-method="rotate" data-option="15">15deg</button>
                  <button type="button" class="btn btn-primary" data-method="rotate" data-option="30">30deg</button>
                  <button type="button" class="btn btn-primary" data-method="rotate" data-option="45">45deg</button>
                </div>
              </div> --}}
              <div class="my-2">
                <button type="submit" class="btn btn-primary btn-block avatar-save">Done</button>
              </div>
            </div>

          </div>
        </div>

      </form>
    </div>
  </div>
</div><!-- /.modal -->

<!-- Loading state -->
<div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>
