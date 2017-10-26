<?php

namespace Code\User\Repository;

use Carbon\Carbon;
use Code\Core\Traits\JsonResponseTrait;
use Code\User\Model\User;
use Code\Core\Repository\BaseRepository;

class UserRepository extends BaseRepository
{
    use JsonResponseTrait;

	public function assignModel()
	{
		return User::class;
	}

    public function setFallBack()
    {
        return route('admin.users.index');
    }

    public function module()
    {
        return "Users";
    }

	/**
	 * Saves the user record
	 *
	 * @param      integer  $id     The identifier
	 *
	 * @return     \Illuminate\Http\RedirectResponse
	 */
	public function beforeSave($record)
	{
		$record->name  = request('name');
		$record->email = request('email');

		if (request()->has('password')) {
			$record->password = request('password');
		}

		return $record;
	}

	public function afterSave($record)
	{ 
		$record->image = request()->file('image')->store('users/'.$record->id.'/profile/');
	}
}