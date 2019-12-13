<?php

namespace App\Command\Fetch;

use App\APIObject;
use App\DigitalOceanService;
use Minicli\Command\CommandController;

class RegionsController extends CommandController
{
    public function handle()
    {
        $force_update = 1;

        /** @var DigitalOceanService $digitalocean */
        $digitalocean = $this->getApp()->digitalocean;
        $regions = $digitalocean->getRegions($force_update);

        if ($regions === null) {
            $this->getPrinter()->error("No Regions found.");
            exit;
        }

        $print_table[] = [ 'NAME', 'SLUG', 'AVAILABLE'];

        foreach ($regions as $region_info) {
            $region = new APIObject($region_info);
            $print_table[] = [
                $region->name,
                $region->slug,
                $region->available,
            ];
        }

        $this->getPrinter()->printTable($print_table);
    }
}