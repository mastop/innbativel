<?php

class FileMime {

  public static function get($extension, $default = 'application/octet-stream')
  {
    $mimes = Config::get('mimes');

    if ( ! array_key_exists($extension, $mimes)) return $default;
    return (is_array($mimes[$extension])) ? $mimes[$extension][0] : $mimes[$extension];
  }

}