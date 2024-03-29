# -*- mode: ruby -*-
# vi: set ft=ruby :

require_relative 'vagrantconfig.rb'
include VagrantConfig

Vagrant.configure("2") do |config|
  # The most common configuration options are documented and commented below.
  # For a complete reference, please see the online documentation at
  # https://docs.vagrantup.com.
  config.vm.box = "ubuntu/trusty64"

  config.vm.synced_folder "src/", "/var/www/html/magic"

  config.vm.network "forwarded_port", guest: 80, host: 8080
  config.vm.network "forwarded_port", guest: 3306, host: 3306

  # install server software
  config.vm.provision "shell", inline: <<-SHELL
    apt-get update
    apt-get install -y apache2
    DEBIAN_FRONTEND=noninteractive apt-get install -y mysql-server php5-mysql
    mysql_install_db
    apt-get install -y php5 libapache2-mod-php5 php5-mcrypt php5-cli php5-curl
    echo '<?php phpinfo(); ?>' | tee /var/www/html/info.php
    echo 'ServerName localhost' | tee /etc/apache2/conf-available/servername.conf
    a2enconf servername
    service apache2 restart
  SHELL

  # secure mysql installation
  config.vm.provision "shell" do |s|
    s.path = "mysql_secure.sh"
    s.args = DB_PASS
  end

  # initalize database
  config.vm.provision "file", source: "magicdb_init.sql", destination: "/home/vagrant/magicdb_init.sql"
  config.vm.provision "shell", inline: "mysql -uroot -p#{DB_PASS} < /home/vagrant/magicdb_init.sql"
  config.vm.provision "shell", inline: <<-SHELL
    rm /home/vagrant/magicdb_init.sql
    sed -i '/bind-address/c\#bind-address=127.0.0.1' /etc/mysql/my.cnf
    service mysql restart
  SHELL
end