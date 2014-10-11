MessageDemo
===========

Hackathon repository including an instant messaging bundle for Symfony2.

# Development environment configuration example

Add this to */etc/hosts* :

    127.0.0.1	fhacktory.dev
    127.0.0.1	fhacktory.prod
    
Install and configure the project :

    cd ~/www
    git clone https://github.com/fhacktory/MessageDemo.git
    cd MessageDemo
    composer install
    ln -s . /var/www/MessageDemo
    cp app/Resources/doc/conf-example/MessageDemo.conf /etc/apache2/sites-available/MessageDemo.conf
    a2ensite MessageDemo.conf
    service apache2 reload

Check the Symfony2 configuration : [http://fhacktory.dev/config.php](http://fhacktory.dev/config.php).
