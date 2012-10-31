<?php

  # this will fail if you have not installed the required packages via Composer
  require('vendor/autoload.php');

  # init demo and get the url of the server script
  $url = demoInit();


  # set up our account details
  $account = array(
    'id' => 'client-demo',
    'key' => 'U7ZPJyFAX8Gr3Hm2DFrSQy3x1I3nLdNT2U1c+ToE5Vk=',
  );

  # create our client object, passing it the server url
  $client = new JsonRpc\Secure\Client($account, $url);

  $client->setCurlOption(CURLOPT_PROXY, $proxy);

  # set up our rpc call with a method and params
  $method = 'divide';
  $params = array(42, 6);

  $success = false;

  $success = $client->call($method, $params);

  /*
  # notify
  $success = $client->notify($method);
  */


  /*
  # batch sending
  $client->batchOpen();
  $client->call($method, $params);
  $client->notify($method, $params);
  $client->call($method, $params);
  $client->notify($method, $params);
  $Client->call($method, $params);

  $success = $client->batchSend();
  */


  demoDisplay();


function demoInit()
{

  ini_set('default_charset', 'UTF-8');
  ini_set('display_errors', '1');

  # get passed in proxy - only for demo (fiddler - 127.0.0.1:8888)
  $GLOBALS['proxy'] = !empty($_POST['proxy']) ? $_POST['proxy'] : '';

  $path = dirname($_SERVER['PHP_SELF']) . '/server.php';
  $scheme = (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') ? 'https' : 'http';
  return $scheme . '://' . $_SERVER['HTTP_HOST'] . $path;

}

function demoDisplay()
{

  global $proxy, $success, $client;

  echo '<form method="POST">';
  echo '<p>';
  echo '<input type="submit" value="Run Example"> Last run: ' . date(DATE_RFC822);
  echo '</p><p>';
  echo 'Proxy:&nbsp;&nbsp;';
  echo "<input type='text' name='proxy' value='$proxy' />";
  echo '</p>';
  echo '</form>';
  echo '<pre>';

  echo '<b>return:</b> ';
  echo $success ? 'true' : 'false';
  echo '<br /><br />';

  echo '<b>result:</b> ', print_r($client->result, 1);
  echo '<br /><br />';

  echo '<b>batch:</b> ', print_r($client->batch, 1);
  echo '<br /><br />';

  echo '<b>error:</b> ', $client->error;
  echo '<br /><br />';

  echo '<b>output:</b> ', $client->output;

}
