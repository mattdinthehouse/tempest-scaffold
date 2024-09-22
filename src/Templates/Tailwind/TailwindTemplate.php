<?php

namespace Tempest\Scaffold\Templates\Tailwind;

use Tempest\Console\Console;
use Tempest\Core\Kernel;
use Tempest\Scaffold\Template;

final readonly class TailwindTemplate
{
	const TAILWIND_NPM_VERSION = '^3.4.1';

    public function __construct(
        private readonly Console $console,
		private readonly Kernel $kernel,
    ) {}

	#[Template(
		name: 'tailwind',
	)]
	public function __invoke(): void
	{
		$this->setupNpm();

		$this->configureTailwind();

		$this->writeDummyCss();

		// TODO: wrap this one in an "is post-create-project-cmd hook" check
		$this->rewriteHomeView();

		$this->console->writeln('Done!')
			->info('Run `npm install` to complete the installation, then `npm run dev` to compile your Tailwind styles');
	}

	private function setupNpm(): void
	{
		$this->console->writeln('Adding tailwindcss to your package.json');

		$packageJsonPath = "{$this->kernel->root}/package.json";

		$packageJson = @file_get_contents($packageJsonPath);

		$data = @json_decode(
			json: $packageJson,
			associative: true,
		);

		if (! $data) {
			$data = [
				'scripts' => [ ],
				'devDependencies' => [ ],
			];
		}

		$data['scripts']['dev'] = 'npx tailwindcss -i ./app/main.css -o ./public/main.css --watch';
		$data['scripts']['build'] = 'npx tailwindcss -i ./app/main.css -o ./public/main.css';

		$data['devDependencies']['tailwindcss'] = self::TAILWIND_NPM_VERSION;

		$packageJson = json_encode(
			value: $data,
			flags: JSON_PRETTY_PRINT,
		);

		file_put_contents($packageJsonPath, $packageJson);
	}

	private function configureTailwind(): void
	{
		$this->console->writeln('Adding a tailwind.config.js file');

		$src = __DIR__;
		$src = "{$src}/tailwind.config.js";

		$dst = "{$this->kernel->root}/tailwind.config.js";

		copy($src, $dst);
	}

	private function writeDummyCss(): void
	{
		$this->console->writeln('Adding a dummy css file');

		$src = __DIR__;
		$src = "{$src}/main.css";

		$dst = "{$this->kernel->root}/app/main.css";

		copy($src, $dst);
	}

	private function rewriteHomeView(): void
	{
		$this->console->writeln('Replacing your app/home.view.php file');

		$src = __DIR__;
		$src = "{$src}/home.view.php";

		$dst = "{$this->kernel->root}/app/home.view.php";

		copy($src, $dst);
	}
}