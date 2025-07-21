<?php

namespace app\console;

use App\Core\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Kernel
{
    protected $app;
    protected $commands = [];

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->commands = [
            \App\Console\Commands\ExampleCommand::class,
        ];
    }

    public function handle(InputInterface $input, OutputInterface $output)
    {
        $commandName = $input->getFirstArgument();

        foreach ($this->commands as $commandClass) {
            $command = new $commandClass();
            if ($command->getName() === $commandName) {
                return $command->run($input, $output);
            }
        }

        $output->writeln("Command not found: {$commandName}");
        return 1;
    }
}