<?php 

namespace Code\Role\Model;

use Code\Core\Model\Model;

class Permission extends Model
{
	protected $fillable = [
		'name',
		'display_name',
		'description'
	];	
}