<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
  // ... other properties ...

  /**
   * The application's middleware aliases.
   *
   * @var array<string, class-string|string>
   */
  protected $middlewareAliases = [
    'web' => [
      \App\Http\Middleware\AdminOrderNotificationsMiddleware::class,
    ],
    'adminaccess' => \App\Http\Middleware\AdminAccessMiddleware::class,
  ];
}
