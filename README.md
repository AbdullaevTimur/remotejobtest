# app.placehot.online
 
## Clone this package
Download it (clone) from .git
 
## Creating virtual machine and environment
change your `hosts` file and add the next string for ubuntu machines.
 
call
```
sudo nano /private/etc/hosts
```
 
add
```
192.168.10.16   example.com
```
 
and also change "id" and the "path" to your folder in `Homestead.yaml`, like:
```
id: 192.168.10.16,
folders:
   -
       map: /Users/timurabdullaev/Documents/Projects/remotejobtest
```
 
Then build `Homestead preset` on a new virtual machine.
```
vagrant up
```
 
## Project setup
```
npm install
composer update
```
 
### Compiles and hot-reloads for development
```
npm run watch
```
or
```
npm run hot
```
There can be issue with [displaying icons](https://github.com/ElemeFE/element/issues/15287) in `Elements UI v2.8.2`.
 
### Compiles and minifies for production
```
npm run production
```
 
### Install tables (Use DB_PORT: 33060 in .env file)
```
php artisan migrate
```
 
### Seed tables (Use DB_PORT: 33060 in .env file)
Using the next CLI command you will run DB seed process with `property-data.csv` file which located in `public` folder.
```
php artisan db:seed
```
 
### Update environment setting
Remember than to send commands to your VM by Cli, you should use ``DB_PORT: 33060`` in `.env` file.
For sending requests to API from the app, you should use ``DB_PORT: 3306`` into `.env` file.