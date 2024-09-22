<?php

namespace Tempest\Scaffold;

use Tempest\Console\Console;
use Tempest\Container\Container;
use Tempest\Console\ConsoleCommand;

final readonly class SetupCommand
{
    public function __construct(
        private readonly Container $container,
        private readonly Console $console,
        private readonly TemplateConfig $templateConfig,
    ) {}

    #[ConsoleCommand(
        name: 'scaffold:setup',
        description: 'Walk the user through some basic set up options',
    )]
    public function setup(): void
    {
		$this->console->success('Welcome to Tempest!')
			->writeln('Because this is a fresh project, do you want to get started with any templates?');

		$templateOptions = array_map(
			callback: fn(Template $template) => $template->name,
			array: $this->templateConfig->allTemplates(),
		);

		$names = $this->console->ask(
			question: 'Select any templates to install',
			options: $templateOptions,
			multiple: true,
		);

		foreach ($names as $name) {
			$template = $this->templateConfig->getTemplate($name);

			$this->console->info("Installing {$template->name}");

			$this->container->invoke($template->handler);
		}

		if (! empty($names)) {
			$this->console->info('Finished');
		}
    }
}