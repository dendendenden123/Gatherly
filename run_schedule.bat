@echo off
cd C:\xampp\htdocs\gatherly
C:\xampp\php\php.exe artisan schedule:run >> NUL 2>&1
