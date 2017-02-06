# -*- mode: ruby -*-
# vi: set ft=ruby :

require_relative 'vagrantconfig.rb'
include VagrantConfig

Vagrant.configure("2") do |config|
  # The most common configuration options are documented and commented below.
  # For a complete reference, please see the online documentation at
  # https://docs.vagrantup.com.
  config.vm.box = "ubuntu/trusty64"

  config.vm.synced_folder "src/", "/var/www/html/magicdb"

  config.vm.network "forwarded_port", guest: 80, host: 8080
  config.vm.network "forwarded_port", guest: 3306, host: 3306

  config.vm.provision "shell", inline: <<-SHELL
    apt-get update
    apt-get install -y apache2
    DEBIAN_FRONTEND=noninteractive apt-get install -y mysql-server php5-mysql
    mysql_install_db
    apt-get install -y php5 libapache2-mod-php5 php5-mcrypt php5-cli
    echo '<?php phpinfo(); ?>' | tee /var/www/html/info.php
  SHELL

  config.vm.provision "shell" do |s|
    s.path = "mysql_secure.sh"
    s.args = DB_PASS
  end
end