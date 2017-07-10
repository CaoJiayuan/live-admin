<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-5-24
 * Time: 上午10:19
 */

namespace App\Http\Controllers;


use App\Entity\VoteOption;
use App\Repository\VoteRepository;

class VoteController extends Controller
{

  public function votes(VoteRepository $repository)
  {
    $data = $repository->votes();
    return view('room.votes.index', [
      'data' => $data,
    ]);
  }

  public function create(VoteRepository $repository)
  {
    $data = $this->getValidatedData([
      'title' => 'required',
      'id',
    ], [], ['title' => '标题']);
    $repository->write($data);
    \Session::flash('message', '保存成功');
    return $this->respondSuccess();
  }

  public function delete(VoteRepository $repository, $id)
  {
    $repository->delete($id);

  }

  public function options(VoteRepository $repository, $id)
  {
    $data = $repository->options($id);
    return view('room.votes.options', [
      'data'   => $data,
      'voteId' => $id,
    ]);
  }

  public function postOptions(VoteRepository $repository, $id)
  {
    $data = $this->getValidatedData([
      'name' => 'required',
      'id',
      'modify',
    ]);
    $data['vote_id'] = $id;
    $repository->writeOption($data);
    \Session::flash('message', '保存成功');
    return $this->respondSuccess();
  }

  public function status(VoteRepository $repository, $id)
  {
    $repository->status($id);
    return redirect()->back();
  }

  public function deleteOption($id)
  {
    VoteOption::destroy($id);
  }
}