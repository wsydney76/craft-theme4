@echo off
composer install --no-dev &&^
php temp-init.php &&^
php craft install --interactive=0 --username=admin --password=password  --email=admin@example.com  &&^
php craft migrate/all --interactive=0 --no-backup &&^
php craft main/init &&^
php craft main/seed/seed-content
