@echo off
php craft install --interactive=0 --username=admin --password=password  --email=admin@example.com  &&^
php craft migrate/up --interactive=0 &&^
php craft index-assets/one images &&^
php craft main/seed/create-entries
