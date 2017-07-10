<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\GiftCategory
 *
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\GiftCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\GiftCategory whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\GiftCategory whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\GiftCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class GiftCategory extends Model
{
  protected $fillable = [
    'name',
    'room_id'
  ];
}
