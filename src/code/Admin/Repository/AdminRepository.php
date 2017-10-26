<?php 

namespace Code\Admin\Repository;

use Code\Admin\Model\Admin;
use Code\Core\Repository\BaseRepository;

class AdminRepository extends BaseRepository
{
	public function assignModel()
	{
		return Admin::class;
	}

	public function setFallBack()
	{
		return route('admin.admins.index');
	}

	public function module()
	{
		return "Admins";
	}

	public function beforeSave($record)
	{
		$record->name  = request('name');
		$record->email = request('email');

		if (request()->has('password')) {
			$record->password = bcrypt(request('password'));
		}

		return $record;
	}

	public function afterSave($record)
	{
		$record->roles()->sync([request('role_id')]);

		$record->image = request()->file('image')->store('admin/'. $record->id. '/profile/');

		$record->save();
	}
}