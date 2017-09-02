<script>
    $(function(){
        //画像ファイルプレビュー表示のイベント追加 fileを選択時に発火するイベントを登録
        $('form').on('change', 'input[type="file"]', function(e) {
            let file = e.target.files[0]
            let reader = new FileReader()
            let $preview = $(".preview");
            let t = this;

            // 画像ファイル以外の場合は何もしない
            if(file.type.indexOf("image") < 0){
                return false;
            }

            // ファイル読み込みが完了した際のイベント登録
            reader.onload = (function(file) {
                return function(e) {
                    // .prevewの領域の中にロードした画像を表示するimageタグを追加
                    $preview.append('<div class="col-3 p-0"><span class="yy-review-img d-block" style="background-image:' + e.target.result + ')"></span></div>')
                };
            })(file);

            // // ファイル読み込みが完了した際のイベント登録
            // reader.onload = (function(file) {
            //     return function(e) {
            //         //既存のプレビューを削除
            //         $preview.empty();
            //         // .prevewの領域の中にロードした画像を表示するimageタグを追加
            //         $preview.append($('<img>').attr({
            //                 src: e.target.result,
            //                 width: "150px",
            //                 class: "preview",
            //                 title: file.name
            //         }));
            //     };
            // })(file);
            reader.readAsDataURL(file);
        });
    });
</script>
