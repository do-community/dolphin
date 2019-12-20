# Deployer

The `deployer` commands use Ansible to execute automation scripts on your droplets. Playbooks are not included with Dolphin, 
but you can use our [ansible-playbooks](https://github.com/do-community/ansible-playbooks) repository to get started and create your own playbooks. 

## Listing Playbooks

Run the `list` command to see the available playbooks:

```
./dolphin deployer list
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

## Running a Playbook with Deployer

Playbooks should be located in a folder specified in your `config.php` file. This is set to `var/playbooks` by default. 
The `playbooks` folder should have a format similar to this:

```
playbooks/
  - setup_ubuntu/
    - playbook.yml
  - lamp/
    - playbook.yml
```

To run a playbook on a droplet, use:

```
dolphin deployer run [playbook] on [target]
```

## Using the Community Playbooks
To use the community playbooks from our [ansible-playbooks](https://github.com/do-community/ansible-playbooks) repository, clone that repo into the `var/playbooks` folder:

```
cd var/playbooks
git clone https://github.com/do-community/ansible-playbooks.git community-playbooks
```

Then, adjust the `playbooks_path` setting inside your `config.php` file to point to the cloned repository folder:

```
'playbooks_path' => __DIR__ . '/var/playbooks/community-playbooks',
```




### Example Worfklow for Deploying a new Wordpress on LAMP

Setting up a new WordPress(LAMP) server based on the community playbooks would require a workflow like the following:

1. Adjust the playbook settings for both the `setup_ubuntu1804` and the `wordpress_ubuntu1804` playbooks by editing their respective `vars/default.yml` variable files.
1. Create a new server with `dolphin droplet create`. Copy the server name.
2. Run the Initial Server Setup as root (considering you've set up your SSH key in your `config.php` file): `dolphin deployer run setup_ubuntu1804 server-name user=root`
3. Run the Wordpress on LAMP playbook: `dolphin deployer run wordpress-lamp_ubuntu1804 server-name` 

Please notice each playbook run might take several minutes to complete.


Run `dolphin droplet list` to obtain the server IP. Access it from your browser and you should see the WP setup page.
