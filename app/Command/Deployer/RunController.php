<?php

namespace App\Command\Deployer;


use App\Service\DeployerService;
use Minicli\Command\CommandController;

class RunController extends CommandController
{
    public function handle()
    {
        $args = $this->getArgs();
        $playbook_name = isset($args[3]) ? $args[3] : null;
        if ($playbook_name === null) {
            $this->getPrinter()->error('Missing playbook name and target.');
            exit;
        }

        $target = isset($args[5]) ? $args[5] : null;
        if ($target === null) {
            $this->getPrinter()->error('Missing target.');
            exit;
        }

        /** @var DeployerService $deployer */
        $deployer = $this->getApp()->deployer;
        if (!$deployer->playbookExists($playbook_name)) {
            $this->getPrinter()->error("Playbook $playbook_name not found.");
            exit;
        }

        if ($this->hasParam('user')) {
            $deployer->setRemoteUser($this->getParam('user'));
        }

        $this->getPrinter()->info("Initiating Deployer...");
        $deployer->showAnsibleVersion();
        $this->getPrinter()->newline();

        $this->getPrinter()->info("Starting Playbook Execution... This might take several minutes.");
        $deployer->runPlaybook($playbook_name, $target);
        $this->getPrinter()->success("Playbook Execution Finished.");
    }
}