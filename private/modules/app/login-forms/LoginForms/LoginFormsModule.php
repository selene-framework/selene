<?php
namespace App\LoginForms;

use App\LoginForms\Controllers\Login;
use Selenia\Core\Assembly\Services\ModuleServices;
use Selenia\Interfaces\ModuleInterface;

class LoginFormsModule implements ModuleInterface
{
  static function routes ()
  {
    return [
      RouteGroup ([
        'prefix' => self::settings ()['prefix'],
        'routes' => [
          PageRoute ([
            'onMenu'     => false,
            'title'      => '$LOGIN_PROMPT',
            'URI'        => 'login',
            'controller' => Login::ref (),
          ]),
        ],
        'onMenu' => false,
      ]),
    ];
  }

  static function settings ()
  {
    global $application;
    return get ($application->config, 'app/login-forms', []);
  }

  function boot () { }

  function configure (ModuleServices $module)
  {
    $module
      ->provideTranslations ()
      ->setDefaultConfig ([
        'main'            => [
          'translation' => true,
        ],
        'app/login-forms' => [
          'prefix' => 'admin',
        ],
      ])
      ->onPostConfig (function () use ($module) {
        $module->registerRoutes (self::routes ());
      });
  }

}
