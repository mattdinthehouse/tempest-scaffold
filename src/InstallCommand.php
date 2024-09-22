<?php

namespace Tempest\Scaffold;

use Tempest\Console\Console;
use Tempest\Console\ExitCode;
use Tempest\Console\ConsoleCommand;
use Tempest\Console\ConsoleArgument;

final readonly class InstallCommand
{
    public function __construct(
        private Console $console,
    ) {}

    #[ConsoleCommand(
        name: 'scaffold:install',
        description: 'Install a Tempest scaffold',
    )]
    public function install(
        #[ConsoleArgument(
            description: 'The scaffold template to install',
        )]
        string $template,
    ): ExitCode
    {
        if (! $this->isReadyToInstall()) {
            return ExitCode::ERROR;
        }

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