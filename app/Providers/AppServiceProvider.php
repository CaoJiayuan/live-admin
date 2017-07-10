<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      \Validator::extend('mobile', function ($attribute, $value, $parameters) {
        if ($value == '') {
          return true;
        }
        return preg_match("/^1[0-9]{2}[0-9]{8}$|15[0189]{1}[0-9]{8}$|189[0-9]{8}$/", $value);
      }, '请输入正确的手机号');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
      $this->app->afterResolving('blade.compiler', function (BladeCompiler $bladeCompiler) {
        $bladeCompiler->directive('ican', function ($expression) {
          return "<?php if(\\App\\Util\\Permission::can({$expression})): ?>";
        });

        $bladeCompiler->directive('endican', function ($expression) {
          return '<?php endif; ?>';
        });
      });
      $this->app->afterResolving('blade.compiler', function (BladeCompiler $bladeCompiler) {
        $bladeCompiler->directive('icanany', function ($expression) {
          return "<?php if(\\App\\Util\\Permission::any({$expression})): ?>";
        });

        $bladeCompiler->directive('endicanany', function ($expression) {
          return '<?php endif; ?>';
        });
      });
    }
}
