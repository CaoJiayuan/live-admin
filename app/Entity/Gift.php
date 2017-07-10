<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\Gift
 *
 * @property int $id
 * @property string $name
 * @property int $credits
 * @property string $img
 * @property int $gift_category_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Gift whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Gift whereCredits($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Gift whereGiftCategoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Gift whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Gift whereImg($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Gift whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Gift whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Gift extends Model
{
  protected $fillable = [
    'name',
    'credits',
    'img',
    'gift_category_id',
    'room_id'
  ];
}
