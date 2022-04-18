<?php
declare(strict_types=1);

namespace App\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Taniko\Context\ContextInterface;

class Ping extends Action
{
    public function action(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $context = $this->context;
        $data = [ContextInterface::class => $context];
        $this->logger->info('call ping', $data);
        $response->getBody()->write('pong');
        return $response;
    }
}