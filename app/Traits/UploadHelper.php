<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-5-12
 * Time: 下午3:06
 */

namespace App\Traits;

use Illuminate\Http\UploadedFile;

trait UploadHelper
{
  /**
   * @param UploadedFile $file
   * @param string $dir
   * @return mixed
   */
  public function uploadAndStore($file, $dir = 'uploads')
  {
    $path = $file->storePublicly($dir, [
      'disk' => 'public'
    ]);

    return $path;
  }
}