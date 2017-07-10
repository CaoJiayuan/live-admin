<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\IpBan
 *
 * @property int $id
 * @property string $ip
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\IpBan whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\IpBan whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\IpBan whereIp($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\IpBan whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class IpBan extends Model
{

  protected $fillable = [
    'ip'
  ];
}
