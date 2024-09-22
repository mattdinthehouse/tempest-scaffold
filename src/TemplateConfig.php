<?php

namespace Tempest\Scaffold;

use Tempest\Container\Singleton;
use Tempest\Reflection\MethodReflector;

#[Singleton]
final class TemplateConfig
{
    public function __construct(
        /** @var array<string, \Tempest\Scaffold\Template> */
        private array $templates = [],
    ) {}

    public function addTemplate(MethodReflector $handler, Template $template): self
    {
		$template->setHandler($handler);

        $this->templates[$template->name] = $template;

        return $this;
    }

    public function getTemplate(string $name): Template
    {
        if (! array_key_exists($name, $this->templates)) {
            throw new \OutOfBoundsException("Template {$name} not found");
        }

        return $this->templates[$name];
    }
}
