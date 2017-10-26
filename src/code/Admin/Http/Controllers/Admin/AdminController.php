<?php 

namespace Code\Admin\Http\Controllers\Admin;

use Code\Admin\Repository\AdminRepository;
use Code\Core\Http\Controllers\AdminCoreController;
use Code\Role\Repository\RoleRepository;
use Illuminate\Support\Facades\View;

class AdminController extends AdminCoreController
{
	protected $role;

	public function __construct(AdminRepository $repo, RoleRepository $role)
	{
		$this->repo = $repo;
		$this->role = $role;
		$this->view = "admins";

		View::share('route', 'admin.admins.');
	}

	public function rules()
	{
		$rules = [
			'name'     => 'required',
			'email'    => 'required|email|unique:users',
			'password' => 'required|min:8',
			'role_id'  => 'required'
		];

		$id = urlsegmentDecode();

		if ($id && is_numeric($id)) {
			$rules['email']    = 'required|email|unique:users,id,'.$id;
			$rules['password'] = '';
		}

		return $rules;
	}

	/**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
	public function create()
	{
		$roles  = $this->role->latest();
		return view($this->view.'.admin.create', compact('roles'));
	}

	/**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
	public function edit($id)
	{
		$record = $this->repo->with(['roles'])->find($id);
		$roles  = $this->role->latest();
		
		return view($this->view.'.admin.edit', compact('record', 'roles'));
	}
}