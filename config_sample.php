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
