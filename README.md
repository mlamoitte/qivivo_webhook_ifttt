# Qivivo API - WebHook, IFTTT

Simple Qivivo API to controle temperature using your voice via IFTTT and google assistant / amazon


### Prerequisites

You need to install these on your server
(List of instructions for ubuntu 16.04)


##### PHP 7.1.3+
```
sudo apt-get install software-properties-common
sudo add-apt-repository ppa:ondrej/php
sudo apt-get update
sudo apt-get install php7.2
sudo apt-get install php-pear php7.2-curl php7.2-dev php7.2-gd php7.2-mbstring php7.2-zip php7.2-mysql php7.2-xml
```

##### Apache

```
sudo apt-get install apache2
```

##### Git
```
sudo apt-get install git
```

##### Composer
https://getcomposer.org/download/

## Getting Started

Clone the project into your apache project directory
```
cd /var/www/ && git clone https://github.com/mlamoitte/qivivo_webhook_ifttt.git qivivo
```

Install dependencies
```
cd /var/www/qivivo/ && composer install
```

### Configuration

##### Copy the .env.test file to .env
```
cp /var/www/qivivo/.env.test /var/www/qivivo/.env 
```

##### Adapt to your need

```
APP_ENV=prod
...
...
API_KEY="YOU_HAVE_TO_GENERATE_ONE"
QIVIVO_USER="YOUR_QIVIVO_ACCOUNT_LOGIN"
QIVIVO_PASSWORD="YOUR_QIVIVO_ACCOUNT_PASSWORD"
```

If you want to generate an api_key easily you can go to
https://codepen.io/corenominal/pen/rxOmMJ

#### Creating vHost
```
sudo nano /etc/apache2/sites-available/qivivo.conf
```

Paste these lines
```
<VirtualHost *:80>
    ServerName XXXXXXXX
    ServerAdmin YYYYYYYY
    DocumentRoot /var/www/qivivo/public/
    ErrorLog /var/log/apache2/virtual.host.error.log
    CustomLog /var/log/apache2/virtual.host.access.log combined
    LogLevel warn
</VirtualHost>
```

Adapt to your need
```
XXXXXXXX = yourndd.com
YYYYYYYY = your@email.com
```

Activate the vHost
```
sudo a2ensite qivivo.conf
```

restart apache2
```
sudo service apache2 restart
```

## That's it !

You can now post request to yourndd.com/api/qivivo/setTemperature with inside body request
```
api_key=YOURAPIKEY&temp=WANTEDTEMPERATURE
```

NB: By default **all others urls** from yourndd.com will return **403 forbiden**
**only /api/qivivo/setTemperature will return a 200** ok only below parameters

## Test it !
```
curl -X POST \
  https://yourndd.com/api/qivivo/setTemperature \
  -H 'Content-Type: application/x-www-form-urlencoded' \
  -H 'cache-control: no-cache' \
  -d 'api_key=YOURAPIKEY&temp=20'
  ```
  
## Going further
I really recommended you to **enable https** to your domain for **security improvement**.

Link for ubuntu 16.04

https://certbot.eff.org/lets-encrypt/ubuntuxenial-apache

Other

https://certbot.eff.org/

# Examples

## GOOGLE HOME / ASSISTANT

* Create an account to
    * https://ifttt.com
* Create an applet
    * https://ifttt.com/create
        * In this section
         ```
         select google assistant
         -> Say a phrase with a number
         --> Fill the required field with your needs 
         Ex: Put heating to #
         ```
         * In That section
         ```
         select webHook
           -> Make a web request
           URL
             https://yourndd.com/api/qivivo/setTemperature
           Method
             POST
           Content type
             application/x-www-form-urlencoded
           Body
             api_key=YOURAPIKEY&temp={{NumberField}}
         ```
         
## AMAZON ALEXA
Same operation than before except replacing google assistant by amazon alexa
