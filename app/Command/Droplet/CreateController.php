<?php

namespace App\Command\Droplet;

use App\Model\APIObject;
use App\Service\DigitalOceanService;
use App\Exception\APIException;
use App\Provider\RandomNameProvider;
use Minicli\Command\CommandController;

class CreateController extends CommandController
{

    public function handle()
    {
        /** @var DigitalOceanService $digitalocean */
        $digitalocean = $this->getApp()->digitalocean;
        $params = $this->getParams();

        if (!isset($params['name'])) {
            $params['name'] = RandomNameProvider::getName();
        }

        $this->getPrinter()->info("Creating new Droplet...");

        try {
            $response = $digitalocean->createDroplet($params);
            $this->getPrinter()->success(
                sprintf("Your new droplet \"%s\" was successfully created. Please notice it might take a few minutes for the network to be ready.\nHere's some info:", $params['name'])
            );

            $response_body = json_decode($response['body'], true);
            $droplet = new APIObject($response_body['droplet']);

            $table[] = [ 'id', 'name', 'region', 'size', 'image', 'created at' ];
            $table[] = [
                $droplet->id,
                $droplet->name,
                $droplet->region['slug'],
                $droplet->size_slug,
                $droplet->image['slug'],
                $droplet->created_at,
            ];

            $this->getPrinter()->printTable($table);

        } catch (APIException $e) {
            $this->getPrinter()->error("An API error has ocurred.");
            $this->getPrinter()->out("Response Info:");
            $this->getPrinter()->newline();

            print_r($digitalocean->getLastResponse());
        }

        $this->getPrinter()->newline();
    }

}