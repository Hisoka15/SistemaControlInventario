CREATE USER 'laravel'@'%' IDENTIFIED BY 'secret';
GRANT PROCESS ON *.* TO 'laravel'@'%';
FLUSH PRIVILEGES;
