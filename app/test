<?php
/**
 * Inventory Command Controller
 */

namespace Dolphin\Command;

use Dolphin\Core\CommandController;
use Dolphin\Model\Ansible\Group;
use Dolphin\Model\Ansible\Host;
use Dolphin\Model\Ansible\Inventory;
use Dolphin\Model\DigitalOcean\Droplet;

class InventoryController extends CommandController
{

    /**
     * Outputs inventory in INI format
     */
    public function outputInventory()
    {
        $inventory = $this->getInventory();

        if ($inventory === null) {
            $this->getPrinter()->error("ERROR: unable to create inventory.");
            exit;
        }

        echo $inventory->output();
    }

    /**
     * Outputs inventory in JSON format
     */
    public function dynamicInventory()
    {
        $inventory = $this->getInventory();

        if ($inventory === null) {
            $this->getPrinter()->error("ERROR: unable to create inventory.");
        }

        print $inventory->getJson();
    }

    public function getCommandMap()
    {
        return [
            'json' => 'dynamicInventory',
            'ini'  => 'outputInventory',
        ];
    }

    public function defaultCommand()
    {
        $this->outputInventory();
    }

    /**
     * @return Inventory|null
     * @throws \Dolphin\Exception\APIException
     */
    protected function getInventory()
    {
        $droplets = $this->dolphin->getDO()->getDroplets();

        if ($droplets !== null) {

            $hosts = [];
            foreach ($droplets as $droplet_info) {
                $droplet = new Droplet($droplet_info);

                $hosts[] = new Host($droplet->name, $droplet->networks['v4'][0]['ip_address'], $droplet->tags);
            }

            $groups[] = new Group($this->getConfig('DEFAULT_SERVER_GROUP'), $hosts);

            return new Inventory($groups);
        }

        return null;
    }
}