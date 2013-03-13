<?php
/**
 * TncOauth2ResponseTypeAccessToken.php
 *
 * @author The NetCircle
 */
class TncOauth2ResponseTypeAccessToken extends OAuth2_ResponseType_AccessToken
{
  public function createAccessToken($client_id, $user_id, $scope = null, $includeRefreshToken = true)
  {
    if (null != $user_id) {
      $token['user_id'] = $user_id;
      $token = array_merge($token, parent::createAccessToken($client_id, $user_id, $scope, $includeRefreshToken));
    } else {
      $token = parent::createAccessToken($client_id, $user_id, $scope, $includeRefreshToken);
    }

    return $token;
  }
}
