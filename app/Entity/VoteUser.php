<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\VoteUser
 *
 * @property int $id
 * @property int $user_id
 * @property int $vote_id
 * @property int $vote_option_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\VoteUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\VoteUser whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\VoteUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\VoteUser whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\VoteUser whereVoteId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\VoteUser whereVoteOptionId($value)
 * @mixin \Eloquent
 */
class VoteUser extends Model
{

  protected $fillable = [
    'user_id','vote_id','vote_option_id'
  ];
}
