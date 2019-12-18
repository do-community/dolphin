<?php

namespace App\Provider;

class AnsibleProvider
{
    static $ANSIBLE_PATH = '/usr/bin/ansible';
    static $ANSIBLE_PLAYBOOK_PATH = '/usr/bin/ansible-playbook';

    /**
     * Prints Ansible version.
     */
    public static function version()
    {
        system('ansible --version');
    }

    /**
     * Pings a host.
     * @param $target
     * @param $inventory
     * @param array $connection_options
     */
    public static function ping($target, $inventory, array $connection_options = [])
    {
        $extra_options = '';

        if (array_key_exists('ansible_user', $connection_options)) {
            $extra_options .= ' -u ' . $connection_options['ansible_user'];
        }

        system(sprintf("%s -m ping %s -i %s %s", self::$ANSIBLE_PATH, $target, $inventory, $extra_options));
    }

    /**
     * Runs a playbook.
     * @param $playbook
     * @param $target
     * @param $inventory
     * @param array $connection_options
     */
    public static function play($playbook, $target, $inventory, array $connection_options = [])
    {
        $extra_options = '';

        if (array_key_exists('ansible_user', $connection_options)) {
            $extra_options .= ' -u ' . $connection_options['ansible_user'];
        }

        system(sprintf("%s -l %s -i %s %s %s", self::$ANSIBLE_PLAYBOOK_PATH, $target, $inventory, $playbook, $extra_options));
    }
}