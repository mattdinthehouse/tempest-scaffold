<?php

namespace Tempest\Scaffold\Templates\Tailwind;

use Tempest\Console\Console;
use Tempest\Scaffold\Template;

final readonly class TailwindTemplate
{
    public function __construct(
        private readonly Console $console,
    ) {}

	#[Template(
		name: 'tailwind',
	)]
	public function __invoke(): void
	{
		$this->console->writeln('hello tailwind');
	}
}