<?php

namespace App\Command\Fetch;

use App\Model\APIObject;
use App\Service\DigitalOceanService;
use Minicli\Command\CommandController;

class KeysController extends CommandController
{
    public function handle()
    {
        $force_update = 1;

        /** @var DigitalOceanService $digitalocean */
        $digitalocean = $this->getApp()->digitalocean;

        $keys = $digitalocean->getKeys($force_update);

        if ($keys === null) {
            $this->getPrinter()->error("No SSH Keys found.");
            exit;
        }

        $print_table[] = [ 'ID', 'NAME', 'FINGERPRINT' ];

        foreach ($keys as $key_info) {
            $key = new APIObject($key_info);
            $print_table[] = [
                $key->id,
                $key->name,
                $key->fingerprint,
            ];
        }

        $this->getPrinter()->printTable($print_table);
    }

}