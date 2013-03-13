<?php
/**
 * TncOauth2SecurityFilter.php
 *
 * @author The NetCircle
 */
class TncOauth2SecurityFilter extends sfFilter
{
  public function execute($filterChain)
  {
    $actionInstance = $this->context->getController()->getActionStack()->getLastEntry()->getActionInstance();
    $request  =  $this->context->getRequest();

    if ($actionInstance->getModuleName() != 'oauth' && $actionInstance->getActionName() != 'accessToken') {

      $server = new TncOauth2Server();

      if (! $server->verifyAccessRequest()) {
        throw new TncOauth2Exception($server->getError());
      }

      $request->setParameter('oauth_access_token', $server->getAccessTokenData());

    }

    $filterChain->execute();
  }
}
