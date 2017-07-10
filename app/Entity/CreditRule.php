<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\CreditRule
 *
 * @property int $id
 * @property int $room_id 所属房间id
 * @property int $minutes
 * @property int $credits
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\CreditRule whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\CreditRule whereCredits($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\CreditRule whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\CreditRule whereMinutes($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\CreditRule whereRoomId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\CreditRule whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CreditRule extends Model
{

  protected $fillable = [
    'room_id',
    'minutes',
    'credits',
  ];
}
