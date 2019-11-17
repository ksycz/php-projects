<?php
// $_SERVER - server superglobal
  $server = [
    'Server name' => $_SERVER['SERVER_NAME'],
    'Host header' => $_SERVER['HTTP_HOST'],
    'Server software' => $_SERVER['SERVER_SOFTWARE'],
    'Document root' => $_SERVER['DOCUMENT_ROOT'],
    'Current page' => $_SERVER['PHP_SELF'],
    'Script name' => $_SERVER['SCRIPT_NAME'],
    'Absolute path' => $_SERVER['SCRIPT_FILENAME']
  ];

  $client = [
    'Client system info' => $_SERVER['HTTP_USER_AGENT'],
    'Client IP' => $_SERVER['REMOTE_ADDR'],
    'Remote port' => $_SERVER['REMOTE_PORT']
  ];
?>