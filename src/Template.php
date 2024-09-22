<?php

namespace Tempest\Scaffold;

use Attribute;
use Tempest\Reflection\MethodReflector;

#[Attribute]
class Template
{
	public MethodReflector $handler;

    public function __construct(
        public readonly string $name,
    ) {}

    public function setHandler(MethodReflector $handler): self
    {
        $this->handler = $handler;

        return $this;
    }
}
