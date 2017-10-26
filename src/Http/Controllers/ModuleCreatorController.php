<?php 

namespace Sarav\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Sarav\Http\Traits\ModuleHelper;

class ModuleCreatorController extends BaseController 
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests, 
	ModuleHelper;

	protected $file;

	protected $module;

	protected $basePath;

	public function __construct()
	{
		$this->file = app()['files'];
	}

	public function getForm()
	{
		$models = $this->file->glob(base_path().'/code/*/Model/*.php');

		$list = [];

		foreach($models as $model) {
			$splitted = explode('/', $model);
			$model = end($splitted);
			if (!in_array($model, ['Model.php', 'AuthenticatableModel.php'])) {
				$list[] = str_replace('.php', '', $model);
			}
		}

		return view('mc.form', compact('list'));
	}

	public function postForm()
	{
		$this->module = ucfirst(request('module'));

		$this->createPath();

		$this->processRoutes();
		$this->processBreadcrumbs();
		$this->processProviders();
		$this->processModelAndRepository();
		$this->processControllers();
		$this->processTables();
		$this->processViews();

		$module = '\\Code\\'.$this->qualifiedName().'\\Providers\\'.$this->qualifiedName().'ServiceProvider::class';

		return redirect(route('mc.create'))->with([
			'success' => 'Module created successfully. Please paste 
			<span class="label label-default">'.$module.'</span> to CoreServiceProvider'
		]);
	}

	public function initializeCoreModules()
	{
		$sourceFolder      = __DIR__.'/../../code';
		$destinationFolder = base_path().'/code';

		\File::copyDirectory($sourceFolder, $destinationFolder);

		return redirect(route('mc.create'))->with([
			'success' => 'Files copied to <i>code</i> directory'
		]);
	}

	public function generateRoutes()
	{
		if (!request('module')) {
			return response()->json([
				'status' => false
			]);
		}
		$module = strtolower(request('module'));

		$plural = str_plural($module);

		return response()->json([
			"status" => true,
			"routes" => [
				[
					"action" => "LIST",
					"name"   => "admin.$plural.index",
					"explanation" => "Ability to view ".strtolower($module)." listings"
				],
				[
					"action" => "CREATE",
					"name"   => "admin.$plural.create",
					"explanation" => "Ability to create new ".strtolower($module)
				],
				[
					"action" => "STORE",
					"name"   => "admin.$plural.store",
					"explanation" => "Ability to save new ".strtolower($module)
				],
				[
					"action" => "SHOW",
					"name"   => "admin.$plural.show",
					"explanation" => "Ability to view ".strtolower($module)
				],
				[
					"action" => "EDIT",
					"name"   => "admin.$plural.edit",
					"explanation" => "Ability to edit ".strtolower($module)
				],
				[
					"action" => "UPDATE",
					"name"   => "admin.$plural.update",
					"explanation" => "Ability to update ".strtolower($module)
				],
				[
					"action" => "DELETE",
					"name"   => "admin.$plural.destroy",
					"explanation" => "Ability to delete ".strtolower($module)
				]
			]
		]);
	}

	public function test()
	{
		$this->module = request('module');

		$this->createPath();

		$this->processRoutes();
		$this->processBreadcrumbs();
		$this->processProviders();
		$this->processModelAndRepository();
		$this->processControllers();
		$this->processTables();
	}	
}