<?php

session_start();

/** @var $mysqli */
/** @var $dotenv */

use Abraham\TwitterOAuth\TwitterOAuth;

include 'bootstrap.php';

$action = $_GET['action'] ?? null;

if ($action === 'getsignedinusername') { // Get OAuth screen_name
    $screen_name = '';
    $cached_res = $mysqli->query('SELECT * FROM twitter_oauth');
    $cached_row = $cached_res->fetch_assoc();
    if (isset($cached_row['screen_name'])) $screen_name = $cached_row['screen_name'];

    die(json_encode(compact('screen_name')));
}

if ($action === 'authorize') { // Twitter OAuth fallback url
    $cached_res = $mysqli->query('SELECT * FROM twitter_oauth');
    $cached_row = $cached_res->fetch_assoc();

    $mysqli->query('TRUNCATE TABLE twitter_oauth');

    if ($cached_row['oauth_token'] !== $_GET['oauth_token']) {
        die(json_encode(['authorized' => false, 'message' => 'Wrong token, try again']));
    }

    $connection = new TwitterOAuth(
        getenv('API_KEY'),
        getenv('API_KEY_SECRET'),
        $cached_row['oauth_token'],
        $cached_row['oauth_token_secret']
    );

    $access_token = $connection->oauth("oauth/access_token", ["oauth_verifier" => $_GET['oauth_verifier']]);
    if (!count($access_token)) die(json_encode(['authorized' => false, 'Can not get token, try again']));

    $prepared = $mysqli->prepare("
        INSERT INTO twitter_oauth (oauth_token, oauth_token_secret, user_id, screen_name) 
        VALUES (?,?,?,?)
    ");
    $prepared->bind_param(
        'ssss',
        $access_token['oauth_token'],
        $access_token['oauth_token_secret'],
        $access_token['user_id'],
        $access_token['screen_name'],
    );
    $prepared->execute();

    die(json_encode(['authorized' => true]));
}

if ($action === 'gettwitterauthlink') {
    // truncate all users tables for the new login
    $mysqli->multi_query(<<<sql
        TRUNCATE TABLE twitter_oauth;
    sql);
    while($mysqli->next_result()) {} // flush result to make $mysqli->query() work

    $connection = new TwitterOAuth(
        getenv('API_KEY'),
        getenv('API_KEY_SECRET'),
        getenv('ACCESS_TOKEN'),
        getenv('ACCESS_TOKEN_SECRET')
    );

    $request_token = $connection->oauth('oauth/request_token', [
        'oauth_callback' => getenv('OAUTH_CALLBACK')
    ]);

    $prepared = $mysqli->prepare("INSERT INTO twitter_oauth (oauth_token, oauth_token_secret) VALUES (?,?)");
    $prepared->bind_param('ss', $request_token['oauth_token'], $request_token['oauth_token_secret']);
    $prepared->execute();

    $url = $connection->url('oauth/authenticate', [
        'oauth_token' => $request_token['oauth_token'],
        'force_login' => true,
    ]);

    die(json_encode(['url' => $url]));
}