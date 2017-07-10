<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\LoginCount
 *
 * @property int $id
 * @property string $date 日期
 * @property int $num
 * @property string $time
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\LoginCount whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\LoginCount whereDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\LoginCount whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\LoginCount whereNum($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\LoginCount whereTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\LoginCount whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LoginCount extends Model
{

  protected $fillable = [
    'date',
    'num',
    'time',
  ];
}
