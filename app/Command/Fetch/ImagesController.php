<?php

namespace App\Command\Fetch;

use App\APIObject;
use App\DigitalOceanService;
use Minicli\Command\CommandController;

class ImagesController extends CommandController
{
    public function handle()
    {
        $force_update = 1;

        /** @var DigitalOceanService $digitalocean */
        $digitalocean = $this->getApp()->digitalocean;

        $images = $digitalocean->getImages($force_update);

        if ($images === null) {
            $this->getPrinter()->error("No Images found.");
            exit;
        }

        $print_table[] = [ 'ID', 'NAME', 'DIST', 'SLUG', 'TYPE', 'MIN_DISK_SIZE', 'VISIBILITY'];

        foreach ($images as $image_info) {
            $image = new APIObject($image_info);
            $print_table[] = [
                $image->id,
                $image->name,
                $image->distribution,
                $image->slug,
                $image->type,
                $image->min_disk_size ? $image->min_disk_size . 'GB' : '-',
                $image->public ? 'public' : 'private',
            ];
        }

        $this->getPrinter()->printTable($print_table);
    }
}