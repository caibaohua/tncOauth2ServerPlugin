<?php

class OauthClientsPeer extends BaseOauthClientsPeer
{
  public static function checkClientCredentials($client_id, $client_secret)
  {
    $client = OauthClientsPeer::retrieveByPK($client_id);

    if (!$client)
      return false;

    return $client->getClientSecret() ==  $client_secret;
  }

}
