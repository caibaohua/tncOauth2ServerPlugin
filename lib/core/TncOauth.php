<?php
/**
 *
 * @author  The NetCircle
 * @version TncOauth.php created_at: 13-3-11 - caibaohua
 */
class TncOauth
{
  public $oauth = array();
  protected $actionName;
  protected $context;


  /**
   *
   * @param sfContext $context    The current application context.
   * @param string    $moduleName The module name.
   * @param string    $actionName The action name.
   */
  public function __construct($context, $moduleName, $actionName)
  {
    $this->context    = $context;
    $this->actionName = $actionName;

    // include security configuration
    if ($file = $context->getConfigCache()->checkConfig('modules/' . $moduleName . '/config/oauth.yml', true)) {
      require($file);
    }
  }

  /**
   * Returns the oauth configuration for this module.
   *
   * @return string Current aouth configuration as an array
   */

  public function getOauthConfiguration()
  {
    return $this->oauth;
  }

  /**
   * Overrides the current oauth configuration for this module.
   *
   * @param array $oauth The new security configuration
   */
  public function setOauthConfiguration($oauth)
  {
    $this->oauth = $oauth;
  }

  /**
   * Returns a value from oauth.yml.
   *
   * @param string $name    The name of the value to pull from oauth.yml
   * @param mixed  $default The default value to return if none is found in oauth.yml
   *
   * @return mixed
   */
  public function getOauthValue($name, $default = null)
  {
    $actionName = strtolower($this->actionName);

    if (isset($this->oauth[$actionName][$name])) {
      return $this->oauth[$actionName][$name];
    }

    if (isset($this->oauth['all'][$name])) {
      return $this->oauth['all'][$name];
    }

    return $default;
  }

  /**
   * Indicates that this action requires oauth authentification.
   *
   * @return bool true, if this action requires oauth authentification, otherwise false.
   */
  public function isOauthSecure()
  {
    return $this->getOauthValue('is_secure', false);
  }
}
