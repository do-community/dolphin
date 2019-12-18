<?php

namespace App\Service;

use App\Exception\MissingConfigException;
use App\Provider\AnsibleProvider;
use Minicli\App;
use Minicli\ServiceInterface;

class DeployerService implements ServiceInterface
{
    /** @var array  */
    protected $config = [];

    static $DEFAULT_INVENTORY = 'hosts.php';

    static $DEFAULT_PATH = 'playbooks';

    /**
     * @param App $app
     * @throws MissingConfigException
     */
    public function load(App $app)
    {
        if (!$app->config->has('deployer')) {
            throw new MissingConfigException("Missing configuration for Deployer service.");
        }

        $this->config = $app->config->deployer;
    }

    public function setRemoteUser($user)
    {
        $this->config['ansible_user'] = $user;
    }

    public function getInventory()
    {
        return isset($this->config['ansible_inventory']) ? $this->config['ansible_inventory'] : self::$DEFAULT_INVENTORY;
    }

    public function getPlaybooksPath()
    {
        return isset($this->config['playbooks_path']) ? $this->config['playbooks_path'] : self::$DEFAULT_PATH;
    }

    /**
     * Runs a Playbook / Deploy Script
     * @param string $playbook
     * @param string $target
     */
    public function runPlaybook($playbook, $target)
    {
        if ($this->playbookExists($playbook)) {
            $playbook_file = $this->getPlaybookPath($playbook);
            AnsibleProvider::play($playbook_file, $target, $this->getInventory(), $this->config);
        }
    }

    /**
     * Pings a host
     * @param $target
     */
    public function ping($target)
    {
        AnsibleProvider::ping($target, $this->getInventory());
    }

    /**
     * @return array
     */
    public function getPlaybooks()
    {
        $scripts = [];

        foreach (glob($this->getPlaybooksPath() . '/*', GLOB_ONLYDIR) as $playbook) {
            $name = basename($playbook);

            $info = explode('_', $name);
            if (count($info) < 2) {
                $info = [ $name, 'unknown'];
            }

            $scripts[] = ['name' => $name, 'desc' => $info[0] . ' for ' . $info[1]];
        }

        return $scripts;
    }

    /**
     * @param string $playbook
     * @return bool
     */
    public function playbookExists($playbook)
    {
        return is_file($this->getPlaybookPath($playbook));
    }

    /**
     * @param string $playbook
     * @return string
     */
    public function getPlaybookPath($playbook)
    {
        return $this->getPlaybooksPath() . '/' . $playbook . '/playbook.yml';
    }

    /**
     * Shows the current Ansible version on the system
     */
    public function showAnsibleVersion()
    {
        AnsibleProvider::version();
    }
}