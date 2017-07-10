<?php
namespace App\Entity;

use Illuminate\Database\Query\Builder;
use Zizaco\Entrust\EntrustRole;

/**
 * Created by Cao Jiayuan.
 * 
 * Date: 17-2-24
 * Time: 下午2:35
 *
 * @property int $id
 * @property string $name
 * @property string $display_name
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entity\Permission[] $perms
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Role whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Role whereDisplayName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Role whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Role whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Role whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entity\Permission[] $permissions
 */
class Role extends EntrustRole
{
  protected $casts = [
    'edit_able'   => 'bool',
    'delete_able' => 'bool',
    'change_name' => 'bool'
  ];
  protected $fillable = [
    'name',
    'display_name',
    'description'
  ];

  public function permissions()
  {
    /** @var Builder $builder */
    $builder = $this->belongsToMany(Permission::class, 'permission_role');

    return $builder;
  }

  public function clearPermissions()
  {
    \DB::table(config('entrust.permission_role_table'))->where('role_id', $this->id)->delete();
    return $this;
  }

  public function resetPermissions($permissions)
  {
    $this->clearPermissions()
      ->attachPermissions($permissions);
    return $this;
  }

  public static function del($id)
  {
    return \DB::transaction(function () use ($id) {
      /** @var Role $role */
      $role = self::find($id);
      return $role->clearPermissions()->delete();
    });
  }
}