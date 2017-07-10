<?php

namespace App\Entity;

/**
 * App\Entity\Meta
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $key
 * @property string $value
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Meta whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Meta whereKey($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Meta whereValue($value)
 * @property int $room_id 所属房间id
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Meta whereRoomId($value)
 */
class Meta extends KeyValue
{

  public static $roomId = 0;

  public $timestamps = false;

  protected $fillable = [
    'key', 'value', 'room_id',
  ];

  public static function getConvertedData()
  {
    $all = static::where('room_id', static::$roomId)->get();

    $data = [];
    foreach ($all as $item) {
      $data[$item->key] = $item->value;
    }

    return $data;
  }


  public static function store($key, $value = null)
  {
    if (is_array($key)) {
      foreach ($key as $k => $item) {
        if (!is_numeric($k)) {
          self::put($k, $item);
        }
      }
    } else if (!is_numeric($key) && $value !== null) {
      static::put($key, $value);
    }
  }

  public static function put($key, $value)
  {
    $attr = [
      'key'     => $key,
      'value'   => $value,
      'room_id' => static::$roomId,
    ];
    return static::updateOrCreate([
      'key'     => $key,
      'room_id' => static::$roomId,
    ], $attr);
  }
}
