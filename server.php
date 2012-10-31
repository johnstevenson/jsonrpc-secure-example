<?php

  ini_set('default_charset', 'UTF-8');

  # we don't want any PHP errors being output
  ini_set('display_errors', '0');

  # so we will log them. Exceptions will be logged as well
  ini_set('log_errors', '1');
  ini_set('error_log', 'server-errors.log');


  # this will fail if you have not installed the required packages via Composer
  require('vendor/autoload.php');

  # set up our method handler class
  $methods = new ServerMethods();

  # create our server object, passing it the method handler class
  $Server = new JsonRpc\Secure\Server($methods, 'authorize');

  # and tell the server to do its stuff
  $Server->receive();


function authorize(AuthKey\Secure\Server $Server)
{

  /*
    The client's accountId is in $Server->accountId.

    On success set $Server->accountKey to the client's accountKey and return true.

    On error return either an array containing the error message:

      $res = array(
        'errorResponse' => 400,
        'errorMsg' => 'resource not found',
        'errorCode' => 'InvalidRequest'
        ... plus any addition info
      );

    or null/false, which will create a default error message:

      $res = array(
        'errorResponse' => 403,
        'errorMsg' => 'The AccountId you provided does not exist in our records',
        'errorCode' => 'InvalidAccountId',
      );

  */

  $res = false;

  if ($Server->accountId === 'client-demo')
  {
    $Server->accountKey = 'U7ZPJyFAX8Gr3Hm2DFrSQy3x1I3nLdNT2U1c+ToE5Vk=';
    $res = true;
  }

  return $res;

}


/**
* Our methods class
*/
class ServerMethods
{

  public $error = null;


  public function divide($dividend, $divisor, $int = false)
  {

    if (!$divisor)
    {
      $this->error = 'Cannot divide by zero';
    }
    else
    {
      $quotient = $dividend / $divisor;
      return $int ? (int) $quotient : $quotient;
    }

  }

}