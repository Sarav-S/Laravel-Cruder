<?php 

namespace Code\Setting\Model;

use Code\Core\Model\Model;

class Setting extends Model 
{
	public $timestamps = false;

	protected $fillable = [
		'heading',
		'label',
		'slug',
		'value',
		'required',
		'help_text',
		'input_type',
		'input_options'
	];
}