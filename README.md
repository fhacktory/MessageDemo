MessageDemo
===========

Hackathon repository including an instant messaging bundle for Symfony2.

## Development environment configuration example

Example with Apache2.

#### Add this to */etc/hosts*

    127.0.0.1	fhacktory.dev
    127.0.0.1	fhacktory.prod

#### Memcached installation

    sudo apt-get install zlibc php-pear php5-memcache memcached
    sudo pecl install memcache
    sudo service apache2 restart
    memcached -u memcached -d -m 30 -l 127.0.0.1 -p 11211

Check the installation :

    echo "extension=memcache.so" | sudo tee /etc/php5/apache2/conf.d/20-memcache.ini
    ps aux | grep memcache

#### NodeJS and Less installation

    apt-get update
    apt-get install nodejs npm
    npm install -g less
    ln -s /usr/bin/nodejs /usr/local/bin/node
    
#### Install and configure the project

    cd ~/www
    git clone https://github.com/fhacktory/MessageDemo.git
    cd MessageDemo
    composer install
    ln -s . /var/www/MessageDemo
    cp app/Resources/doc/conf-example/MessageDemo.conf /etc/apache2/sites-available/MessageDemo.conf
    a2ensite MessageDemo.conf
    service apache2 reload

#### Check the Symfony2 configuration

[http://fhacktory.dev/config.php](http://fhacktory.dev/config.php)

#### Load the fixtures

    php app/console doctrine:fixtures:load

