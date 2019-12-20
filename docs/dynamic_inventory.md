## Using the Dynamic Inventory with Ansible

The included `hosts.php` script works as a dynamic inventory script that can be used directly with Ansible commands.

```
ansible all -m ping -i hosts.php -u root
```

```
ansible-playbook -l server-name -i hosts.php playbooks/setup_ubuntu1804/playbook.yml -u root
```