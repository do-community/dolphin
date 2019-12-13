```
         ,gggggggggggg,
        dP"""88""""""Y8b,               ,dPYb,             ,dPYb,
        Yb,  88       `8b,              IP'`Yb             IP'`Yb
         `"  88        `8b              I8  8I             I8  8I      gg
             88         Y8              I8  8'             I8  8'      ""
             88         d8   ,ggggg,    I8 dP  gg,gggg,    I8 dPgg,    gg    ,ggg,,ggg,
             88        ,8P  dP"  "Y8ggg I8dP   I8P"  "Yb   I8dP" "8I   88   ,8" "8P" "8,
             88       ,8P' i8'    ,8I   I8P    I8'    ,8i  I8P    I8   88   I8   8I   8I
             88______,dP' ,d8,   ,d8'  ,d8b,_ ,I8 _  ,d8' ,d8     I8,_,88,_,dP   8I   Yb,
            888888888P"   P"Y8888P"    8P'"Y88PI8 YY88888P88P     `Y88P""Y88P'   8I   `Y8
                                               I8
                                               I8
                                               I8
                                               I8
                                               I8
                                               I8
```

# Dolphin

Dolphin is a PHP-based command line tool for managing DigitalOcean servers.

## Requirements

- PHP (cli)
- Composer
- Curl
- Valid DigitalOcean API Key (R+W)

## Installation

### Via Git
First, clone this repository with:

```
git clone https://github.com/do-community/dolphin.git
```

Now go to Dolphin's directory and set the permissions for the executable:

```
cd dolphin
chmod +x dolphin
```

Run `composer install` to install Dolphin's only dependency ([minicli](https://github.com/minicli/minicli)) and set up autoload:

```
composer install
```

## Usage

A `config.php` file is created upon installation with Composer. Edit the contents of this file and adjust the values accordingly:

```
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
    ]

];
```

Now you can execute Dolphin with:

```
./dolphin [command] [sub-command] [params]
```

For an overall look of commands and sub-commands, run `./dolphin help`.

### Installing Globally: (optional)

If you'd like to use dolphin out of any directory in a global installation, you can do so by creating a symbolic link to the dolphin executable on `/usr/local/bin`. Please notice this will only work for your current user, who owns the `dolphin` directory.

```
sudo ln -s /usr/local/bin/dolphin /home/erika/Projects/dolphin/dolphin
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
dolphin droplet info DROPLET_ID
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


It will take a few moments before the network is ready and you're able to SSH or run `droplet deployer` on that server. To get the IP address, run this command after a few seconds:

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
dolphin droplet destroy DROPLET_ID
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

## Using the Dynamic Inventory Script with Ansible

If you'd like to use the dynamic inventory feature of Dolphin while running native Ansible commands and playbooks, you can use the included `hosts.php` dynamic inventory script, and you can also generate a static inventory file using the `dolphin inventory` command.

### Using the included Dynamic Inventory Script

The included `hosts.php` script works as a dynamic inventory script that can be used directly with Ansible commands.

```
ansible all -m ping -i hosts.php
```
