<?php
namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'bimbel');

// Project repository
set('repository', 'git@gitlab.com:tarikhagustia/bimble.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', false);

// Shared files/dirs between deploys
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server
add('writable_dirs', []);


// Hosts

host('103.55.36.25')
    ->user('deployer')
    ->set('deploy_path', '/var/www/html/{{application}}');

// Tasks

task('build', function () {
    run('cd {{release_path}} && build');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

// before('deploy:symlink', 'artisan:migrate');

