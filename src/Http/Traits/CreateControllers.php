<?php 

namespace Sarav\Http\Traits;

trait CreateControllers
{
	public function processControllers()
	{
		$content = str_replace(
			['DummyName', 'DummyPlural', 'DummyRulesCreate', 'DummyRulesUpdate'],
			[$this->qualifiedName(), strtolower(str_plural($this->qualifiedName())), 
			$this->generateCreateRules(), $this->generateUpdateRules()],
			$this->file->get($this->stubsPath().'admincontroller.stub')
		);

		$this->checkAndCreate($this->basePath.'Http/Controllers/Admin');

		$this->file->put(
			$this->basePath.'Http/Controllers/Admin/'.$this->qualifiedName().'Controller.php', 
			$content
		);
	}

	public function generateCreateRules()
	{
		$rules = [];

		$givenRules = request('create', [
			'id'       => '',
			'name'     => 'required|min:8',
			'email'    => 'required|email|unique:amenities',
			'password' => 'required|min:8'
		]);

		$i = 0;
		foreach (array_filter($givenRules) as $field => $rule) {
			$rules[] = ($i==0) ? "'$field' => '$rule'," : "	'$field' => '$rule',";
			$i++;
		}

		return implode('
		', $rules);
	}

	public function generateUpdateRules()
	{
		$rules = '';

		$createRules = request('create', [
			'id'       => '',
			'name'     => 'required|min:8',
			'email'    => 'required|email|unique:amenities',
			'password' => 'required|min:8'
		]);

		$updateRules = request('update', [
			'id'       => '',
			'name'     => 'required|min:8',
			'email'    => 'required|email|unqiue:amenities,email,:id',
			'password' => ''
		]);

		$withoutDuplicates = array_diff($updateRules, $createRules);

		foreach (array_filter($withoutDuplicates) as $field => $rule) {
			$rule = str_replace(':id', '$id',$rule);
			$rules .= '$rules["'.$field.'"] = "'.$rule.'";';
		}

		return $rules;
	}
}