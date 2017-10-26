<?php 

namespace Sarav\Http\Traits;

use Sarav\Http\Traits\CreateBreadcrumbs;
use Sarav\Http\Traits\CreateControllers;
use Sarav\Http\Traits\CreateModelAndRepository;
use Sarav\Http\Traits\CreateProviders;
use Sarav\Http\Traits\CreateRoute;
use Sarav\Http\Traits\CreateTable;

trait ModuleHelper
{
	use CreateRoute, CreateBreadcrumbs, CreateProviders,
	CreateModelAndRepository, CreateControllers, CreateTable, 
	CreateViews;

	public function createPath()
	{
		$module = $this->qualifiedName();

		$path = base_path().'/code/'. $module;

		$this->checkAndCreate($path);

		$this->basePath = $path.'/';
	}

	public function checkAndCreate($path)
	{
		if (!$this->file->exists($path)) {
			$this->file->makeDirectory($path, 0755, true);
		}
	}

	public function qualifiedName()
	{
		return ucfirst(camel_case(str_singular($this->module)));
	}

	public function pluralName()
	{
		return str_plural($this->module);
	}

	public function pluralLower()
	{
		return strtolower($this->pluralName());
	}

	public function stubsPath()
	{
		return __DIR__.'/../../console/stubs/';
	}
}