<?php

namespace App\Command\Droplet;

use App\APIObject;
use App\DigitalOceanService as DigitalOcean;
use Minicli\Command\CommandController;

class ListController extends CommandController
{
    public function handle()
    {
        $force_update = $this->hasFlag('--force-update') ? 1 : 0;

        if ($this->hasFlag('--force-cache')) {
            $force_update = -1;
        }

        /** @var DigitalOcean $digitalocean */
        $digitalocean = $this->getApp()->digitalocean;
        $droplets = $digitalocean->getDroplets($force_update);

        if ($droplets === null) {
            $this->getPrinter()->error("No Droplets found.");
            exit;
        }

        $print_table[] = [ 'ID', 'NAME', 'IMAGE', 'IP', 'REGION', 'SIZE'];

        foreach ($droplets as $droplet_info) {
            $droplet = new APIObject($droplet_info);
            $print_table[] = [
                $droplet->id,
                $droplet->name,
                $droplet->image['slug'],
                $droplet->networks['v4'][0]['ip_address'],
                $droplet->region['slug'],
                $droplet->size_slug,
            ];
        }

        $this->getPrinter()->printTable($print_table);
    }

}