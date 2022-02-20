@echo off
php craft install --interactive=0 --username=admin --password=password  --email=admin@example.com  &&^
php craft main/init &&^
php craft main/seed/seed-content
