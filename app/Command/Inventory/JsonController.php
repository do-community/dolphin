<?php

namespace App\Command\Inventory;

use App\Model\APIObject;
use App\Service\DigitalOceanService;
use App\Model\Ansible\Group;
use App\Model\Ansible\Host;
use App\Model\Ansible\Inventory;
use Minicli\Command\CommandController;

class JsonController extends CommandController
{
    public function handle()
    {
        /** @var DigitalOceanService $digitalocean */
        $digitalocean = $this->getApp()->digitalocean;

        $force_update = $this->hasFlag('--force-update') ? 1 : 0;

        $droplets = $digitalocean->getDroplets($force_update);

        if ($droplets === null) {
            $this->getPrinter()->error("No Droplets found.");
            exit;
        }

        $hosts = [];
        foreach ($droplets as $droplet_info) {
            $droplet = new APIObject($droplet_info);

            $hosts[] = new Host($droplet->name, $droplet->networks['v4'][0]['ip_address'], $droplet->tags);
        }

        $group_name = $this->getApp()->config->ansible['default_server_group'];

        $groups[] = new Group($group_name, $hosts);

        $inventory = new Inventory($groups);

        if ($inventory === null) {
            $this->getPrinter()->error("ERROR: unable to create inventory.");
            exit;
        }

        print $inventory->getJson();
    }
}