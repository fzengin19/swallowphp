<?php

namespace App\Http\Middlewares;

use App\Core\Request;

class BaseMiddleware
{
  protected $next;

  /**
   * Constructs a new instance of the class.
   *
   * @param mixed $next The value to set for the "next" property.
   * @return void
   */
  public function __construct($next = null)
  {
    $this->next = $next;
  }

  public function handle(Request $request)
  {


  }
}
