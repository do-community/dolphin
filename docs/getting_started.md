# Getting Started

Dolphin is a PHP-based command line tool for managing DigitalOcean servers.

## Installation

### Prerequisites
Current Requirements:

- PHP (cli)
- Composer
- Curl
- Valid DigitalOcean API Key (R+W)
- Ansible (optional, but required by `deployer`)

It is advisable **not** to install Dolphin on a web server. This tool should only be used either on a local development environment you control (like your work machine) or a remote Linux server secured by a firewall.

### Installing via Git

First, clone this repository with:

```sh
git clone https://github.com/do-community/dolphin.git
```

Now go to Dolphin's directory and set the permissions for the executable:

```sh
cd dolphin
chmod +x dolphin
```

Run `composer install` to install Dolphin's only dependency ([minicli](https://github.com/minicli/minicli)) and set up autoload:

```sh
composer install
```

### Installing Globally: (optional)

If you'd like to use dolphin out of any directory in a global installation, you can do so by creating a symbolic link to the dolphin executable on `/usr/local/bin`. Please notice this will only work for your current user, who owns the `dolphin` directory.

```sh
sudo ln -s /usr/local/bin/dolphin /path/to/dolphin
```

## The Config File

A `config.php` file is created when `composer install` is finished running. Edit the contents of this file and adjust the values accordingly. You need to provide a valid R+W DigitalOcean `api_token` value:

```php
<?php

return [

    /////////////////////////
    // App configuration
    /////////////////////////
    'app_path' => __DIR__ . '/app/Command',

    'theme' => 'unicorn',

    # Cache location relative to doc root
    'cache_dir' => 'var/cache',

    # Cache expiry time in minutes
    'cache_expiry' => 60,

    ////////////////////////////////
    // DigitalOcean configuration
    ///////////////////////////////
    'digitalocean' => [

        # DO API token
        'api_token' => '',

        # Default options when creating new Droplets
        'droplet' => [
            'D_REGION'   => 'ams3',
            'D_IMAGE'    => 'ubuntu-18-04-x64',
            'D_SIZE'     => 's-2vcpu-4gb',
            'D_TAGS'     => [
                'dolphin'
            ],

            # Optional - SSH key(s) to be included for the root user in new droplets.
            # Uncomment and add your own key(s) - ID or Fingerprint
            # You can list your registered keys with: ./dolphin available keys

            #'D_SSH_KEYS' => [
            #    ''
            #],
        ]
    ],

    //////////////////////////////////
    // Ansible Configuration
    //////////////////////////////////
    'ansible' => [

        # Default server group to use when generating Ansible inventory
        'default_server_group' => 'servers',
    ],

    //////////////////////////////////
    // Deployer Configuration
    //////////////////////////////////
    'deployer' => [

        # Where to look for playbooks
        'playbooks_path' => __DIR__ . '/var/playbooks',
        'ansible_user'   => 'sammy',
        'ansible_inventory' => __DIR__ . '/hosts.php',
    ],

];
```

## Running Dolphin

Dolphin follows a `command subcommand` structure like this:

```sh
./dolphin [command] [sub-command] [params]
```

For an overall look of all available commands and subcommands, run `./dolphin help`.


## Using the Dynamic Inventory with Ansible

The included `hosts.php` script works as a dynamic inventory script that can be used directly with Ansible commands.

```
ansible all -m ping -i hosts.php -u root
```

```
ansible-playbook -l server-name -i hosts.php playbooks/setup_ubuntu1804/playbook.yml -u root
```

Please check the [community playbooks](https://github.com/do-community/ansible-playbooks) repository for more details and links to guides that explain how to use the playbooks included in the `playbooks` submodule.
## Tips & Tricks

### Manipulating Cache

To optimize API querying and avoid hitting resource limits, Dolphin uses a simple file caching mechanism.

To force a cache update, include the flag `--force-update`:

```
dolphin droplet list --force-update
```

If instead you'd like to enforce cache usage and not query for new results even if the cache timeout has been reached, you can use:

```
dolphin droplet list --force-cache
```

