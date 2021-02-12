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

7
```
echo "# janklod" >> README.md
git init
git add README.md
git commit -m "first commit"
git branch -M main
git remote add origin https://github.com/jeandev84/janklod.git
git push -u origin main
```