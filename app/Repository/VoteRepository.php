<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-5-24
 * Time: 上午10:19
 */

namespace App\Repository;


use App\Entity\Vote;
use App\Entity\VoteOption;
use App\Traits\ApiResponse;
use App\Traits\PermissionHelper;
use Illuminate\Database\Query\Builder;

class VoteRepository extends Repository
{

  use PermissionHelper, ApiResponse;

  public function votes()
  {
    return $this->getSearchAbleData(Vote::class, [
      'title',
    ], function ($builder) {
      $room = $this->getAccessibleRoom();
      $roomId = $room ? $room->id : 0;
      /** @var Builder $builder */
      $builder->where('votes.room_id', $roomId);
      $builder->leftJoin('vote_options', 'vote_options.vote_id', '=', 'votes.id');
      $pre = \DB::getTablePrefix();
      $raw = <<<SQL
(SELECT COUNT({$pre}vote_users.id) FROM {$pre}vote_users WHERE {$pre}vote_users.vote_id = {$pre}votes.id) + SUM({$pre}vote_options.modify) AS num
SQL;

      $builder->select([
        'votes.*',
        \DB::raw($raw),
        \DB::raw("COUNT({$pre}vote_options.id) AS option_num"),
      ]);
      $builder->groupBy('votes.id');
    });
  }

  public function delete($id)
  {
    \DB::transaction(function () use ($id) {
      VoteOption::where('vote_id', $id)->delete();
      Vote::destroy($id);
    });
  }

  public function write($data)
  {
    $room = $this->getAccessibleRoom();
    $roomId = $room ? $room->id : 0;
    $data['room_id'] = $roomId;
    Vote::updateOrCreate([
      'id' => $data['id'],
    ], array_except($data, 'id'));
  }

  public function status($id)
  {
    Vote::where('id', $id)
      ->update([
        'enable' => \DB::raw('!enable'),
      ]);
  }

  public function options($id)
  {
    return $this->getSearchAbleData(VoteOption::class, [
      'name',
    ], function ($builder) use ($id) {
      /** @var Builder $builder */
      $builder->where('vote_options.vote_id', $id);
      $builder->leftJoin('vote_users', 'vote_users.vote_option_id', '=', 'vote_options.id');
      $pre = \DB::getTablePrefix();
      $builder->select([
        'vote_options.*',
        \DB::raw("COUNT({$pre}vote_users.id) AS option_num"),
        \DB::raw("(COUNT({$pre}vote_users.id) + {$pre}vote_options.modify) as num"),
      ]);
      $builder->groupBy('vote_options.id');
    });
  }

  public function writeOption($data)
  {
    if (!$data['id']) {
      $num = VoteOption::where('vote_id', $data['vote_id'])->count();
      if ($num >= VOTE_OPTION_MAX) {
        return $this->respondMessage(403, '投票数最多为' . VOTE_OPTION_MAX . '个');
      }
    }
    $data['modify'] = $data['modify'] ?: 0;
    VoteOption::updateOrCreate([
      'id' => $data['id'],
    ], array_except($data, 'id'));
  }
}