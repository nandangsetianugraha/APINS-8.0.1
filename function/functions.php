<?php
function base_url($param = []) {

  $base_url = 'http://localhost:8080/apinnew/';
  $result = (!$param) ? $base_url : $base_url . $param;

  return $result;
}
