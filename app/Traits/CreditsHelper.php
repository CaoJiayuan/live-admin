<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-6-23
 * Time: 上午10:59
 */

namespace App\Traits;


use App\Entity\CreditRecord;
use App\User;

trait CreditsHelper
{
  /**
   * @param User $user
   * @param $changes
   * @param $reason
   * @return mixed
   */
  public function changeCredits($user, $changes, $reason)
  {
    if ($changes < 0) {
      if ($user->credits < -$changes) {
        return $this->respondMessage(403, '用户积分不足');
      }
    }
    return \DB::transaction(function () use ($user, $changes, $reason) {
      if ($changes != 0) {
        $user->credits += $changes;
        $user->save();
        CreditRecord::create([
          'user_id' => $user->id,
          'changes' => $changes,
          'reason'  => $reason,
        ]);
      }
      return $user;
    });
  }
}