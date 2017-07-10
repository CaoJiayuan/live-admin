<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\CreditRecord
 *
 * @property int $id
 * @property int $user_id
 * @property int $changes
 * @property string $reason
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\CreditRecord whereChanges($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\CreditRecord whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\CreditRecord whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\CreditRecord whereReason($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\CreditRecord whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\CreditRecord whereUserId($value)
 * @mixin \Eloquent
 */
class CreditRecord extends Model
{
  protected $fillable = [
    'user_id',
    'changes',
    'reason',
  ];
}
