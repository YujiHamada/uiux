<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Refresh extends Command
{
  // php artisan yyux:refresh      : dbのみrefresh
  // php artisan yyux:refresh --all: すべてrefresh
  protected $signature = 'yyux:refresh {--all}';
  protected $description = 'composer dump-autoload, gulp, migrate, seed';

  public function handle() {

    // オプションで--allが指定されているか否かを取得
    $isAll = $this->option('all');

    // --allが指定されていれば、オートロードとgulpを実行
    if($isAll) {
      // 「composer dump-autoload」を実行
      var_dump(system('composer dump-autoload'));

      // 「gulp」を実行
      var_dump(system('gulp'));
    }
    
    // 「php artisan migrate:refresh --seed」を実行
    $this->call('migrate:refresh', ['--seed' => true,]);
  }
}
