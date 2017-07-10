<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use App\Entity\IpBan;
use App\Entity\Role;
/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Query\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $username 登陆用户名
 * @property string $last_ip 上次登陆ip
 * @property bool $status 1-普通状态, 0-禁言
 * @property int $level 用户等级
 * @property string $nickname 昵称
 * @property int $credits 积分
 * @property string $avatar 头像
 * @property bool $gender 性别
 * @property bool $online 在线
 * @property bool $enable 是否启用
 * @property string $tourist_token 游客凭证session保存
 * @property int $area_id 所属区域id
 * @property int $inviter_id 推广人id
 * @property int $master_id 主人id(不是机器人为null)
 * @property int $room_id 所属房间id
 * @property int $group_id 所属团队id
 * @property string $last_login 上次登陆时间
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entity\Role[] $roles
 * @method static \Illuminate\Database\Query\Builder|\App\User whereAreaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereAvatar($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereCredits($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereEnable($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereGender($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereGroupId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereInviterId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereLastIp($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereLastLogin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereLevel($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereMasterId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereNickname($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereOnline($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereRoomId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereTouristToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUsername($value)
 * @property string $qq qq
 * @property string $mobile 手机号
 * @method static \Illuminate\Database\Query\Builder|\App\User whereMobile($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereQq($value)
 * @property int $agent_id 所属业务员id
 * @property-read \App\User $agent
 * @property-read \App\Entity\IpBan $ipBan
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entity\Role[] $role
 * @method static \Illuminate\Database\Query\Builder|\App\User whereAgentId($value)
 * @property string $ua
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUa($value)
 */
class User extends Authenticatable
{
  use Notifiable,EntrustUserTrait;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'username',
    'password',
    'last_ip',
    'status',
    'level',
    'name',
    'nickname',
    'credits',
    'email',
    'avatar',
    'gender',
    'online',
    'enable',
    'tourist_token',
    'area_id',
    'inviter_id',
    'master_id',
    'room_id',
    'group_id',
    'last_login',
    'mobile',
    'agent_id',
    'qq'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password', 'remember_token',
  ];

  public function ipBan()
  {
    return $this->belongsTo(IpBan::class,'last_ip','ip');
  }

  public function role()
  {
    return $this->belongsToMany(Role::class);
  }

  public function agent()
  {
    return $this->belongsTo(User::class, 'agent_id');
  }

  public function inviter()
  {
      return $this->belongsTo(User::class,'inviter_id');
  }
}
