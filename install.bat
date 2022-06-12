@echo off
set /P handle=Enter handle:

composer install --no-dev &&^
php setup-temp.php %handle% &&^
php craft install --interactive=0 --username=admin --password=password  --email=admin@example.com  &&^
php craft migrate/all --interactive=0 &&^
php craft main/init --interactive=0 &&^
php craft main/seed --interactive=0

