-- Allow connections from any host with native password authentication
ALTER USER 'uanidb'@'%' IDENTIFIED WITH mysql_native_password BY 'secret';
GRANT ALL PRIVILEGES ON uanidb.* TO 'uanidb'@'%';
FLUSH PRIVILEGES;
