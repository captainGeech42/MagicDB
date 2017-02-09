#!/bin/bash
rsync -e 'ssh -i ./.vagrant/machines/default/virtualbox/private_key -p 2222' -Pruv --delete ./src/* vagrant@127.0.0.1:/var/www/html/magic/