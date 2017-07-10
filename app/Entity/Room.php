<?php

namespace App\Entity;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;

/**
 * App\Entity\Room
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $user_id 讲师id
 * @property string $title 标题
 * @property string $lss_user_id 直播服务用户id
 * @property string $app_id 直播服务app id
 * @property string $stream 直播服务stream
 * @property string $cover 封面
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Room whereAppId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Room whereCover($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Room whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Room whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Room whereLssUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Room whereStream($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Room whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Room whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Room whereUserId($value)
 * @property int $area_id 区域id
 * @property string $logo LOGO
 * @property string $icon 图标
 * @property string $company_name 公司名称
 * @property string $background 背景
 * @property int $register_capacity 注册人数上限
 * @property int $online_capacity 在线人数上限
 * @property int $video_id 当前视频
 * @property bool $main 是否是主房间
 * @property bool $permission 是否放权
 * @property bool $tourist 游客功能
 * @property bool $enable 是否开启
 * @property bool $vote 是否开启投票
 * @property bool $chat 是否开启聊天
 * @property bool $popup 是否显示弹窗
 * @property int $modify_num 在线人数编辑
 * @property int $chat_interval 发言间隔(s)
 * @property int $max_length 最大消息长度(字)
 * @property bool $video_position 视频位置,0-左,1-中,2-右
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Room whereAreaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Room whereBackground($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Room whereChat($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Room whereChatInterval($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Room whereCompanyName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Room whereEnable($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Room whereIcon($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Room whereLogo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Room whereMain($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Room whereMaxLength($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Room whereModifyNum($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Room whereOnlineCapacity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Room wherePermission($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Room wherePopup($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Room whereRegisterCapacity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Room whereTourist($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Room whereVideoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Room whereVideoPosition($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Room whereVote($value)
 * @property string $web_title 网页标题
 * @property int $main_id 主房间id
 * @property-read \App\User $admin
 * @property-read \App\Entity\Area $area
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Room whereMainId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Room whereWebTitle($value)
 * @property string $qr_code
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entity\RoomBackground[] $backgrounds
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entity\MaskingWord[] $maskings
 * @property-read \App\Entity\Video $video
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entity\Video[] $videos
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Room whereQrCode($value)
 * @property bool $covered
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Room whereCovered($value)
 */
class Room extends Model
{
  protected $fillable = [
    'area_id',
    'user_id',
    'web_title',
    'title',
    'logo',
    'icon',
    'company_name',
    'background',
    'register_capacity',
    'online_capacity',
    'video_id',
    'main_id',
    'main',
    'permission',
    'tourist',
    'enable',
    'vote',
    'chat',
    'popup',
    'modify_num',
    'chat_interval',
    'max_length',
    'video_position',
    'qr_code',
    'covered',
    'cover',
    'remark',
  ];

  public function area()
  {
    return $this->belongsTo(Area::class);
  }

  public function admin()
  {
    /** @var Builder $hasOne */
    $hasOne = $this->hasOne(User::class, 'room_id');
    $hasOne->rightJoin('role_user', 'user_id', '=','users.id');
    $hasOne->rightJoin('roles', function (JoinClause $clause) {
      $roomAdmin = config('roles.room_admin.name');
        $clause->on('roles.id', '=', 'role_user.role_id');
        $clause->on('roles.name', '=', \DB::raw("'$roomAdmin'"));
    });
    $hasOne->select([
      'users.*'
    ]);
    return $hasOne;
  }

  public function maskings()
  {
    return $this->hasMany(MaskingWord::class);
  }

  public function video()
  {
    return $this->belongsTo(Video::class);
  }

  public function videos()
  {
    return $this->hasMany(Video::class);
  }

  public function backgrounds()
  {
    return $this->hasMany(RoomBackground::class);
  }
}
