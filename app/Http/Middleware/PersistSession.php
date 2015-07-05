<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three LTD <support@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Session\SessionManager;

/**
 * This is the persists session middleware class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class PersistSession
{
    /**
     * The session manager.
     *
     * @var \Illuminate\Session\SessionManager
     */
    protected $manager;

    /**
     * Create a new persist session middleware.
     *
     * @param \Illuminate\Session\SessionManager $manager
     *
     * @return void
     */
    public function __construct(SessionManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $driver = $this->manager->driver();
        $code = (string) $response->getStatusCode();

        if (!($driver->getHandler() instanceof CookieSessionHandler) && substr($code, 0, 1) === '3') {
            $driver->save();
        }

        return $response;
    }
}
