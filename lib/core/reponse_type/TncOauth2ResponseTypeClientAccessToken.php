<?php
/**
 * TncOauth2ResponseTypeClientAccessToken.php
 *
 * @author The NetCircle
 */
class TncOauth2ResponseTypeClientAccessToken extends TncOauth2ResponseTypeAccessToken
{
  public function createAccessToken($client_id, $user_id, $scope = null, $includeRefreshToken = true)
  {

    $token = parent::createAccessToken($client_id, $user_id, $scope, false);

    return array('access_token' => $token['access_token']);
  }
}
