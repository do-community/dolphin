<?php

namespace App\Model\Ansible;

class Host
{
    /** @var string Host Alias  */
    protected $name;

    /** @var string Host IP address */
    protected $ip;

    /** @var string Host tags (used for creating groups) */
    protected $tags;

    /**
     * Host constructor.
     * @param string $name
     * @param string $ip
     * @param array $tags
     */
    public function __construct($name, $ip, array $tags)
    {
        $this->name = $name;
        $this->ip = $ip;
        $this->tags = $tags;
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
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param string $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    }

    /**
     * @return string
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param string $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    public function toInventory()
    {
        return sprintf("%s ansible_host=%s\n", $this->getName(), $this->getIp());
    }

    public function __toString()
    {
        return $this->getIp();
    }
}