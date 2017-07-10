<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\VoteOption
 *
 * @property int $id
 * @property int $vote_id 所属投票id
 * @property string $name
 * @property int $modify 加减投票数
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\VoteOption whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\VoteOption whereModify($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\VoteOption whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\VoteOption whereVoteId($value)
 * @mixin \Eloquent
 */
class VoteOption extends Model
{
  public $timestamps = false;
  protected $fillable = [
    'vote_id',
    'name',
    'modify',
  ];
}
