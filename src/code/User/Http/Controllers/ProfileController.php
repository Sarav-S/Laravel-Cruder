<?php

namespace Code\User\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Code\Core\Http\Controllers\Controller;
use Code\User\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{	
	/**
	 * Renders the user profile page
	 *
	 * @return     \Illuminate\View\View
	 */
	public function profile() : View
	{
		return view('users.profile');
	}

	/**
	 * Updates the user profile information
	 *
	 * @param      ProfileRequest  $request  The request
	 *
	 * @return     \Illuminate\Http\RedirectResponse
	 */
	public function updateProfile(ProfileRequest $request) : RedirectResponse
	{
		/**
		 * Holds the authenticated user instance
		 *
		 * @var \Code\User\Model\User
		 */
		$user = user();

		$user->name  = $request->name;
		$user->email = $request->email;

		/**
		 * Update password only when user has entered password. 
		 * Else ignore password updation.
		 */
		if ($request->has('password')) {
			$user->password  = bcrypt($request->password);
		}

		if (request()->hasFile('image')) {
			$filename    = request()->file('image')->store('users/'.user()->id.'/profile/');
			$user->image = asset($filename);
		}

		if ($user->save()) {
			success("User updated successfully");
		} else {
			error("Unable to updated user. Please try again.");
		}
		
		return redirect(route('user.profile'));
	}
}