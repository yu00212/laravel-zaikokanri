<?php

namespace Deployer;

require 'recipe/laravel.php';

// プロジェクト名
set('application', 'laravel-zaikokanri');

// [Optional] gitcloneにttyを割り当てる。デフォルト値はfalse。
set('git_tty', false);

// デプロイ間の共有ファイル/ディレクトリ
add('shared_files', []);
add('shared_dirs', []);

// Webサーバーによる書き込み可能なディレクトリ
add('writable_dirs', []);
set('allow_anonymous_stats', false);

inventory('servers.yml');

// タスク
task('build', function () {
    ('cd {{release_path}} && build');
});

// [Optional] デプロイが失敗した場合、自動的にロックが解除される。
after('deploy:failed', 'deploy:unlock');

// シンボリックリンクの新しいリリースの前にデータベースを移行する。
before('deploy:symlink', 'artisan:migrate');

after('deploy:update_code', 'set_release_path');
task('set_release_path', function () {
    $newReleasePath = get('release_path') . '/backend';
    set('release_path', $newReleasePath);
});

before('deploy:info', 'deregister-targets');
task('deregister-targets', function () {
    runLocally('aws elbv2 deregister-targets --target-group-arn {{target_group_arn}} --targets Id={{instance_id}}');
});

after('deploy:unlock', 'register-targets');
task('register-targets', function () {
    runLocally('aws elbv2 register-targets --target-group-arn {{target_group_arn}} --targets Id={{instance_id}},Port=80 ');
});
