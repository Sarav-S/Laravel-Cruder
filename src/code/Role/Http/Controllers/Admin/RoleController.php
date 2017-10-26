<?php 

namespace Code\Role\Http\Controllers\Admin;

use Code\Core\Http\Controllers\AdminCoreController;
use Code\Role\Repository\PermissionRepository;
use Code\Role\Repository\RoleRepository;
use Illuminate\Support\Facades\View;

class RoleController extends AdminCoreController
{

	protected $permission;

	public function __construct(RoleRepository $repo, PermissionRepository $permission)
	{
		$this->repo       = $repo;
		$this->view       = "roles";
		$this->permission = $permission;
		parent::__construct();
		View::share('route', 'admin.roles.');
	}

	public function rules()
	{
		return [
			'display_name'  => 'required',
			'description'   => 'required',
			'permission_id' => 'required|array'
		];
	}

	public function create()
	{
		$permissions = $this->permission->getPermissionsList();
		return view($this->view.'.admin.create', compact('permissions'));
	}

	public function edit($id)
	{
		$record      = $this->repo->with(['permission' => function($query){
			return $query->select('role_id', 'permission_id');
		}])->find($id);
		$selectedPermissions = collect($record->permission)->pluck('permission_id')->toArray();

		$permissions = $this->permission->getPermissionsList();
		return view($this->view.'.admin.edit', compact('record', 'permissions', 'selectedPermissions'));
	}
}