<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\User;

class SummaryScore extends Model
{
    protected $table = 'summary_scores';
    public $timestamps = true;

    protected $fillable = [
        'user_id', 'user_name', 'avatar_image_path', 'score'
    ];

    // スコアのトップ10を作成
    public static function summaryScores(){

      DB::table('summary_scores')->delete();

      // score_hisotriesテーブルからトップ10のスコアを集計する
      $topTenScores = DB::table('score_histories')
                      ->groupBy('user_id')
                      ->select(DB::raw('user_id, sum(score) as user_score'))
                      ->orderBy('user_score', 'desc')
                      ->get(10);

      foreach($topTenScores as $score){

        $userId = $score->user_id;
        $user = User::where('id', $userId)->first();
        $userName = $user->name;
        $userAvatar = $user->avatar_image_path;
        $userScore = $score->user_score;

        SummaryScore::create([
                'user_id' => $userId,
                'user_name' => $userName,
                'avatar_image_path' => $userAvatar,
                'score' => $userScore
        ]);

      }
    }

    // すべてのユーザのスコアを更新する
    public static function updateAllUserScore() {
      $users = User::all();
      foreach($users as $user) {
        SummaryScore::updateUserScore($user->id);
      }
    }

    // 特定ユーザのスコアを更新する
    public static function updateUserScore($userId) {
      $user = User::where('id', $userId)->first();

      // score_hisotriesテーブルから特定ユーザのスコアを集計する
      $userScore = DB::table('score_histories')
                      ->where('user_id', $userId)
                      ->sum('score');
      $user->score = $userScore;
      $user->save();
    }
}
