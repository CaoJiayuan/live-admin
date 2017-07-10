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
 * @property int $user_id
 * @property bool $type 0-登陆
 * @property int $area_id 所属区域id
 * @property int $room_id 所属房间id
 * @property int $group_id 所属团队id
 * @property int $agent_id 所属业务员id
 * @property string $ua
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserLogs whereAgentId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserLogs whereAreaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserLogs whereGroupId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserLogs whereRoomId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserLogs whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserLogs whereUa($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserLogs whereUserId($value)
 */
class UserLogs extends Model
{

  protected $fillable = [
    'user_id',
    'type',
    'area_id',
    'room_id',
    'group_id',
    'agend_id',
    'created_at'
  ];
}
