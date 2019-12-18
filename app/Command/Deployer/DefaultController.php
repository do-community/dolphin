<?php

namespace App\Command\Deployer;

use App\Service\DeployerService;
use Minicli\Command\CommandController;

class DefaultController extends CommandController
{
    public function handle()
    {
        /** @var DeployerService $deployer */
        $deployer = $this->getApp()->deployer;

        $this->getPrinter()->info("Dolphin Deployer 0.1");
        $deployer->showAnsibleVersion();
        $this->getPrinter()->newline();
    }
}