<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-2-24
 * Time: 下午2:36
 */

namespace App\Entity;


use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;
use Zizaco\Entrust\EntrustPermission;

/**
 * App\Entity\Permission
 *
 * @property int $id
 * @property string $name
 * @property string $display_name
 * @property string $description
 * @property string $path 菜单uri
 * @property string $icon
 * @property int $parent_id
 * @property bool $type 类型(0-菜单,1-操作)
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entity\Role[] $roles
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Permission whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Permission whereDisplayName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Permission whereIcon($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Permission whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Permission whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Permission whereParentId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Permission wherePath($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Permission whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Permission whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entity\Permission[] $children
 */
class Permission extends EntrustPermission
{
  public static $roles = [];

  protected $casts = [
    'granted' => 'bool',
  ];
  protected $fillable = [
    'name',
    'display_name',
    'description',
    'path',
    'icon',
    'parent_id',
    'type',
  ];

  public function node()
  {
    $children = $this->children();
    $prefix = \DB::getTablePrefix();
    $children->select([
      'permissions.*',
    ]);
    $children->where('permissions.type', 0); // Only menu
    $children->groupBy('permissions.id');
    /** @var Role[] $roles */
    $roles = static::$roles;
    $ids = [];
    foreach ($roles as $role) {
      $ids[] = array_get($role, 'id');
    }
    $children->leftJoin('permission_role', function (JoinClause $clause) use ($ids) {
      $clause->on('permission_role.permission_id', '=', 'permissions.id');
      $clause->whereIn('permission_role.role_id', $ids);
    });

    $children->addSelect(\DB::raw("CASE WHEN {$prefix}permission_role.role_id IS NOT NULL THEN true ELSE false END AS granted"));

    return $children->with('node');
  }

  public static function tree()
  {
    $prefix = \DB::getTablePrefix();
    $builder = static::where('parent_id', 0)->with('node');
    $builder->select([
      'permissions.*',
    ]);
    $builder->where('permissions.type', 0); // Only menu
    $builder->groupBy('permissions.id');
    $roles = static::$roles;
    $ids = [];
    foreach ($roles as $role) {
      $ids[] = array_get($role, 'id');
    }
    $builder->leftJoin('permission_role', function (JoinClause $clause) use ($ids) {
      $clause->on('permission_role.permission_id', '=', 'permissions.id');
      $clause->whereIn('permission_role.role_id', $ids);
    });

    $builder->addSelect(\DB::raw("CASE WHEN {$prefix}permission_role.role_id IS NOT NULL THEN true ELSE false END AS granted"));

    return $builder->get();
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasMany|Builder|\Illuminate\Database\Eloquent\Builder
   */
  public function children()
  {
    return $this->hasMany(Permission::class, 'parent_id', 'id');
  }

  public static function getByNames(array $names)
  {
    return static::whereIn('name', $names)->get();
  }
}