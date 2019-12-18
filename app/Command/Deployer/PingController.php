<?php

namespace App\Command\Deployer;


use App\Service\DeployerService;
use Minicli\Command\CommandController;

class PingController extends CommandController
{
    public function handle()
    {
        $args = $this->getArgs();
        $target = isset($args[3]) ? $args[3] : null;
        if ($target === null) {
            $this->getPrinter()->error('Missing target.');
            exit;
        }

        /** @var DeployerService $deployer */
        $deployer = $this->getApp()->deployer;

        if ($this->hasParam('user')) {
            $deployer->setRemoteUser($this->getParam('user'));
        }

        $deployer->ping($target);
    }
}