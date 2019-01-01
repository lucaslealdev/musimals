<?php
define('TIMEZONE','America/Sao_Paulo');
define('TEMA','disco');

/* BLESS THE ELEPHANT
                          _
                        .' `'.__
                       /      \ `'"-,
      .-''''--...__..-/ .     |      \
    .'               ; :'     '.  a   |
   /                 | :.       \     =\
  ;                   \':.      /  ,-.__;.-;`
 /|     .              '--._   /-.7`._..-;`
; |       '                |`-'      \  =|
|/\        .   -' /     /  ;         |  =/
(( ;.       ,_  .:|     | /     /\   | =|
 ) / `\     | `""`;     / |    | /   / =/
   | ::|    |      \    \ \    \ `--' =/
  /  '/\    /       )    |/     `-...-`
 /    | |  `\    /-'    /;
 \  ,,/ |    \   D    .'  \
  `""`   \  nnh  D_.-'L__nnh
*/
function windows_utf8_decode($str){
  if (stripos(PHP_OS, 'WIN') === 0){
    return utf8_decode($str);
  }else{
    return $str;
  }
}
function windows_utf8_encode($str){
  if (stripos(PHP_OS, 'WIN') === 0){
    return utf8_encode($str);
  }else{
    return $str;
  }
}
function dirToArray($dir) {
  $result = array();
  $cdir = scandir($dir);
  foreach ($cdir as $key => $value){
    if (!in_array($value,array(".",".."))){
      if (is_dir($dir . DIRECTORY_SEPARATOR . $value)){
        $result[$value] = dirToArray($dir . DIRECTORY_SEPARATOR . $value);
      }else{
        if (substr($value, -4)=='.mp3') $result[] = $value;
      }
    }
  }
  return $result;
}
function siteURL(){
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $domainName = $_SERVER['HTTP_HOST'];
    return $protocol.$domainName;
}
define('HOST_DOMAIN',siteURL());
date_default_timezone_set(TIMEZONE);