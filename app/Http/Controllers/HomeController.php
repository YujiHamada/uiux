<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Review;
use App\ReviewEvaluations;
use App\ReviewTag;
use App\Tag;
use App\User;
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
        $title = 'yyUXについて' . \Config::get('const.SITE_TITLE_TEMPLATE');
        return view('home.about', compact('title'));
    }

    // お問い合わせのページを表示
    public function showContact() {
        $title = 'お問い合わせ' . \Config::get('const.SITE_TITLE_TEMPLATE');
        return view('home.contact', compact('title'));
    }

    // 利用規約ページの表示
    public function showLegal() {
        $title = '利用規約' . \Config::get('const.SITE_TITLE_TEMPLATE');
        return view('home.legal', compact('title'));
    }

    // プライバシーポリシーの表示
    public function showPrivacy() {
        $title = 'プライバシーポリシー' . \Config::get('const.SITE_TITLE_TEMPLATE');
        return view('home.privacy', compact('title'));
    }

    // ランキングの表示
    public function showRanking() {
        $lastMonthScores = DB::table('score_histories')
                        ->whereMonth('score_histories.created_at', '=', (date('n') - 1))
                        ->join('users', function ($join) {
                            $join->on('score_histories.user_id', '=', 'users.id')
                                ->where('users.is_deleted', 0);
                            })
                        ->groupBy('score_histories.user_id', 'users.name', 'users.avatar_image_path')
                        ->select(DB::raw('score_histories.user_id, users.name, users.avatar_image_path, sum(score_histories.score) as user_score'))
                        ->orderBy('user_score', 'desc')
                        ->get(10);

        // dd($lastMonthScores);
        $title = 'yyUX | スコアランキング';

        return view('home.ranking', compact('lastMonthScores', 'title'));
    }

    // お問い合わせのページを表示 & お問い合わせ内容のメール送信
    public function sendContact(\App\Http\Requests\ContactRequest $request) {
      $name = $request->name;
      $email = $request->email;
      $url = $request->url;
      $contact = $request->contact;

      // お問い合わせ内容を開発者メールに送信する。
      Mail::to(\Config::get('const.ADMIN_MAIL'))->send(new ContactInformation($name, $email, $url, $contact));

      return redirect('/')->with('flash_message', '問い合わせを受け付けました。');
    }


    // 通知の既読処理
    public function notificationReadAt(Request $request) {
        $userId = $request->input('userId');
        $user = User::find($userId);

        $user->unreadNotifications->markAsRead();

        // jQueryのajaxはJSON形式の文字列を返却しないとerror扱いになるので特に意味のないJSON文字列を返している
        return '{"status":"success"}';
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
