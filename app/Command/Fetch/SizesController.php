<?php

namespace App\Command\Fetch;

use App\Model\APIObject;
use App\Service\DigitalOceanService;
use Minicli\Command\CommandController;

class SizesController extends CommandController
{
    public function handle()
    {
        $force_update = 1;

        /** @var DigitalOceanService $digitalocean */
        $digitalocean = $this->getApp()->digitalocean;

        $sizes = $digitalocean->getSizes($force_update);

        if ($sizes === null) {
            $this->getPrinter()->error("No Sizes found.");
            exit;
        }

        $print_table[] = [ 'SLUG', 'MEMORY', 'VCPUS', 'DISK', 'TRANSFER', 'PRICE/MONTH'];

        foreach ($sizes as $size_info) {
            $size = new APIObject($size_info);
            $print_table[] = [
                $size->slug,
                $size->memory . 'MB',
                $size->vcpus,
                $size->disk . 'GB',
                $size->transfer . 'TB',
                '$' .$size->price_monthly
            ];
        }

        $this->getPrinter()->printTable($print_table);
    }
}