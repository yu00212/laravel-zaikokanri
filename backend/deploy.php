<?php

namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'zaikokanri');

// Project repository
set('repository', 'https://github.com/yu00212/laravel-zaikokanri.git');

// Shared files/dirs between deploys
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server
add('writable_dirs', []);

set('branch', 'main');

// Hosts
host('172.31.33.88')
    ->stage('main')
    ->user('ec2-user')
    ->port(22)
    ->identityFile('~/.ssh/sample-key.pem')
    ->set('deploy_path', '/var/www/laravel-zaikokanri/backend');

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'artisan:migrate');

// Tasks

task('deploy', function () {
    // 本番への反映は確認を挟む
    if (input()->hasArgument('stage') && (input()->getArgument('stage') === 'production')) {
        if (!askConfirmation('productionに反映して問題ありませんか？', true)) {
            writeln('deploy was stopped');
            return;
        }
    }
    invoke('deploy:laravel');
});

desc('shared/.envを.env.{stage}で上書き');
task('overwrite-env', function () {
    $stage = get('stage');
    $src = ".env.${stage}";
    $deployPath = get('deploy_path');
    $sharedPath = "${deployPath}/shared";
    run("cp -f {{release_path}}/${src} ${sharedPath}/.env");
});

/**
 * Main task
 */
desc('Deploy your project');
task('deploy:laravel', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:vendors',
    'deploy:writable',
    'artisan:storage:link',
    'artisan:view:clear',
    'artisan:cache:clear',
    'artisan:config:cache',
    'artisan:optimize',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
]);
