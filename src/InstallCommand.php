<?php

namespace Tempest\Scaffold;

use Tempest\Console\Console;
use Tempest\Console\ExitCode;
use Tempest\Console\ConsoleCommand;
use Tempest\Console\ConsoleArgument;
use Tempest\Container\Container;

final readonly class InstallCommand
{
    public function __construct(
        private readonly Container $container,
        private readonly Console $console,
        private readonly TemplateConfig $templateConfig,
    ) {}

    #[ConsoleCommand(
        name: 'scaffold:install',
        description: 'Install a Tempest scaffold',
    )]
    public function install(
        #[ConsoleArgument(
            description: 'The scaffold template to install',
        )]
        string $name,
    ): ExitCode
    {
        if (! $this->isReadyToInstall()) {
            return ExitCode::ERROR;
        }

        $template = $this->templateConfig->getTemplate($name);
        
        $this->container->invoke($template->handler);

        return ExitCode::SUCCESS;
    }

    private function isReadyToInstall(): bool
    {
        return $this->console->info(<<<MSG
            It's good practice to commit any changes to your repo before installing a scaffold.
            Doing so will allow you to see exactly what the scaffold did to your code and easily roll it back.
            MSG)
            ->confirm('Do you have a clean staging area?');
    }
}