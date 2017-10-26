<?php 

namespace Code\User\Http\Controllers\Admin;

use Code\Core\Http\Controllers\AdminCoreController;
use Code\User\Repository\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class UserController extends AdminCoreController
{

	public function __construct(UserRepository $repo)
	{
		$this->repo   = $repo;
		$this->view   = "users";
		$this->module = "Users";
		parent::__construct();
		View::share('route', 'admin.users.');
	}

	public function rules()
	{
		$rules = [
			'name'     => 'required',
			'email'    => 'required|email|unique:users',
            'password' => 'required|min:8',
		];

		$id = urlsegmentDecode();

		if ($id && is_numeric($id)) {
			$rules['email']    = 'required|email|unique:users,id,'.$id;
            $rules['password'] = '';
		}

		return $rules;
	}
}