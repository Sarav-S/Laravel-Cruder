<?php

namespace Code\Auth\Http\Controllers\Admin;

use Illuminate\View\View;
use Code\Core\Http\Controllers\Controller;

class HomeController extends Controller {

	/**
	 * Returns the user's dashboard page after 
	 * login / registration / password reset
	 *
	 * @return  \Illuminate\View\View
	 */
	public function dashboard() : View
	{
		return view('admin.dashboard');
	}
}