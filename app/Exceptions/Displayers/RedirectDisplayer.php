<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Exceptions\Displayers;

use Exception;
use GrahamCampbell\Exceptions\Displayers\DisplayerInterface;
use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;
use StyleCI\Login\LoginProvider;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

/**
 * This is the redirect displayer class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class RedirectDisplayer implements DisplayerInterface
{
    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Create a new redirect displayer instance.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Get the error response associated with the given exception.
     *
     * @param \Exception $exception
     * @param string     $id
     * @param int        $code
     * @param string[]   $headers
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function display(Exception $exception, $id, $code, array $headers)
    {
        $this->request->session()->put('url.intended', app(UrlGenerator::class)->full());

        return app(LoginProvider::class)->redirect(['admin:repo_hook', 'public_repo', 'read:org', 'user:email']);
    }

    /**
     * Get the supported content type.
     *
     * @return string
     */
    public function contentType()
    {
        return 'text/html';
    }

    /**
     * Can we display the exception?
     *
     * @param \Exception $exception
     *
     * @return bool
     */
    public function canDisplay(Exception $exception)
    {
        $redirect = $exception instanceof HttpExceptionInterface && $exception->getStatusCode() === 401;

        return $redirect && !$this->request->is('api*') && $this->request->hasSession();
    }

    /**
     * Do we provide verbose information about the exception?
     *
     * @return bool
     */
    public function isVerbose()
    {
        return false;
    }
}
