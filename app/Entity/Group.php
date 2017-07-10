<?php

namespace App\Entity;

use App\Traits\PermissionHelper;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * App\Entity\Group
 *
 * @property int $id
 * @property string $name
 * @property int $room_id 所属房间id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Group whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Group whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Group whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Group whereRoomId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Group whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\User $admin
 * @property-read \App\Entity\Room $room
 */
class Group extends Model
{

  use PermissionHelper;
  protected $fillable = [
    'room_id', 'name'
  ];

  public function room()
  {
    return $this->belongsTo(Room::class);
  }

  public function admin()
  {
    /** @var Builder $hasOne */
    $hasOne = $this->hasOne(User::class, 'group_id');
    $hasOne->select('users.*');
    $this->withRole($hasOne, 'group');
    return $hasOne;
  }
}
