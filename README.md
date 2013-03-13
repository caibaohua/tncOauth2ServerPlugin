# tncOauth2SeverPlugin

tncOauth2SeverPlugin is the plugin of symfony 1.2. It helps to setup OAuth2 server in PHP.

## Requirements
* It need install oauth2-server-php, see https://github.com/bshaffer/oauth2-server-php.
* symfony 1.2

## Installaiton
* Update your database tables by starting from scratch (it will delete all the existing tables, then re-create them):
```php
symfony propel:build-sql
symfony propel:insert-sql
```
* Clear cache
```php
symfony cc
```

* Add the "Oauth Filter" filter to filters.yml above the security filter
```php
oauth_filter:
  class: TncOauth2SecurityFilter
  file:  %SF_PLUGINS_DIR%/tncOauth2ServerPlugin/lib/filter/TncOauth2SecurityFilter.php
  param:
    type: oauth
```

## Documentation

### Secure an action

It's easy to secure some actions with OAuth2 after you create the 'oauth_filter' filter, you just need to create app/*/config/oauth.yml or modules/*/config/oauth.yml.


```php
homepage:
  is_secure: on

all:
  is_secure: off
```

Once set is_secure on for homepage action, the action have check whether the access_token from request is valid or not.

### Grant access token

```php
$server = new TncOauth2Server();

/** @var $token array **/ 
if (! $token = $server->grantAccessToken()) {
  $errMsg = $server->getError();
  throw new TncOauth2Exception($errMsg);
}
return $this->renderText(json_encode($token));
```

## TODO
* Add admin modules for mangment
* Add cache
* Create more features