# Component POC XXX
Some usage with [XXX](url).

> todo: Library description.

## Prerequisite
* PHP 8.4 (v1.0)

## Install
`composer install`

Or you can add this poc like a dependency, in this case edit your [composer.json](https://getcomposer.org) (launch `composer update` after edit):
```json
{
	"repositories": [
		{ "type": "git", "url": "https://github.com/jgauthi/poc_XXX.git" }
	],
	"require": {
		"jgauthi/poc_XXX": "1.*"
	}
}
```

## Usage
You can test with php internal server and go to url <http://localhost:8000>:

```shell script
php -S localhost:8000 -t public
```


## Documentation
You can look at [folder public](public).