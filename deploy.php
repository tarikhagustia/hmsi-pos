<?php
namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'hmsi_pos');

// Project repository
set('repository', 'git@github.com:tarikhagustia/hmsi-pos.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

// Shared files/dirs between deploys
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server
add('writable_dirs', []);


// Hosts

host('103.119.66.139')
    ->port(69)
    ->user('administrator')
    ->set('deploy_path', '/var/www/html/{{application}}');

// Tasks

task('build', function () {
    run('cd {{release_path}} && build');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

// before('deploy:symlink', 'artisan:migrate');
