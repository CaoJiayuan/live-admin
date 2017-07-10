<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests,ApiResponse;


  /**
   * @var Request
   */
  protected $request;

  public function __construct()
  {
    $this->request = app(Request::class);
  }

  public function inputGet($key, $default = null)
  {
    return $this->request->get($key, $default);
  }

  public function inputAll()
  {
    return $this->request->all();
  }

  public function validateRequest(array $rules, array $messages = [], array $customAttributes = [])
  {
    $this->validate($this->request, $rules, $messages, $customAttributes);
  }

  public function getValidatedData($rules, array $messages = [], array $customAttributes = [])
  {
    $fixedRules = [];

    $keys = [];

    foreach ($rules as $key => $rule) {
      if (!is_numeric($key)) {
        $fixedRules[$key] = $rule;
        $keys[] = $key;
      } else {
        $keys[] = $rule;
      }
    }

    $this->validateRequest($fixedRules, $messages, $customAttributes);

    return $this->request->only($keys);
  }

}
