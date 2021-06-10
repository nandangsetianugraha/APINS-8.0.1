<?php
function base_url($param = []) {

  $base_url = 'http://localhost:8080/apinnew/';
  $result = (!$param) ? $base_url : $base_url . $param;

  return $result;
}
function home_url($param = []) {

  $home_url = 'http://localhost:8080/apins9/';
  $result = (!$param) ? $home_url : $home_url . $param;

  return $result;
}

function strip_only_tags($str, $stripped_tags = null) {
  // Tidak ada tag yang dihapus
  if ($stripped_tags == null) {
    return $str;
  }
  // Dapatkan daftar tag
  // Misal: <b><i><u> menjadi array('b','i','u')
  $tags = explode('>', str_replace('<', '', $stripped_tags));
  $result = preg_replace('#</?(' . implode('|', $tags) . ').*?>#is', '', $str);
  return $result;
};