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

        $multiple = explode(',', $droplet_id);

        foreach ($multiple as $id) {
            /** @var DigitalOcean $digitalocean */
            $digitalocean = $this->getApp()->digitalocean;

            $id = trim($id);
            $this->getPrinter()->info(sprintf("Destroying Droplet ID %s ...", $id));

            if ($digitalocean->destroyDroplet($id)) {
                $this->getPrinter()->success("Droplet successfully destroyed.\n\n");
            }
        }
    }
}