<?php

require_once(dirname(__FILE__) . '/../vendor/OAuth2/Autoloader.php');

OAuth2_Autoloader::register();

/**
 * TncOauth2Server.php
 *
 * @author The NetCircle
 */
class TncOauth2Server
{
  public function __construct()
  {

    $this->config = sfConfig::get('app_oauth2_server_config');


    $this->storage = new TncOauth2StoragePdo($this->config);

    $this->request = OAuth2_Request::createFromGlobals();

    $this->grantTypes = array(
      'password' => new TncOauth2GrantTypeUserCredentials($this->storage),
      'client_credentials' => new TncOauth2GrantTypeClientCredentials(),
      'refresh_token' => new TncOauth2GrantTypeRefreshToken($this->storage,  $this->config),
      'authorization_code' => new TncOauth2GrantTypeUserCredentials($this->storage),
    );

    if ($this->request->request('grant_type') == 'client_credentials') {
      $this->accessTokenResponseType = new TncOauth2ResponseTypeClientAccessToken($this->storage, $this->storage, $this->config);
    } else{
      $this->accessTokenResponseType = new TncOauth2ResponseTypeAccessToken($this->storage, $this->storage, $this->config);
    }


    $this->server = new OAuth2_Server($this->storage, $this->config, $this->grantTypes, array(), $this->accessTokenResponseType);
  }

  /**
   * @return boolean
   */
  public function validateAuthorizeRequest()
  {
    if (! $check = $this->server->validateAuthorizeRequest($this->request)) {
      $params = $this->server->getResponse()->getParameters();
      $this->setError($params['error']);
    }

    return $check;
  }

  /**
   * @return boolean
   */
  public function verifyAccessRequest()
  {
    if (! $check = $this->server->verifyAccessRequest($this->request)) {
      $params = $this->server->getResponse()->getParameters();
      $this->setError($params['error']);
    }
    return $check;
  }

  /**
   * @return array
   */
  public function grantAccessToken()
  {
    if (! $token = $this->server->grantAccessToken($this->request)) {
      $params = $this->server->getResponse()->getParameters();
      $this->setError($params['error']);
    }

    return $token;
  }

  public function getAccessTokenData()
  {
    return $this->server->getAccessTokenData($this->request);
  }

  public function setError($error)
  {
    $this->error = $error;
  }

  public function getError()
  {
    return $this->error;
  }
}
