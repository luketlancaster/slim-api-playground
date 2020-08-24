<?php

declare(strict_types=1);

namespace PinterestApi\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use GuzzleHttp\Psr7\Response as GuzzleResponse;

class SetJsonResponse
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $response = $handler->handle($request);
        $existingContent = json_decode((string) $response->getBody());
        $newContent = ['data' => $existingContent];

        $newResponse = new GuzzleResponse();
        $newResponse->getBody()->write(json_encode($newContent));
        return $newResponse;
    }
}
