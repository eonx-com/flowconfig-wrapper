<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\FlowConfig\Helpers;

use Doctrine\Common\Annotations\AnnotationReader as BaseAnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use EoneoPay\Externals\Bridge\Laravel\Providers\ContainerServiceProvider;
use Laravel\Lumen\Application;
use LaravelDoctrine\ORM\DoctrineServiceProvider;

/**
 * This class bootstraps an application for use in testing.
 *
 * @coversNothing
 *
 * @internal Only for use with tests within this library.
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects) Ignore coupling as the bootstrapper is used for testing.
 * @SuppressWarnings(PHPMD.StaticAccess) Static access to some classes required for testing
 */
final class ApplicationBootstrapper
{
    /**
     * Creates a new instance of the Application for testing purposes.
     *
     * @return \Laravel\Lumen\Application
     */
    public static function create(): Application
    {
        // Set the base path and include the autoloader
        $basePath = \dirname(__DIR__, 2);
        require_once $basePath . '/vendor/autoload.php';

        // Until Doctrine Annotations v2.0, we need to register an autoloader, which is just 'class_exists'.
        /** @noinspection PhpDeprecationInspection Will be removed with doctrine annotations v2.0 */
        AnnotationRegistry::registerUniqueLoader('class_exists');

        // Ignore @covers and @coversNothing annotations
        BaseAnnotationReader::addGlobalIgnoredName('covers');
        BaseAnnotationReader::addGlobalIgnoredName('coversNothing');

        // Create a new application
        $app = new Application($basePath);

        // Service providers required by the framework
        $app->register(ContainerServiceProvider::class);
        $app->register(DoctrineServiceProvider::class);

        return $app;
    }
}
