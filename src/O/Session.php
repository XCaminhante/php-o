<?php namespace O;
#@+leo-ver=5-thin
#@+node:caminhante.20211024200632.3: * @file Session.php
#@@first
#@@language plain
#@+others
#@+node:caminhante.20231020172633.1: ** function session_start

/**
 * secure session_start function (overrides built-in)
 */
function session_start () {
  // verify that session settings are secure
  if (session_id()) {
    if (ini_get("session.auto_start")) {
      throw new \Exception("disable session.auto_start in php.ini");
    } else {
      throw new \Exception("session must be opened after loading O.php");
    }
  } else {
    // javascript shouldn't be able to see the session cookie
    ini_set("session.cookie_httponly", "1");
    // url's should never contain session id's
    ini_set("session.use_trans_sid", "0");
    ini_set("session.use_only_cookies", "1");
    if (!empty($_SERVER["HTTPS"])) {
      // a good idea to set this in php.ini
      ini_set("session.cookie_secure", "1");
    };
    // security by obscurity, but there's no downside here
    session_name("OSID");
  };
  // native code
  \session_start();
  // rotate session id on first request in session
  if (!isset($_SESSION["__O_SESSION_VALIDATED"])) {
    session_regenerate_id(true);
    $_SESSION["__O_SESSION_VALIDATED"] = TRUE;
  };
  // generate an anti-CSRF token
  if (!isset($_SESSION["__O_ANTI_CSRF_TOKEN"])) {
    $_SESSION["__O_ANTI_CSRF_TOKEN"] = md5(uniqid());
  };
};
// obtain the anti-CSRF token
function get_csrf_token () {
  if (!session_id()) { session_start(); }
  return $_SESSION["__O_ANTI_CSRF_TOKEN"];
};
#@+node:caminhante.20231020172644.1: ** function is_csrf_protected
// check that CSRF token was given
function is_csrf_protected ($token = "") {
  if (empty($token) && isset($_REQUEST["csrftoken"])) {
    $token = $_REQUEST["csrftoken"];
  };
  return $token === get_csrf_token();
};
#@+node:caminhante.20231020172653.1: ** class Session
class Session {
#@+others
#@+node:caminhante.20231020172717.1: *3* function __construct
function __construct () {
  if (!session_id()) { session_start(); }
}
#@+node:caminhante.20231020172721.1: *3* function getCSRFToken
function getCSRFToken () {
  return get_csrf_token();
}
#@+node:caminhante.20231020172724.1: *3* function isCSRFProtected
function isCSRFProtected ($token = "") {
  return is_csrf_protected($token);
}
#@+node:caminhante.20231020172727.1: *3* function __get
function &__get ($prop) {
  if (isset($_SESSION[$prop])) {
    return $_SESSION[$prop];
  } else {
    $null = NULL;
    return $null; // must return reference to variable
  }
}
#@+node:caminhante.20231020172731.1: *3* function __set
function __set ($prop, $value) {
  return $_SESSION[$prop] = $value;
}
#@+node:caminhante.20231020172734.1: *3* function __isset
function __isset ($prop) {
  return isset($_SESSION[$prop]);
}
#@+node:caminhante.20231020172737.1: *3* function __unset
function __unset ($prop) {
  unset($_SESSION[$prop]);
}
#@-others
}
#@-others
#@-leo
