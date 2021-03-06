<?php

declare(strict_types=1);

namespace App;

use App\Middleware\TemplateDefaultsMiddleware;
use Laminas\Mail\Transport\TransportInterface;
use Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;
use App\EmailTransportFactory;
use App\Service\Email\UserNotificationService;
use App\Service\Email\UserNotificationServiceFactory;
use App\Middleware\UrlBuilderMiddleware;
use App\Middleware\UrlBuilderMiddlewareFactory;

/**
 * The configuration provider for the App module
 *
 * @see https://docs.laminas.dev/laminas-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies(): array
    {
        return [
            'invokables' => [
                Handler\PingHandler::class => Handler\PingHandler::class,
            ],
            'factories'  => [
                Handler\HomePageHandler::class => Handler\HomePageHandlerFactory::class,
                TemplateDefaultsMiddleware::class => ReflectionBasedAbstractFactory::class,
                TransportInterface::class => EmailTransportFactory::class,
            ],
        ];
    }

    /**
     * Returns the templates configuration
     */
    public function getTemplates(): array
    {
        return [
            'paths' => [
                'app'    => [__DIR__ . '/../templates/app'],
                'error'  => [__DIR__ . '/../templates/error'],
                'layout' => [__DIR__ . '/../templates/layout'],
            ],
        ];
    }
}
