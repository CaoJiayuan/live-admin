<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\MaskingWord
 *
 * @property int $id
 * @property int $room_id 所属房间id
 * @property string $word
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\MaskingWord whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\MaskingWord whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\MaskingWord whereRoomId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\MaskingWord whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\MaskingWord whereWord($value)
 * @mixin \Eloquent
 */
class MaskingWord extends Model
{

  protected $fillable = [
    'room_id','word'
  ];
}
