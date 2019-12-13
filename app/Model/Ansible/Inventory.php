<?php

namespace App\Model\Ansible;

class Inventory
{
    /** @var Group[] Groups  */
    protected $groups = [];

    /**
     * Inventory constructor.
     * @param array $groups
     */
    public function __construct(array $groups)
    {
        foreach ($groups as $group) {
            $this->addGroup($group);
        }
    }

    /**
     * @param Group $group
     */
    public function addGroup(Group $group)
    {
        $this->groups[] = $group;
    }

    /**
     * @return array
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * @param array $groups
     */
    public function setGroups(array $groups)
    {
        foreach ($groups as $group) {
            $this->addGroup($group);
        }
    }

    public function getJson()
    {
        $inventory = [];
        $groups = [ 'ungrouped' ];
        $hostvars = [];
        $hosts = [];
        $all = [];

        /** @var Group $group */
        foreach ($this->getGroups() as $group) {

            $groups[] = $group->getName();
            /** @var Host $host */
            foreach ($group->getHosts() as $host) {
                $hostvars[$host->getName()] = [
                    'ansible_host' => $host->getIp(),
                    'ansible_python_interpreter' => "/usr/bin/python3"
                ];

                $hosts[] = $host->getName();
            }

            $inventory[$group->getName()] = [
                'hosts' => $hosts,
            ];

            $hosts = [];
        }

        $inventory['all'] = [
            "children" =>  $groups
        ];

        $inventory['_meta'] = [
            'hostvars'  => $hostvars,
        ];

        return json_encode($inventory, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    /**
     * @return string
     */
    public function output()
    {
        $inventory = "";
        
        /** @var Group $group */
        foreach ($this->getGroups() as $group) {
            $inventory .= $group->toInventory();
            
            /** @var Host $host */
            foreach ($group->getHosts() as $host) {
                $inventory .= $host->toInventory();
            }
        }
        
        /** Setting Python 3 for all hosts */
        $inventory .= sprintf("\n[all:vars]\nansible_python_interpreter=/usr/bin/python3\n");

        return $inventory;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->output();
    }
}