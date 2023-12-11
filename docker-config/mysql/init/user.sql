CREATE USER IF NOT EXISTS 'innoscripta'@'%' IDENTIFIED BY 'innoscriptapass1';
GRANT ALL PRIVILEGES ON *.* TO 'innoscripta'@'%';
FLUSH PRIVILEGES;
