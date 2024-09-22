<?php

namespace Tempest\Scaffold;

use Tempest\Core\Discovery;
use Tempest\Container\Container;
use Tempest\Reflection\ClassReflector;

final readonly class TemplateDiscovery implements Discovery
{
    public function __construct(
        private readonly TemplateConfig $templateConfig,
    )
    {}

    public function discover(ClassReflector $class): void
    {
        foreach ($class->getPublicMethods() as $method) {
            $templateAttribute = $method->getAttribute(Template::class);

            if (! $templateAttribute) {
                continue;
            }

            $this->templateConfig->addTemplate( $method, $templateAttribute);
        }
    }

    public function hasCache(): bool
    {
        return false;
    }

    public function storeCache(): void
    {}

    public function restoreCache(Container $container): void
    {}

    public function destroyCache(): void
    {}
}
