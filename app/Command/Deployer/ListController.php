<?php

namespace App\Command\Deployer;

use App\Service\DeployerService;
use Minicli\Command\CommandController;

class ListController extends CommandController
{
    public function handle()
    {
        /** @var DeployerService $deployer */
        $deployer = $this->getApp()->deployer;

        $this->getPrinter()->info("Playbooks Currently Available:");
        $scripts = $deployer->getPlaybooks();

        $table_content[] = [ 'NAME', 'DESCRIPTION' ];

        foreach ($scripts as $deploy) {
            $table_content[] = [ $deploy['name'], $deploy['desc'] ];
        }

        $this->getPrinter()->printTable($table_content, 30);

        $this->getPrinter()->out("You can run a script with: ./dolphin deployer run [playbook name] on [target]");
        $this->getPrinter()->newline();
    }
}