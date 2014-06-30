<?php

namespace Mastop\Facebook;

class Facebook extends \Facebook\FacebookRedirectLoginHelper
{
    /**
     * @var string Prefix to use for session variables
     */
    private $sessionPrefix = 'FBRLH_';

    /**
     * @var string State token for CSRF validation
     */
    protected $state;

    /**
     * @var boolean Toggle for PHP session status check
     */
    protected $checkForSessionStatus = true;

    public function __construct()
    {
        \FacebookSession::setDefaultApplication(\Configuration::get('fb_app'), \Configuration::get('fb_secret'));
        parent::__construct(route('login.facebook'));
    }


  /**
   * Stores a state string in session storage for CSRF protection.
   * Developers should subclass and override this method if they want to store
   *   this state in a different location.
   *
   * @param string $state
   *
   * @throws FacebookSDKException
   */
  protected function storeState($state)
  {
    if ($this->checkForSessionStatus === true
      && session_status() !== PHP_SESSION_ACTIVE) {
      throw new FacebookSDKException(
        'Session not active, could not store state.', 720
      );
    }
      \Session::put($this->sessionPrefix . 'state', $state);
  }

  /**
   * Loads a state string from session storage for CSRF validation.  May return
   *   null if no object exists.  Developers should subclass and override this
   *   method if they want to load the state from a different location.
   *
   * @return string|null
   *
   * @throws FacebookSDKException
   */
  protected function loadState()
  {
    if ($this->checkForSessionStatus === true
      && session_status() !== PHP_SESSION_ACTIVE) {
      throw new FacebookSDKException(
        'Session not active, could not load state.', 721
      );
    }
    if (\Session::has($this->sessionPrefix . 'state')) {
      $this->state = \Session::get($this->sessionPrefix . 'state');
      return $this->state;
    }
    return null;
  }
}
