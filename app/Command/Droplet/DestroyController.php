<?php

namespace App\Command\Droplet;

use App\DigitalOceanService as DigitalOcean;
use Minicli\Command\CommandController;

class DestroyController extends CommandController
{
    public function handle()
    {
        if (!$this->hasParam('id')) {
            $this->getPrinter()->error("You must provide the droplet ID.");
            return;
        }

        $droplet_id = $this->getParam('id');

        /** @var DigitalOcean $digitalocean */
        $digitalocean = $this->getApp()->digitalocean;

        $this->getPrinter()->info(sprintf("Destroying Droplet ID %s ...", $droplet_id));

        if ($digitalocean->destroyDroplet($droplet_id)) {
            $this->getPrinter()->success("Droplet successfully destroyed.\n\n");
        }
    }
}