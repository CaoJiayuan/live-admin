<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-5-5
 * Time: 下午3:02
 */

namespace App\Entity;


use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\KeyValue
 *
 * @mixin \Eloquent
 */
class KeyValue extends Model
{
  public $timestamps = false;

  public static $items = [];

  public static function getItem($key, $default = null)
  {
    if (!static::$items) {
      static::$items = static::getConvertedData();
    }
    if (is_array($key)) {
      $result = [];
      foreach ($key as $k => $def) {
        if (is_numeric($k)) {
          $result[$def] = array_get(static::$items, $def);
        } else {
          $result[$k] = array_get(static::$items, $k, $def);
        }
      }

      return $result;
    }

    return array_get(static::$items, $key, $default);
  }

  public static function getConvertedData()
  {
    $all = static::all();

    $data = [];
    foreach ($all as $item) {
      $data[$item->key] = $item->value;
    }

    return $data;
  }
}