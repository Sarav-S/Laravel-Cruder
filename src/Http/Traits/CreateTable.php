<?php 

namespace Sarav\Http\Traits;

trait CreateTable 
{
	public function processTables()
	{
		$module = $this->qualifiedName();

		$content = str_replace(
			['DummyName', 'DummyTable', 'DummyFields'],
			[str_plural($this->qualifiedName()), 
			strtolower(str_plural($this->qualifiedName())), $this->generateFields()],
			$this->file->get($this->stubsPath().'migration.stub')
		);

		$fileName = date('Y_m_d_His').'_create_'.strtolower(str_plural($this->qualifiedName())).'_table.php';

		$this->checkAndCreate($this->basePath.'database/migrations');

		$this->file->put($this->basePath.'database/migrations/'.$fileName, $content);
	}

	protected function generateFields()
	{
		$item = null;

		$fields = request('field', []);

		$datatype = request('datatype', []);

		$allowNull = request('allowNull', []);

		$default = request('default', []);

		$length = request('length', []);

		foreach ($fields as $key => $field) 
		{
			$item .= '$table->'.$datatype[$key].'("'.$field.'"';
			if (trim($length[$key])) {
				$item .= ", {$length[$key]}";
			}
			$item .= ')';

			if ($datatype[$key] !== "increments") {
				if (in_array($field, $allowNull))
				{
					$item .= '->nullable()';
				}

				if (isset($default[$key]) && trim($default[$key]))
				{
					$item .= '->default("'.$default[$key].'")';
				}
			}


			$item .= ";
		";
			if ($key > -1) {
				$item .= "	";
			}
		}

		if (request()->has('timestamps') && request('timestamps'))
		{
			$item .= '$table->timestamps();
			';
		}

		if (request()->has('softdeletes') && request('softdeletes'))
		{
			$item .= '$table->softDeletes();';
		}

		$item = rtrim($item, '
		');

		return $item;
	}
}