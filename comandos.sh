apt install apache2 apache2-utils
a2enmod rewrite
apt install mariadb-server mariadb-client
apt install libapache2-mod-php php php-mysql php-cli php-pear php-gmp php-gd php-bcmath php-mbstring php-curl php-xml php-zip
systemctl restart apache2
mysql -h localhost -u deposito -p deposito_pmb < deposito.sql
