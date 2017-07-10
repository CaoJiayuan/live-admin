<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-4-25
 * Time: 下午3:52
 */

if (!function_exists('is_local')) {
  function is_local()
  {
    return env('APP_ENV') == 'local';
  }
}

if (!function_exists('array_remove_empty')) {
  function array_remove_empty($array, $remove = ['', null])
  {
    $removed = [];
    foreach ((array)$array as $key => $item) {
      if (!in_array($item, $remove)) {
        $removed[$key] = $item;
      }
    }
    return $removed;
  }
}

if (!function_exists('get_form_param')) {
  function get_form_param($key, $model = null, $default = null)
  {
    $value = old($key, $default);
    $model && $value = array_get($model, $key, $default);
    return $value;
  }
}

if (!function_exists('advanced_strtotime')) {
  function advanced_strtotime($str, $now = null)
  {
    $now || $now = time();
    $time = strtotime($str, $now);

    if ($time <= 0 || !$time) {
      $time = strtotime($str, strtotime($now));
    }

    return $time;
  }
}