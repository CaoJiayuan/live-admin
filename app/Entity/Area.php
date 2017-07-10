<?php

namespace App\Entity;

use App\Traits\PermissionHelper;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * App\Entity\Area
 *
 * @property int $id
 * @property string $name
 * @property bool $enable
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Area whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Area whereEnable($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Area whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Area whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Area whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\User $admin
 * @property-read \App\Entity\Room $room
 */
class Area extends Model
{
  use PermissionHelper;

  protected $fillable = [
    'name','enable'
  ];

  public function admin()
  {
    /** @var Builder $hasOne */
    $hasOne = $this->hasOne(User::class, 'area_id');
    $hasOne->select('users.*');
    $this->withRole($hasOne, 'area');
    return $hasOne;
  }

  public function room()
  {
    return $this->hasOne(Room::class)->where('main', true);
  }
}
