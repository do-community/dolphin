<?php

namespace App\Command\Dive;

use App\Service\DeployerService;
use Minicli\App;
use Minicli\Command\CommandController;
use Minicli\Exception\CommandNotFoundException;
use Minicli\Input;

class DefaultController extends CommandController
{
    protected $dive_commands = [];

    public function boot(App $app)
    {
        parent::boot($app);

        $this->registerDiveCommand('exit', function() {
            exit;
        });

        $this->registerDiveCommand('clear', function () {
            $this->clear();
        });
    }

    public function handle()
    {
        /** @var DeployerService $deployer */
        $deployer = $this->getApp()->deployer;
        $input = new Input('DOlph1n> ');

        $this->getPrinter()->info("Dolphin Client 1.0\nType 'help' for help");

        while (true) {
            $command = $input->read();

            if ($this->hasDiveCommand($command)) {
                $this->runDiveCommand($command);
                continue;
            }

            $argv = array_merge([ 'dolphin' ], explode(' ', $command));
            try {
                $this->getApp()->runCommand($argv);
            } catch (CommandNotFoundException $e) {
                $this->getPrinter()->error("Command not found.");
            }

        }
    }

    protected function runDiveCommand($name)
    {
        $command = $this->getDiveCommand($name);

        if ($command) {
            call_user_func($command, $this->getApp());
        }
    }

    protected function registerDiveCommand($name, $callable)
    {
        $this->dive_commands[$name] = $callable;
    }

    protected function hasDiveCommand($name)
    {
        return isset($this->dive_commands[$name]);
    }

    protected function getDiveCommand($name)
    {
        return $this->hasDiveCommand($name) ? $this->dive_commands[$name] : null;
    }

    protected function clear()
    {
        $lines = 40;

        for($i = 0; $i < $lines; $i++) {
            $this->getPrinter()->newline();
        }
    }
}