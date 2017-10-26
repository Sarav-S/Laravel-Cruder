<?php

namespace Code\Admin\Http\Controllers\Admin;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Code\Core\Http\Controllers\Controller;
use Code\Admin\Http\Requests\AdminProfileRequest;

class ProfileController extends Controller 
{	
	/**
	 * Renders the admin profile page
	 *
	 * @return     \Illuminate\View\View
	 */
	public function profile()
	{
		return view('admin.profile');
	}

	/**
	 * Updates the admin profile information
	 *
	 * @param      AdminProfileRequest  $request  The request
	 *
	 * @return     \Illuminate\Http\RedirectResponse
	 */
	public function updateProfile(AdminProfileRequest $request)
	{
		/**
		 * Holds the authenticated admin instance
		 *
		 * @var \Code\Admin\Model\Admin
		 */
		$admin = admin();

		$admin->name  = $request->name;
		$admin->email = $request->email;

		/**
		 * Update password only when admin has entered password. 
		 * Else ignore password updation.
		 */
		if ($request->has('password')) {
			$admin->password  = bcrypt($request->password);
		}

		if ($admin->save()) {

			$admin->image = request()->file('image')->store('admin/'. $admin->id. '/profile/');
			$admin->save();
			success("Profile details updated successfully");
		} else {
			error("Unable to update. Please try again.");
		}
		
		return redirect(route('admin.profile'));
	}
}