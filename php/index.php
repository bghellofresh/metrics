<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Prometheus\RenderTextFormat;
use Prometheus\Storage\Redis;

require_once __DIR__ . '/vendor/autoload.php';
$config = require_once __DIR__ . '/config.php';

$app = new \Slim\App(['settings' => $config]);

$app->get('/metrics', function (Request $request, Response $response, array $args) {
    sleep(1);
    Redis::setDefaultOptions($this->settings['redis']);

    $registry = \Prometheus\CollectorRegistry::getDefault();

    $counter = $registry->getOrRegisterCounter('test', 'some_counter', 'it increases', ['type']);
    $counter->incBy(3, ['blue']);
    
    $gauge = $registry->getOrRegisterGauge('test', 'some_gauge', 'it sets', ['type']);
    $gauge->set(2.5, ['blue']);
    
    $histogram = $registry->getOrRegisterHistogram('test', 'some_histogram', 'it observes', ['type'], [0.1, 1, 2, 3.5, 4, 5, 6, 7, 8, 9]);
    $histogram->observe(3.5, ['blue']);
    
    $renderer = new RenderTextFormat();
    $result = $renderer->render($registry->getMetricFamilySamples());

    $response->getBody()->write($result);

    return $response;
});

$app->run();
