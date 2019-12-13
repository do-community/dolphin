<?php

namespace App\Command\Droplet;

use App\DigitalOceanService as DigitalOcean;
use App\Exception\APIException;
use Minicli\Command\CommandController;

class InfoController extends CommandController
{
    public function handle()
    {
        $force_update = $this->hasFlag('--force-update') ? 1 : 0;

        if ($this->hasFlag('--force-cache')) {
            $force_update = -1;
        }

        if (!$this->hasParam('id')) {
            $this->getPrinter()->error("You must provide the droplet ID.");
            return;
        }

        $droplet_id = $this->getParam('id');
        
        $this->getPrinter()->newline();
        $this->getPrinter()->out(sprintf("Fetching Droplet info for ID %s...", $droplet_id), "alt");

        /** @var DigitalOcean $digitalocean */
        $digitalocean = $this->getApp()->digitalocean;

        try {
            $droplet = $digitalocean->getDroplet($droplet_id, $force_update);

            $this->getPrinter()->newline();
            print_r($droplet);

        } catch (APIException $e) {
            $this->getPrinter()->error("An API error occurred.");
            $this->getPrinter()->out("Response Info:");
            $this->getPrinter()->newline();

            print_r($digitalocean->getLastResponse());
            exit;
        }
    }
}