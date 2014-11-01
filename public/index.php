<?php

define('APP_ROOT', dirname(__DIR__));

require_once APP_ROOT . '/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use \GDG\Controller\IndexController;
use \GDG\Model\TweetBucket;

$app = new Silex\Application();
$app->get('/', function () use ($app) {
    return $app->redirect('/monitor.html');
});
$app->get('/{tag}/{since}', function ($tag, $since = 0) use ($app) {
    $ic = new IndexController();
    $bucket = new TweetBucket();
    try {
        $ic->loadTag($bucket, $tag, $since, 10);
    } catch (\Exception $e) {
        return new Response('Error accessing twitter API', 504);
    }
    $bucket_size = $bucket->count();
    if (empty($bucket_size))
       return new Response('Not modified', 304);
    $response = new Response();
    $response->setContent(
       $bucket->getJSON()
    );
    $response->headers->set('Content-Type', 'application/json');
    return $response;
})->assert('since', '.*');

$app->run();
