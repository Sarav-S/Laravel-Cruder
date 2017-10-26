<?php 

namespace Code\Role\Repository;

use Code\Role\Model\Role;
use Code\Core\Repository\BaseRepository;

class RoleRepository extends BaseRepository
{
	public function assignModel()
	{
		return Role::class;
	}

	public function setFallBack()
    {
        return route('admin.roles.index');
    }

    public function module()
    {
        return "Roles";
    }

	public function beforeSave($record)
	{
		$record->display_name = request('display_name');
		$record->name         = str_slug(request('display_name'));
		$record->description  = request('description');

		return $record;
	}

	public function afterSave($record)
	{
		$record->permission()->sync(request('permission_id'));
	}
}