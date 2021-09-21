## This Project is Deprecated.
*We've set the repository as read-only for learning purposes, but there won't be any new updates.*

![Dolphin screenshot](https://heidislab.ams3.cdn.digitaloceanspaces.com/dolphin/screenshot.png)

# Dolphin

Dolphin is a PHP-based command line tool for managing DigitalOcean servers. The `deployer` command uses Ansible as underlying mechanism for running automation tasks on Droplets.

_This tool is experimental, use at your own risk._

## Requirements

- PHP (cli)
- Composer
- Curl
- Valid DigitalOcean API Key (R+W)
- Ansible (required by `deployer`)

## Installation

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

## Usage

A `config.php` file is created upon installation with Composer. Edit the contents of this file and adjust the values accordingly. You need to provide a valid R+W DigitalOcean `api_token` value:

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

Now you can execute Dolphin with:

```sh
./dolphin [command] [sub-command] [params]
```

For an overall look of commands and sub-commands, run `./dolphin help`.

### Installing Globally: (optional)

If you'd like to use dolphin out of any directory in a global installation, you can do so by creating a symbolic link to the dolphin executable on `/usr/local/bin`. Please notice this will only work for your current user, who owns the `dolphin` directory.

```sh
sudo ln -s /usr/local/bin/dolphin /path/to/dolphin
```

## Droplet Commands: `dolphin droplet`

The following commands can be used to manage droplets.

### Listing Droplets

```command
dolphin droplet list
```

This will show a list with your DigitalOcean droplets (ID, name, IP, region and size).

```
ID        NAME                        IP              REGION    SIZE
140295122 ubuntu-1804-01              188.166.115.68  ams3      s-1vcpu-2gb
140295123 ubuntu-1804-02              188.166.123.245 ams3      s-1vcpu-2gb
140295124 ubuntu-1804-03              174.138.13.97   ams3      s-1vcpu-2gb
142352633 mysql-wordpress             165.22.254.246  sgp1      s-2vcpu-4gb
142807570 ubuntu-s-1vcpu-1gb-ams3-01  167.99.217.247  ams3      s-1vcpu-1gb
```


### Getting Information About a Droplet

```
dolphin droplet info id=DROPLET_ID
```

The output will be a JSON will all the available information about that droplet.

### Creating a New Droplet
Uses default options from your config file, but you can override any of the API query parameters.
Parameters should be passed as `name=value` items. If you don't provide a name, it will be automatically generated for you.

Creating a new droplet with default options and random name:

```
dolphin droplet create
```

You will see output like this:

```
Creating new Droplet...

Your new droplet "fine-shark" was successfully created. Please notice it might take a few minutes for the network to be ready.
Here's some info:

id        name       region    size         image             created at
155243337 fine-shark fra1      s-2vcpu-4gb  ubuntu-18-04-x64  2019-08-17T06:20:35Z

```


It will take a few moments before the network is ready and you're able to SSH or run `ansible` on that server. To get the IP address, run this command after a few seconds:

```
dolphin droplet list --force-update
```

This will show an updated list of your Droplets, including the newly created one.

Now let's say you want to use a custom name, region and droplet size:

```
dolphin droplet create name=MyDropletName size=s-2vcpu-4gb region=fra1
```

Check the [DigitalOCean API documentation](https://developers.digitalocean.com/documentation/v2/#create-a-new-droplet) for more information on all the parameters you can use when creating new Droplets.

### Destroying a Droplet
You can obtain the ID of a Droplet by running `droplet list` to list all your droplets.

```
dolphin droplet destroy id=DROPLET_ID
```


You can destroy multiple droplets by providing a list of IDs separated by commas:

```
dolphin droplet destroy id=DROPLET_ID,DROPLET2_ID,DROPLET3_ID
```

## Checking for Information: `dolphin fetch`

To get a list of all available regions you can use when creating a new Droplet, use:

```
dolphin fetch regions
```

```
NAME             SLUG      AVAILABLE
New York 1       nyc1      1
San Francisco 1  sfo1      1
New York 2       nyc2      1
Amsterdam 2      ams2      1
Singapore 1      sgp1      1
London 1         lon1      1
New York 3       nyc3      1
Amsterdam 3      ams3      1
Frankfurt 1      fra1      1
Toronto 1        tor1      1
San Francisco 2  sfo2      1
Bangalore 1      blr1      1
```


To get a list of all available sizes you can use when creating a new Droplet, use:

```
dolphin fetch sizes
```

```
SLUG         MEMORY    VCPUS     DISK      TRANSFER  PRICE/MONTH
512mb        512MB     1         20GB      1TB       $5
s-1vcpu-1gb  1024MB    1         25GB      1TB       $5
1gb          1024MB    1         30GB      2TB       $10
s-1vcpu-2gb  2048MB    1         50GB      2TB       $10
s-1vcpu-3gb  3072MB    1         60GB      3TB       $15
s-2vcpu-2gb  2048MB    2         60GB      3TB       $15
s-3vcpu-1gb  1024MB    3         60GB      3TB       $15
2gb          2048MB    2         40GB      3TB       $20
s-2vcpu-4gb  4096MB    2         80GB      4TB       $20
4gb          4096MB    2         60GB      4TB       $40
c-2          4096MB    2         25GB      4TB       $40
m-1vcpu-8gb  8192MB    1         40GB      5TB       $40
s-4vcpu-8gb  8192MB    4         160GB     5TB       $40
g-2vcpu-8gb  8192MB    2         25GB      4TB       $60
gd-2vcpu-8gb 8192MB    2         50GB      4TB       $65
m-16gb       16384MB   2         60GB      5TB       $75
8gb          8192MB    4         80GB      5TB       $80
c-4          8192MB    4         50GB      5TB       $80
s-6vcpu-16gb 16384MB   6         320GB     6TB       $80
g-4vcpu-16gb 16384MB   4         50GB      5TB       $120
```

To get a list of all registered SSH Keys you can use when creating a new Droplet, use:

```
dolphin fetch keys
```

```
ID        NAME      FINGERPRINT
23937789  heidislab e7:51:a3:7e:e1:11:1b:d1:69:8e:98:3d:45:5f:7f:14
```

## Deployer

The `deployer` commands use Ansible to execute automation scripts on your droplets. Playbooks are not included with Dolphin, 
but you can use our [ansible-playbooks](https://github.com/do-community/ansible-playbooks) repository to get started and create your own playbooks. 

To do so, clone that repository into the `var/playbooks` folder:

```
cd var/playbooks
git clone https://github.com/do-community/ansible-playbooks.git community-playbooks
```

Then, adjust the `playbooks_path` setting inside your `config.php` file to point to the cloned repository folder:

```
'playbooks_path' => __DIR__ . '/var/playbooks/community-playbooks',
```

Run the `list` command to see the available playbooks:

```
dolphin deployer list
```

```
Playbooks Currently Available:

NAME                          DESCRIPTION                   
apache_ubuntu1804             apache for ubuntu1804         
docker_ubuntu1804             docker for ubuntu1804         
lamp_ubuntu1804               lamp for ubuntu1804           
lemp_ubuntu1804               lemp for ubuntu1804           
setup_ubuntu1804              setup for ubuntu1804          
wordpress-lamp_ubuntu1804     wordpress-lamp for ubuntu1804 

```

To run a playbook on a droplet:

```
dolphin deployer run [playbook] on [target]
```

## Example For Deploying a new Wordpress on LAMP

1. Create a new server with `dolphin droplet create`. Copy the server name.
2. Run the Initial Server Setup as root: `dolphin deployer run setup_ubuntu1804 server-name user=root`
3. Run the Wordpress on LAMP playbook: `dolphin deployer run wordpress-lamp_ubuntu1804 server-name` 

Run `dolphin droplet list` to obtain the server IP. Access it from your browser and you should see the WP setup page.

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


