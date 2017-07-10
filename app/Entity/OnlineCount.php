<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\OnlineCount
 *
 * @property int $id
 * @property string $date
 * @property int $num
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\OnlineCount whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\OnlineCount whereDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\OnlineCount whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\OnlineCount whereNum($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\OnlineCount whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $time
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\OnlineCount whereTime($value)
 */
class OnlineCount extends Model
{
  protected $fillable = [
    'date', 'num','time'
  ];
}
