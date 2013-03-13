<?php
/**
 *
 * @author  The NetCircle
 * @version TncOAuth2StoragePdo.php created_at: 13-1-13 - caibaohua
 */
class TncOauth2StoragePdo implements OAuth2_Storage_AuthorizationCodeInterface,
                                     OAuth2_Storage_AccessTokenInterface,
                                     OAuth2_Storage_ClientCredentialsInterface,
                                     OAuth2_Storage_UserCredentialsInterface,
                                     OAuth2_Storage_RefreshTokenInterface
{
  const TYPE_FIELD_NAME = 'fieldName';


  public function __construct($config = array())
  {
    $this->config = $config;
  }

  public function getAccessToken($access_token)
  {
    if ($object = OauthAccessTokensPeer::retrieveByPK($access_token)) {
      $ret = $object->toArray(self::TYPE_FIELD_NAME);
      return array_merge($ret, array('expires' => strtotime($ret['expires'])));
    }

    return array();
  }

  public function setAccessToken($oauth_token, $client_id, $user_id, $expires,
                                 $scope = null)
  {
    if (! $object = $this->getAccessToken($oauth_token)) {
      $object = new OauthAccessTokens();
      $object->setAccessToken($oauth_token);
    }

    $object->fromArray(array(
      'client_id' => $client_id,
      'user_id'   => $user_id,
      'expires'   => date('Y-m-d H:i:s', $expires),
      'scope'     => $scope
    ), self::TYPE_FIELD_NAME);

    return $object->save();
  }

  public function getAuthorizationCode($code)
  {
    if ($object = OauthAuthorizationCodesPeer::retrieveByPK($code)) {
      $ret = $object->toArray(self::TYPE_FIELD_NAME);
      return array_merge($ret, array('expires' => strtotime($ret['expires'])));
    }

    return array();
  }

  public function setAuthorizationCode($code, $client_id, $user_id,
                                       $redirect_uri, $expires, $scope = null)
  {
    if (! $object = $this->getAuthorizationCode($code)) {
      $object = new OauthAuthorizationCodes();
      $object->setAuthorizationCode($code);
    }

    $object->fromArray(array(
      'client_id'    => $client_id,
      'user_id'      => $user_id,
      'redirect_uri' => $redirect_uri,
      'expires'      => date('Y-m-d H:i:s', $expires),
      'scope'        => $scope
    ), self::TYPE_FIELD_NAME);

    return $object->save();
  }


  public function getRefreshToken($refresh_token)
  {
    if ($object = OauthRefreshTokensPeer::retrieveByPK($refresh_token)) {
      $ret = $object->toArray(self::TYPE_FIELD_NAME);
      return array_merge($ret, array('expires' => strtotime($ret['expires'])));
    }

    return array();
  }

  public function setRefreshToken($refresh_token, $client_id, $user_id,
                                  $expires, $scope = null)
  {
    if (! $object = $this->getRefreshToken($refresh_token)) {
      $object = new OauthRefreshTokens();
      $object->setRefreshToken($refresh_token);
    }

    $object->fromArray(array(
      'client_id' => $client_id,
      'user_id'   => $user_id,
      'expires'   => date('Y-m-d H:i:s', $expires),
      'scope'     => $scope
    ), self::TYPE_FIELD_NAME);

    return $object->save();
  }


  public function checkClientCredentials($client_id, $client_secret = null)
  {
    return OauthClientsPeer::checkClientCredentials($client_id, $client_secret);
  }

  public function checkRestrictedGrantType($client_id, $grant_type)
  {
    $details = $this->getClientDetails($client_id);
    if (isset($details['grant_types'])) {
      return in_array($grant_type, (array) $details['grant_types']);
    }

    return true;
  }

  public function getClientDetails($client_id)
  {
    if ($client = OauthClientsPeer::retrieveByPK($client_id))
      return $client->toArray(self::TYPE_FIELD_NAME);

    return array();
  }

  public function unsetRefreshToken($refresh_token)
  {
    $c = new Criteria();
    $c->add(OauthRefreshTokensPeer::REFRESH_TOKEN, $refresh_token);
    return OauthRefreshTokensPeer::doDelete($c);
  }

  public function checkUserCredentials($username, $password)
  {
    if ($user = $this->getUser($username)) {
      return $this->checkPassword($user, $password);
    }
    return false;
  }

  public function getUserDetails($username)
  {
    return $this->getUser($username);
  }

  // plaintext passwords are bad!  Override this for your application
  protected function checkPassword($user, $password)
  {
    $class  = $this->config['check_user_callback']['class'];
    $method = $this->config['check_user_callback']['method'];

    $check = call_user_func(array($class, $method), $user, $password);

    if (! is_bool($check)) {
      throw new TncOauth2Exception("$class->$method must return a boolean");
    }

    return $check;
  }

  public function getUser($username)
  {
    $class  = $this->config['get_user_callback']['class'];
    $method = $this->config['get_user_callback']['method'];

    $user = call_user_func(array($class, $method), $username);

    if (empty($user)) {
      throw new TncOauth2Exception("User not found");
    }

    if (! is_array($user)) {
      throw new TncOauth2Exception("$class->$method must return an array");
    }

    if (! isset($user['user_id'])) {
      throw new TncOauth2Exception("User data must contain `user_id` column");
    }

    return $user;
  }

  /**
   * once an Authorization Code is used, it must be exipired
   *
   * @see http://tools.ietf.org/html/rfc6749#section-4.1.2
   *
   *    The client MUST NOT use the authorization code
   *    more than once.  If an authorization code is used more than
   *    once, the authorization server MUST deny the request and SHOULD
   *    revoke (when possible) all tokens previously issued based on
   *    that authorization code
   *
   */
  public function expireAuthorizationCode($code)
  {
    // TODO: Implement expireAuthorizationCode() method.
  }

  public function getUserIdByToken($access_token)
  {
    $token = $this->getAccessToken($access_token);
    return $token ? $token['user_id'] : null;
  }
}
