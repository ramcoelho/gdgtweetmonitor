<?php

namespace GDG\Controller;

use \Buzz\Browser;
use \Buzz\Client\Curl;
use \Twitter\OAuth2\Consumer;
use \Twitter\TwitterSearchConverter;
use \GDG\Model\TweetBucket; 
use \GDG\Model\BucketInterface;

class IndexController
{
    public function loadTag(BucketInterface $bucket, $tag, $since_id = 0, $count = 10)
    {
        if (file_exists(APP_ROOT . '/secret_key.php.dist'))
           include APP_ROOT . '/secret_key.php.dist';

        $client = new Browser(new Curl());
        $consumer = new Consumer(
            $client,
            CONSUMER_KEY,
            CONSUMER_SECRET
        );

        $consumer->setConverter(
            '/1.1/search/tweets.json',
            new TwitterSearchConverter()
        );

        $api_calls = 0;

        $query = $consumer->prepare(
            '/1.1/search/tweets.json',
            'GET',
            array(
                'q' => $tag,
                'since_id' => $since_id,
                'count' => $count,
                'include_entities' => 0
            )
        );
        $result = $consumer->execute($query);
        $bucket->fill($result);
    }
}
