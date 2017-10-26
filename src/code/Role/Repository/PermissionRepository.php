<?php 

namespace Code\Role\Repository;

use Code\Role\Model\Permission;
use Code\Core\Repository\BaseRepository;

class PermissionRepository extends BaseRepository
{
	public function assignModel()
	{
		return Permission::class;
	}

	public function setFallBack()
	{
		return null;
	}

	public function module()
	{
		return "Permissions";
	}
	
	public function getPermissionsList()
	{
		return Permission::all();
	}
}