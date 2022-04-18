<?php
declare(strict_types=1);

use Spiral\RoadRunner;

require sprintf("%s/vendor/autoload.php", __DIR__);

$app = require_once sprintf("%s/app/app.php", __DIR__);

$worker = RoadRunner\Worker::create();
$psrFactory = new Nyholm\Psr7\Factory\Psr17Factory();
$worker = new RoadRunner\Http\PSR7Worker($worker, $psrFactory, $psrFactory, $psrFactory);
try {
    while ($req = $worker->waitRequest()) {
        try {
            $res = $app->handle($req);
            $worker->respond($res);
        } catch (Throwable $e) {
            $worker->getWorker()->error($e->getMessage());
        }
    }
} catch (JsonException|Throwable $e) {
    echo $e->getMessage();
}