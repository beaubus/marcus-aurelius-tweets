<?php

namespace App\Factories;


use Abraham\TwitterOAuth\TwitterOAuth;
use Abraham\TwitterOAuth\TwitterOAuthException;

class TwitterConnectionFactory
{
    public function __construct(private $mysqli)
    {
    }

    /**
     * @return array{user_id: string|null, screen_name: string|null, connection: TwitterOAuth|null }
     * @throws TwitterOAuthException
     */
    public function getConnection(): array
    {
        $connection = [];

        $cached_res = $this->mysqli->query('SELECT * FROM twitter_oauth');
        $cached_row = $cached_res->fetch_assoc();

        // connect only via OAuth
        if (empty($cached_row['screen_name'])) die('not connected to twitter account');

        $access_token = $cached_row['oauth_token'];
        $access_token_secret = $cached_row['oauth_token_secret'];
        $connection['user_id'] = $cached_row['user_id'];
        $connection['screen_name'] = $cached_row['screen_name'];

        // set Twitter api connection
        $connection['connection'] = new TwitterOAuth(
            getenv('API_KEY'),
            getenv('API_KEY_SECRET'),
            $access_token,
            $access_token_secret,
        );
        $connection['connection']->setApiVersion('2');

        return $connection;
    }
}
