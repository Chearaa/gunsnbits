<?php
require_once 'recipe/common.php';
require 'vendor/deployphp/recipes/recipes/rsync.php';

$deployPath = [
    'dedi2992_adventskalender.news' => '/usr/www/users/advent/gewinnspiele_production',
    'dedi2992_weiss-intermedia.de' => '/usr/www/users/jyccyq/gewinnspiele_demo'
];

set('rsync', [
    'exclude' => [
        '.idea',
        '.git',
        'deploy.php',
        'deployer.phar',
        '.env',
        '.env.example',
        '_ide_helper.php',
        '.phpstorm.meta.php',
        'database.mwb',
        'database.mwb.bak',
        'storage/app/*',
        'storage/framework/cache/*',
        'storage/framework/sessions/*',
        'storage/framework/views/*',
        'storage/logs/*',

        // this folder is a symlink in production mode
        'public/uploads'
    ],
    'exclude-file' => false,
    'include'      => [],
    'include-file' => false,
    'filter'       => [],
    'filter-file'  => false,
    'filter-perdir'=> false,
    'flags'        => 'avrzcE', // Recursive, with compress
    'options'      => ['delete'],
    'timeout'      => 3600,
]);

env('rsync_src', __DIR__);
env('rsync_dest', '{{release_path}}');


// Laravel shared dirs
set('shared_dirs', ['storage']);
// Laravel 5 shared file
set('shared_files', ['.env']);
// Laravel writable dirs
set('writable_dirs', ['bootstrap/cache', 'storage']);

server('dedi2992_adventskalender.news', 'dedi2992.your-server.de', 222)
    ->user('advent')
    ->forwardAgent()
    ->env('deploy_path', $deployPath['dedi2992_adventskalender.news'])
    ->env('environment_file', '.env.production');

server('dedi2992_weiss-intermedia.de', 'dedi2992.your-server.de', 222)
    ->user('jyccyq')
    ->forwardAgent()
    ->env('deploy_path', $deployPath['dedi2992_weiss-intermedia.de'])
    ->env('environment_file', '.env.demo');



// --------------------------------------------------



//
// Overwrite default deploy:symlink task
// --------------------------------------------------
/*
task('deploy:symlink', function() {
    run("cd ~/{{deploy_path}} && ln -sfn ~/{{release_path}} current"); // Atomic override symlink.
    run("cd ~/{{deploy_path}} && rm release"); // Remove release link.
})->desc('Creating symlink to release');
*/

/**
 * Task deploy:public_disk support the public disk.
 * To run this task automatically, please add below line to your deploy.php file
 * <code>after('deploy:symlink', 'deploy:public_disk');</code>
 * @see https://laravel.com/docs/5.2/filesystem#configuration
 */
task('deploy:public_disk', function() {
    // Remove from source.
    run('if [ -d $(echo {{release_path}}/public/uploads) ]; then rm -rf {{release_path}}/public/uploads; fi');

    // Create shared dir if it does not exist.
    run('mkdir -p {{deploy_path}}/shared/public/uploads');

    // Symlink shared dir to release dir
    run('ln -nfs {{deploy_path}}/shared/public/uploads {{release_path}}/public/uploads');
})->desc('Make symlink for public disk');


//
// Setup the laravel app
// --------------------------------------------------
task('laravel:production', function() {
    run('mv {{release_path}}/' . env('environment_file') . ' {{release_path}}/.env');
    writeln('Laravel environment file "' . env('environment_file') . '" moved to .env!');
    // delete other environment files
    run('rm {{release_path}}/.env.*');

    run('php {{release_path}}/artisan down');
    writeln('Laravel app is now down!');

    //run('php {{release_path}}/artisan key:generate');
    //writeln('Laravel key:generate done!');

    run('php {{release_path}}/artisan clear-compiled');
    writeln('Laravel clear-compiled done!');

    run('php {{release_path}}/artisan cache:clear');
    writeln('Laravel cache:clear done!');

    run('php {{release_path}}/artisan config:clear');
    writeln('Laravel config:clear done!');

    run('php {{release_path}}/artisan route:clear');
    writeln('Laravel route:clear done!');

    run('php {{release_path}}/artisan view:clear');
    writeln('Laravel view:clear done!');

    run('php {{release_path}}/artisan migrate --force');
    writeln('Laravel migrate --force done!');

    run('php {{release_path}}/artisan config:cache');
    writeln('Laravel config:cache done!');

    //run('php {{release_path}}/artisan route:cache');
    //writeln('Laravel route:cache done!');

    run('php {{release_path}}/artisan optimize');
    writeln('Laravel optimize done!');

    run('php {{release_path}}/artisan up');
    writeln('Laravel app is now up!');

    writeln('---');
    writeln('Laravel is now in production-mode!');
});


// --------------------------------------------------



//
// The deploy task group
// --------------------------------------------------
task('deploy', [
    'deploy:prepare',
    'deploy:release',
    'rsync:warmup',
    'rsync',
    'laravel:production',
    'deploy:public_disk',
    'deploy:symlink',
    'cleanup'
]);
after('deploy', 'success');