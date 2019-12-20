# Dolphin

Dolphin is a PHP-based command line tool for managing and deploying to DigitalOcean servers, using Ansible as automation tool.

![Dolphin screenshot](https://heidislab.ams3.cdn.digitaloceanspaces.com/dolphin/screenshot.png)


## Requirements

- PHP (cli)
- Composer
- Curl
- Valid DigitalOcean API Key (R+W)
- Ansible (optional, but required by `deployer`)

It is advisable **not** to install Dolphin on a web server. This tool should only be used either on a local development environment you control (like your work machine) or a remote Linux server secured by a firewall.

For installation instructions, check the **Getting Started** section of this documentation.