#!/usr/bin/env php
<?php
chdir(dirname(__FILE__));

$autoload = (int)$argv[1];
$returnStatus = null;

if (!$autoload) {
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    WP_Filesystem();
    global $wp_filesystem;
    $composer = wp_json_file_decode('composer.json',array('associative' => true));
    unset($composer['autoload']);
    unset($composer['require-dev']['squizlabs/php_codesniffer']);
    $wp_filesystem->put_contents('composer.json', wp_json_encode($composer), FS_CHMOD_FILE);
}

passthru('composer install', $returnStatus);
if ($returnStatus !== 0) {
    exit(1);
}

if ($autoload) {
    // Only run CS on 1 of the 2 environments
    passthru(
        './vendor/bin/phpcs --standard=PSR2 -n lib tests *.php',
        $returnStatus
    );
    if ($returnStatus !== 0) {
        exit(1);
    }
}

$config = $autoload ? 'phpunit.xml' : 'phpunit.no_autoload.xml';
passthru("./vendor/bin/phpunit -c $config", $returnStatus);
if ($returnStatus !== 0) {
    exit(1);
}

