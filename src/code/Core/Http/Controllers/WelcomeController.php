<?php

namespace Code\Core\Http\Controllers;

use Code\Core\Http\Controllers\Controller;
use Illuminate\View\View;

class WelcomeController extends Controller {

	/**
	 * Returns the home page view
	 *
	 * @return  \Illuminate\View\View
	 */
	public function home() : View
	{
		return view('home');
	}
}