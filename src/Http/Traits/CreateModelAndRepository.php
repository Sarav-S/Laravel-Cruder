<?php 

namespace Sarav\Http\Traits;

trait CreateModelAndRepository
{
	public function processModelAndRepository()
	{
		$fields = request('fillable', []);

		$fillable = "";
		foreach ($fields as $field) {
			$fillable .= '"'.$field.'",';
		}
		$fillable = rtrim($fillable, ',');

		$showListings = collect(request('show', []))->keys();

		$listings = "";
		foreach ($showListings as $listing) {
			$listings .= "[
        	'name'  => '".ucwords(str_replace("_", " ", $listing))."',
            'index' => '$listing'
	    ],";
		}
		$listings = rtrim($listings, ',');

		$timestampFields = '';

		if (request()->has('timestamps')) {
			$timestampFields .= '"created_at", "updated_at", ';
		}

		if (request()->has('softdeletes')) {
			$timestampFields .= '"deleted_at"';
		}

		$timestamps = 'protected $dates = [
		'.rtrim($timestampFields, ',').'
	];';

		if (empty($timestamps)) {
			$timestamps = 'public $timestamps = false;';
		}

		$content = str_replace(
			['DummyName', 'DummyFillable', 'DummyListing', 'DummyTimestamps', 'RelationshipNamespace', 
				'DummyRelationships'
			],
			[
				$this->qualifiedName(), $fillable, $listings, $timestamps, $this->generateNamespaces(),
				$this->buildRelationships()
			],
			$this->file->get($this->stubsPath().'model.stub')
		);

		$this->checkAndCreate($this->basePath.'Model');
		

		$this->file->put($this->basePath.'Model/'.$this->qualifiedName().'.php', $content);

		$content = str_replace(
			['DummyName', 'DummyPluralSmall', 'DummyPlural'],
			[$this->qualifiedName(), strtolower(str_plural($this->module)), str_plural($this->qualifiedName())],
			$this->file->get($this->stubsPath().'repository.stub')
		);

		$this->checkAndCreate($this->basePath.'Repository');

		$this->file->put($this->basePath.'Repository/'.$this->qualifiedName().'Repository.php', $content);
	}

	public function buildRelationships()
	{
		$relationships = "";

		$local_key    = request('local_key', []);
		$model        = request('model', []);
		$relationship = request('relationship', []);
		$table        = request('table', []);
		$foreign_key  = request('foreign_key', []);

		$modelsList = $this->getModelList();

		for ($i = 0; $i < count($local_key); $i++) {
			$namespace = $modelsList[$model[$i]];
			switch($relationship[$i]) {
				case 'hasOne':
				$relationships .= '
	public function '.str_plural(strtolower($model[$i])).'() {
		return $this->hasOne("'.$namespace.'", "'.$foreign_key[$i].'");
	}
				';
					break;

				case 'belongsTo':
					$relationships .= '
	public function '.str_plural(strtolower($model[$i])).'() {
		return $this->belongsTo("'.$namespace.'", "'.$foreign_key[$i].'");
	}
				';
					break;

				case 'hasMany':
					$relationships .= '
	public function '.str_plural(strtolower($model[$i])).'() {
		return $this->hasMany("'.$namespace.'", "'.$foreign_key[$i].'", "'.$local_key[$i].'");
	}
				';
					break;

				case 'belongsToMany':
					$relationships .= '
	public function '.str_plural(strtolower($model[$i])).'() {
		return $this->belongsToMany("'.$namespace.'", "'.$table[$i].'","'.$local_key[$i].'", "'.$foreign_key[$i].'");
	}
				';
					break;
			}
		}

		return $relationships;
	}

	public function generateNamespaces()
	{
		$models = request('model', []);

		$namespace = "";

		$modelsList = $this->getModelList();
		foreach ($models as $model) {
			if (array_key_exists($model, $modelsList)) {
				$namespace .= "use $modelsList[$model];
				";
			}
		}

		return $namespace;
	}

	private function getModelList()
	{
		$models = $this->file->glob(base_path().'/code/*/Model/*.php');

		$list = [];
		foreach ($models as $model) {
			$splitted          = explode('/', $model);
			$modelName         = end($splitted);
			$modelName         = str_replace('.php', '', end($splitted));
			if (!in_array($modelName, ['AuthenticatableModel', 'Model'])) {
				$list[$modelName] = str_replace(
					[base_path(), '/code', '.php', '/'], 
					['', 'Code', '', '\\'], $model);
			}
		}

		return $list;
	}
}