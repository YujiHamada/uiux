<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Review;
use App\ReviewEvaluations;
use App\ReviewTag;
use App\Tag;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactInformation;
use App\Libs\CropAvatar;
use Illuminate\Support\Facades\Input;





class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query;

        if(isset($request->feed) && $request->feed == 'request') {
            $query = Review::where('is_request', true)->orderBy('created_at', 'desc');
        }elseif(isset($request->feed) && $request->feed != 'ALL'){
            $query = Review::where('type', $request->feed)->orderBy('created_at', 'desc');
        }else{
            $query = Review::latest('created_at');
        }

        //検索条件にタグを加える
        $tagId = $request->input('tagId');

        $selectedTag;

        if(!empty($tagId)){
            $selectedTag = Tag::select('name')->where('id', $tagId)->first();
            $query = $this->setTags($query, $tagId);
        }

        //検索条件に検索ワードを加える
        $searchWords = $request->input('searchWords');
        $reviews = $this->setSearchWords($query, $searchWords)->paginate(\Config::get('const.NUMBER_OF_REVIEWS_PER_PAGE'));

        $reviews->setPath('?searchWords=' . $searchWords . '&tagId='. $tagId);

        return view('home.index', compact('reviews', 'searchWords', 'tagId', 'selectedTag'));

    }

    private function setSearchWords($query, $searchWords) {
        if(!empty($searchWords)){
            //全角スペースを半角スペースに変換し半角スペースでpreg_split
            $searchWordsArray =preg_split('/[\s]+/',mb_convert_kana($searchWords, 's'));

            $query = $query->Where(function ($q) use(&$searchWordsArray, &$tagQuery) {
                $tagQuery = ReviewTag::select('review_tags.review_id')->join('tags', 'review_tags.tag_id', 'tags.id');
                foreach($searchWordsArray as $searchWord){
                    $q->orwhere('title', 'like', '%' . $searchWord . '%')->orWhere('description', 'like', '%' . $searchWord . '%');
                    $tagQuery = $tagQuery->where('tags.name', 'like', '%' . $searchWord . '%');
                }
                $q->orWhereIn('id', $tagQuery->get());
            });

        }

        return $query;
    }

    private function setTags($query, $tagId) {
        if(!empty($tagId)){
            $reviewIds = ReviewTag::select('review_tags.review_id')->join('tags', 'review_tags.tag_id', 'tags.id')->where('tags.id', $tagId)->get();
            $query = $query->Where(function ($q) use(&$reviewIds){
                $q->orWhereIn('id', $reviewIds);
            });
        }
        return $query;
    }

    public function tagSearch($tagId) {
        $ids = ReviewTag::select('review_tags.review_id')->join('tags', 'review_tags.tag_id', 'tags.id')->where('tags.id', $tagId)->get();

        $reviews = Review::whereIn('id',$ids)->paginate(\Config::get('const.NUMBER_OF_REVIEWS_PER_PAGE'));

        return view('home.index', compact('reviews', 'tagId'));
    }

    // このサイトについてのページを表示
    public function showAbout() {
        return view('home.about');
    }

    // お問い合わせのページを表示
    public function showContact() {
        return view('home.contact');
    }

    //利用規約ページの表示
    public function showLegal(){
        return view('home.legal');
    }

    //プライバシーポリシーの表示
    public function showPrivacy(){
        return view('home.privacy');
    }

    // お問い合わせのページを表示 & お問い合わせ内容のメール送信
    public function sendContact(\App\Http\Requests\ContactRequest $request) {
      $name = $request->name;
      $email = $request->email;
      $url = $request->url;
      $contact = $request->contact;

      // お問い合わせ内容を開発者メールに送信する。
      Mail::to("info.yyux@gmail.com")->send(new ContactInformation($name, $email, $url, $contact));

      return redirect('/')->with('flash_message', '問い合わせを受け付けました。');
    }



      public function crop(Request $request) {
        $crop = new CropAvatar(
          Input::has('avatar_src') ? $request->input('avatar_src') : null,
          Input::has('avatar_data') ? $request->input('avatar_data') : null,
          Input::hasFile('avatar_file') ? $_FILES['avatar_file'] : null
        );

        $response = array(
          'state'  => 200,
          'message' => $crop->getMsg(),
          'result' => $crop->getResult(), // ドメイン付きファイルパス
          'avatarImagePath' => $crop->getAvatarImagePath() // ドメイン無しファイルパス
        );

        return response()->json($response);
      }

}
