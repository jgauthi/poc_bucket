# Poc Bucket
This is a proof of concept for bucket pattern implementation in PHP.

## Prerequisite
* PHP 8.4 (v1.0)

## Install
```shell
cp example-config.inc.php config.inc.php
# Edit config.inc.php to set your parameters

composer install
```

Install the credential from Google cloud bucket in the root folder as `credentials.json`.


## Usage
You can test with php internal server and go to url <http://localhost:8000>:

```shell script
php -S localhost:8000 -t public
```
