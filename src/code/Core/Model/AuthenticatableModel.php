<?php

namespace Code\Core\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;

class AuthenticatableModel extends Authenticatable 
{
	protected $add = true;
	
	protected $edit = true;

	protected $delete = true;

    protected $show = false;

	public $columns = [];

	public function canAdd()
	{
		return $this->add;
	}

	public function canEdit()
	{
		return $this->edit;
	}

	public function canDelete()
	{
		return $this->delete;
	}

	public function canShow()
    {
        return $this->show;
    }
}