<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

/**
 * This is the abstract controller class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
abstract class AbstractController extends Controller
{
    use DispatchesJobs, ValidatesRequests;

    /**
     * Create a new controller instance.
     *
     * @param array $csrf
     *
     * @return void
     */
    public function __construct(array $csrf = [])
    {
        $this->middleware('csrf', $csrf);
    }
}
