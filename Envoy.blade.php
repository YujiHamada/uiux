@servers(['web' => ['127.0.0.1']])

@story('deployAll')
    git
    migration
    composer
@endstory

@task('git', ['on' => 'web'])
    git pull origin master
@endtask

@task('migration', ['on' => 'web'])
    php artisan migrate
@endtask

@task('composer', ['on' => 'web'])
    composer update
@endtask