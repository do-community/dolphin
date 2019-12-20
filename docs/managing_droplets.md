# Managing Droplets

Droplet Commands: `dolphin droplet`. The following commands can be used to manage droplets.

## Listing Droplets

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


## Getting Information About a Droplet

```
dolphin droplet info id=DROPLET_ID
```

The output will print all the available information about that droplet:

```
Fetching Droplet info for ID 172170957...
Array
(
    [id] => 172170957
    [name] => exotic-seal
    [memory] => 4096
    [vcpus] => 2
    [disk] => 80
    [locked] => 
    [status] => active
    [kernel] => 
    [created_at] => 2019-12-19T18:27:07Z
    [features] => Array
        (
        )

    [backup_ids] => Array
        (
        )

    [next_backup_window] => 
    [snapshot_ids] => Array
        (
        )

    [image] => Array
        (
            [id] => 53893572
            [name] => 18.04.3 (LTS) x64
            [distribution] => Ubuntu
            [slug] => ubuntu-18-04-x64
            [public] => 1
            [regions] => Array
                (
                    [0] => nyc1
                    [1] => sfo1
                    [2] => nyc2
                    [3] => ams2
                    [4] => sgp1
                    [5] => lon1
                    [6] => nyc3
                    [7] => ams3
                    [8] => fra1
                    [9] => tor1
                    [10] => sfo2
                    [11] => blr1
                )

            [created_at] => 2019-10-22T01:38:19Z
            [min_disk_size] => 20
            [type] => snapshot
            [size_gigabytes] => 2.36
            [description] => Ubuntu 18.04 x64 20191022
            [tags] => Array
                (
                )

            [status] => available
        )

    [volume_ids] => Array
        (
        )

    [size] => Array
        (
            [slug] => s-2vcpu-4gb
            [memory] => 4096
            [vcpus] => 2
            [disk] => 80
            [transfer] => 4
            [price_monthly] => 20
            [price_hourly] => 0.02976
            [regions] => Array
                (
                    [0] => ams2
                    [1] => ams3
                    [2] => blr1
                    [3] => fra1
                    [4] => lon1
                    [5] => nyc1
                    [6] => nyc2
                    [7] => nyc3
                    [8] => sfo1
                    [9] => sfo2
                    [10] => sgp1
                    [11] => tor1
                )

            [available] => 1
        )

    [size_slug] => s-2vcpu-4gb
    [networks] => Array
        (
            [v4] => Array
                (
                    [0] => Array
                        (
                            [ip_address] => 178.62.250.211
                            [netmask] => 255.255.192.0
                            [gateway] => 178.62.192.1
                            [type] => public
                        )

                )

            [v6] => Array
                (
                )

        )

    [region] => Array
        (
            [name] => Amsterdam 3
            [slug] => ams3
            [features] => Array
                (
                    [0] => private_networking
                    [1] => backups
                    [2] => ipv6
                    [3] => metadata
                    [4] => install_agent
                    [5] => storage
                    [6] => image_transfer
                    [7] => server_id
                    [8] => management_networking
                )

            [available] => 1
            [sizes] => Array
                (
                    [0] => s-1vcpu-1gb
                    [1] => 512mb
                    [2] => s-1vcpu-2gb
                    [3] => 1gb
                    [4] => s-3vcpu-1gb
                    [5] => s-2vcpu-2gb
                    [6] => s-1vcpu-3gb
                    [7] => s-2vcpu-4gb
                    [8] => 2gb
                    [9] => s-4vcpu-8gb
                    [10] => m-1vcpu-8gb
                    [11] => c-2
                    [12] => 4gb
                    [13] => g-2vcpu-8gb
                    [14] => gd-2vcpu-8gb
                    [15] => m-16gb
                    [16] => s-6vcpu-16gb
                    [17] => c-4
                    [18] => 8gb
                    [19] => m-2vcpu-16gb
                    [20] => m3-2vcpu-16gb
                    [21] => g-4vcpu-16gb
                    [22] => gd-4vcpu-16gb
                    [23] => m6-2vcpu-16gb
                    [24] => m-32gb
                    [25] => s-8vcpu-32gb
                    [26] => c-8
                    [27] => 16gb
                    [28] => m-4vcpu-32gb
                    [29] => m3-4vcpu-32gb
                    [30] => g-8vcpu-32gb
                    [31] => s-12vcpu-48gb
                    [32] => gd-8vcpu-32gb
                    [33] => m6-4vcpu-32gb
                    [34] => m-64gb
                    [35] => s-16vcpu-64gb
                    [36] => c-16
                    [37] => 32gb
                    [38] => m-8vcpu-64gb
                    [39] => m3-8vcpu-64gb
                    [40] => g-16vcpu-64gb
                    [41] => s-20vcpu-96gb
                    [42] => 48gb
                    [43] => gd-16vcpu-64gb
                    [44] => m6-8vcpu-64gb
                    [45] => m-128gb
                    [46] => s-24vcpu-128gb
                    [47] => 64gb
                    [48] => s-32vcpu-192gb
                    [49] => m-224gb
                )

        )

    [tags] => Array
        (
            [0] => dolphin
        )

)
```

## Creating a New Droplet

Creates a new droplet using default options from your config file, but you can override any of the API query parameters.
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

## Destroying a Droplet
You can obtain the ID of a Droplet by running `droplet list` to list all your droplets.

```
dolphin droplet destroy id=DROPLET_ID
```


You can destroy multiple droplets by providing a list of IDs separated by commas:

```
dolphin droplet destroy id=DROPLET_ID,DROPLET2_ID,DROPLET3_ID
```

