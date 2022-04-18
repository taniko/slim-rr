<?php
declare(strict_types=1);

namespace App\Middleware;

use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Taniko\Context\Context;
use Taniko\Context\ContextInterface;

class RequestIDMiddleware implements MiddlewareInterface
{
    private const LENGTH = 32;

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     * @throws Exception
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        /** @var Context $context */
        $context = $request->getAttribute(ContextInterface::class) ?? new Context();
        $context = $context->set('request-id', $this->generateID());
        $request = $request->withAttribute(ContextInterface::class, $context);
        return $handler->handle($request);
    }


    /**
     * @throws Exception
     */
    private function generateID(): string
    {
        return substr(bin2hex(random_bytes((int)ceil(self::LENGTH / 2))), 0, self::LENGTH);
    }
}