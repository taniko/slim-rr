<?php
declare(strict_types=1);

namespace App\Action;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Taniko\Context\Context;
use Taniko\Context\ContextInterface;

abstract class Action
{
    protected LoggerInterface $logger;
    protected ContextInterface $context;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct(ContainerInterface $container)
    {
        $this->logger = $container->get(LoggerInterface::class);
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $this->context = $request->getAttribute(ContextInterface::class) ?? new Context();
        return $this->action($request, $response);
    }

    abstract public function action(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface;
}