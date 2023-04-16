<?php


namespace App\Services;


class TweetService
{
    private $connection;

    public function __construct($mysqli)
    {
        // get twitter connection
        $connector = new \App\Factories\TwitterConnectionFactory($mysqli);
        $connection_data = $connector->getConnection();
        $this->connection = $connection_data['connection'];
    }

    public function tweet($tweet_text)
    {
        $response = $this->connection->post("tweets", [
            "text" => $tweet_text
        ], true);

        echo $response?->data?->text;
    }
}