<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-5-4
 * Time: 下午2:54
 */

namespace App\Repository;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class Repository
{
  public function getSearchAbleData($model, array $search = [], \Closure $closure = null, \Closure $trans = null)
  {
    $data = \Request::only([
      'keyword', 'sort', 'page_size'
    ]);

    list($filter, $order, $pageSize) = array_values($data);
    if (!is_object($model)) {
      $model = app($model);
    }
    if (!$model instanceof Model) {
      throw new \UnexpectedValueException(__METHOD__ . ' expects parameter 1 to be an object of ' . Model::class . ',' . get_class($model) . ' given');
    }
    $orderArr = explode('|', $order, 2);

    $table = $model->getTable();

    $builder = $model->newQuery();
    if ($filter && $search) {
      $builder->where(function ($builder) use ($search, $filter,$table) {
        foreach ((array)$search as $column) {
          $columnArr = explode('.', $column);
          if (count($columnArr) == 2) {
            $table = $columnArr[0];
            $column = $columnArr[1];
          }
          /** @var Builder $builder */
          $builder->orWhere($table.'.'.$column, 'like binary', "%{$filter}%");
        }
      });
    }
    if ($closure) {
      $closure($builder);
    }
    if ($order) {
      $builder->getQuery()->orders = null;
    }
    $key = $model->getKeyName();
    list($o, $d) = [array_get($orderArr, 0) ?: $table . '.'. $key, array_get($orderArr, 1) ?: 'desc'];
    $builder->orderBy($o, $d);

    $url = url()->current();

    $query = \Request::query();
    $query = http_build_query(array_except($query, 'page'));

    /** @var LengthAwarePaginator $pager */
    $pager = $builder->paginate($pageSize ?: 10)->setPath($url . '?' . $query);

    if ($trans) {
      $trans($pager->getCollection());
    }

    return $pager;
  }
}