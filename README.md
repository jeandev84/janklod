# Welcome to Janklod Framework 
(Janklod framework used for building web application)

1. Clone the project 
```markdown
git clone https://github.com/jeandev84/janklod.git
```

2. Install package dependencies
```markdown
composer install or composer update -v
```

3. Configure database
```markdown
In file /config/database.php
-------------------------------------
'driver'   => 'mysql',
'host'     => '127.0.0.1',
'database' => 'ecommerce',
'username' => 'root',
'password' => 'secret',
'options'  => [],
'charset'  => 'utf8',
'prefix'   => ''

OR .env
---------------------------------
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_NAME=homestand
DB_USER=root
DB_PASS=secret
DB_PORT=3306
```


4. Lunch Server
```markdown
php -S localhost:(YOUR_PORT) -t public -d display_errors=1

Example run server on port (8000) : 
php -S localhost:8000 -t public -d display_errors=1

5 . Mail Jet
https://app.mailjet.com/auth/get_started/developer
https://app.mailjet.com/dashboard
```

6. Mysql solve Ubuntu (Access Denied for user rootlocalhost)
```markdown 
1. sudo mysql -u root -p
2. USE mysql;
3. UPDATE user SET plugin='mysql_native_password' WHERE User='root';
4. FLUSH PRIVILEGES;
5. exit;
6. service mysql restart
```

7. Git repository
```
echo "# janklod" >> README.md
git init
git add README.md
git commit -m "first commit"
git branch -M main
git remote add origin https://github.com/jeandev84/janklod.git
git push -u origin main
```
8. PHP install 7.2
```
21

Follow the steps described below

1: add the PPA maintained by Ondrej Surý
 
  sudo add-apt-repository ppa:ondrej/php
  
2: update the system

  sudo apt update
  
3: install PHP versions 7.2

  sudo apt install php7.2

4: Select the standard version of PHP

  sudo update-alternatives --set php /usr/bin/php7.2
  
5: Disable version 7.4 or the one you are using

  sudo a2dismod php7.4

6: enable version 7.2

  sudo a2enmod php7.2
  
7: Restart the apache server

  sudo systemctl restart apache2

---------------------------------------------
https://askubuntu.com/questions/1230869/cant-install-php-7-2-on-ubuntu-20-04
$ sudo su
$ cp /etc/apt/sources.list /etc/apt/sources.list.bkp
$ echo "deb http://ppa.launchpad.net/ondrej/php/ubuntu eoan main" >> $ /etc/apt/sources.list
$ apt update
$ apt install php7.2 php-pear php7.2-gd php7.2-dev  php7.2-zip php7.2-mbstring php7.2-mysql php7.2-xml php7.2-curl
$ exit

---------------------------------------------
https://askubuntu.com/questions/999999/php-with-pdo-mysql-in-ubuntu-16-04
https://www.vultr.com/docs/configure-php-7-2-on-ubuntu-18-04
```