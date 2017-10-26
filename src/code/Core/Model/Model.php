<?php

namespace Code\Core\Model;

use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel 
{
	protected $add = true;
	
	protected $edit = true;

	protected $show = false;

	protected $delete = true;

	public $columns = [];

	public function canAdd()
	{
		return $this->add;
	}

	public function canEdit()
	{
		return $this->edit;
	}

    public function canShow()
    {
        return $this->show;
    }

	public function canDelete()
	{
		return $this->delete;
	}
}