<?php

namespace App\Http\Middleware;

use App\Repository\PermissionRepository;
use Closure;
use Illuminate\Contracts\View\Factory as ViewFactory;

class Navigation
{
  protected $view;
  /**
   * @var PermissionRepository
   */
  private $repository;

  /**
   * Create a new error binder instance.
   *
   * @param  ViewFactory $view
   * @param PermissionRepository $repository
   */
  public function __construct(ViewFactory $view, PermissionRepository $repository)
  {
    $this->view = $view;
    $this->repository = $repository;
  }

  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  \Closure $next
   * @return mixed
   */
  public function handle($request, Closure $next)
  {
    $this->view->share('navigation', $this->repository->navigation()->toArray());

    return $next($request);
  }
}
