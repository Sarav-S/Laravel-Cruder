<?php 

namespace Sarav\Http\Traits;

trait CreateRoute
{
	/**
	 * Lists of all routes available for a module
	 *
	 * @var        array
	 */
	protected $routes = [
			"LIST", "CREATE", "STORE", "SHOW", "EDIT", "UPDATE", "DELETE"
	];

	protected function processRoutes()
	{
		return $this->generateRoutesFile();
	}

	private function generateRoutesFile()
	{
		$module = $this->module;

		$controller = $this->qualifiedName().'Controller';

		$string = "Route::resource('".strtolower(str_plural($module))."', 'Admin\\$controller'";

		$exceptRoutes = $this->exceptRoutes();

		if (count($exceptRoutes)) {
			$routeList = "";
			foreach ($exceptRoutes as $route) {
				$routeList .="'".strtolower($route)."',";
			}

			$routeList = rtrim($routeList,',');

			$string = $string .', ["except" => '.$routeList.']';
		}

		$string = $string.');';

		$content = $this->file->get($this->stubsPath().'admin.stub');

		$content = str_replace('DummyAdminRoutes', $string, $content);

		$this->checkAndCreate($this->basePath.'routes');

		/**
		 * Admin routes
		 */
		$this->file->put($this->basePath.'routes/admin.php', $content);

		/**
		 * API routes
		 */
		$this->file->put($this->basePath.'routes/api.php', '');

		/**
		 * Web routes
		 */
		$this->file->put($this->basePath.'routes/web.php', '');
	}

	private function exceptRoutes()
	{
		$selectedRoutes = request('routes');

		return array_diff($this->routes, $selectedRoutes);
	}
}