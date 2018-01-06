@servers(['web' => ['127.0.0.1']])

@story('deploy')
    git
    migration
    gulp
@endstory

@story('deployAll')
    git
    migration
    gulp
    composer
@endstory

@task('git', ['on' => 'web'])
	git checkout .
    git pull origin master
    composer dump-autoload
@endtask

@task('migration', ['on' => 'web'])
    php artisan migrate
@endtask

@task('composer', ['on' => 'web'])
    composer update
@endtask

@task('gulp', ['on' => 'web'])
    gulp
@endtask