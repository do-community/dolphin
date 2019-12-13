<?php

namespace App\Model\Ansible;

class Group
{
    /** @var  string Name of the Group */
    protected $name;

    /** @var  Host[] Hosts */
    protected $hosts;

    /**
     * Group constructor.
     * @param string $name
     * @param array $hosts
     */
    public function __construct($name, array $hosts)
    {
        $this->name = $name;

        foreach ($hosts as $host) {
            $this->addHost($host);
        }
    }

    /**
     * @param Host $host
     */
    public function addHost(Host $host)
    {
        $this->hosts[] = $host;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return Host[]
     */
    public function getHosts()
    {
        return $this->hosts;
    }

    /**
     * @param Host[] $hosts
     */
    public function setHosts(array $hosts)
    {
        foreach ($hosts as $host) {
            $this->addHost($host);
        }
    }
    
    public function toInventory()
    {
        return sprintf("[%s]\n", $this->getName());
    }

    public function getInventoryHosts()
    {
        $hosts = [];

        /** @var Host $host */
        foreach ($this->getHosts() as $host) {
            $hosts[] = $host->getIp();
        }

        return $hosts;
    }

}