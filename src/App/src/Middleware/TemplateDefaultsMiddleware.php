<?php

declare(strict_types=1);

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Mezzio\Router\RouteResult;
use Mezzio\Flash\FlashMessagesInterface;
use Mezzio\Flash\FlashMessageMiddleware;
use Mezzio\Template\TemplateRendererInterface;

class TemplateDefaultsMiddleware implements MiddlewareInterface
{
    private TemplateRendererInterface $templateRenderer;

    public function __construct(TemplateRendererInterface $templateRenderer)
    {
        $this->templateRenderer = $templateRenderer;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        $routeResult = $request->getAttribute(RouteResult::class);
        $this->templateRenderer->addDefaultParam(
            TemplateRendererInterface::TEMPLATE_ALL,
            'matchedRouteName',
            $routeResult ? $routeResult->getMatchedRouteName() : null
        );

        // Inject all flash messages
        /** @var FlashMessagesInterface $flashMessages */
        $flashMessages = $request->getAttribute(FlashMessageMiddleware::FLASH_ATTRIBUTE);
        $this->templateRenderer->addDefaultParam(
            TemplateRendererInterface::TEMPLATE_ALL,
            'notifications',
            $flashMessages ? $flashMessages->getFlashes() : []
        );

        return $handler->handle($request);
    }
}