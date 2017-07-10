<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-5-15
 * Time: 下午2:52
 */

namespace App\Http\Controllers;


use App\Entity\Scoop;
use App\Repository\InfoRepository;
use Illuminate\Http\Request;

class InfoController extends Controller
{

  public function scoops(InfoRepository $repository)
  {
    $data = $repository->scoops();
    return view('info.scoop.index', [
      'data' => $data
    ]);
  }

  public function showScoopForm(Request $request)
  {
    $item = null;
    if ($id = $request->get('id')) {
      $item = Scoop::find($id);
    }

    return view('info.scoop.write', [
      'item' => $item
    ]);
  }

  public function saveScoop(InfoRepository $repository)
  {
    $data = $this->getValidatedData([
      'id',
      'title'   => 'required',
      'summary' => 'required',
      'content' => 'required',
    ]);

    $repository->saveScoop($data);
  }
}