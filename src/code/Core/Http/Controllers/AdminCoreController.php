<?php

namespace Code\Core\Http\Controllers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\View;

abstract class AdminCoreController extends Controller {

	protected $repo;

	protected $module = null;

	protected $route = null;

	protected $view = null;

	public abstract function rules();

	public function __construct()
	{
		View::share('model', $this->repo->makeModel());
	}

	public function index()
	{
		$records = $this->repo->latest();

		$module = $this->module;

		if (is_null($this->module)) {
			$module = ucfirst(strtolower(request()->segment(2)));
		}

		return view('admin.index', compact('records', 'module'));
	}

	public function create()
	{
		return view($this->view.'.admin.create');
	}

	public function store()
	{
		$this->validate(request(), $this->rules());

		return $this->repo->save();
	}

    public function show($id)
	{
		$record = $this->repo->find($id);

		return view($this->view.'.admin.show', compact('record'));
	}

	public function edit($id)
	{
		$record = $this->repo->find($id);

		return view($this->view.'.admin.edit', compact('record'));
	}

	public function update($id)
	{
	    if(function_exists('rulesForUpdation')){
            $this->validate(request(), $this->rulesForUpdation());
        }else{
            $this->validate(request(), $this->rules());
        }

		return $this->repo->save($id);
	}

	public function destroy($id)
	{
		return $this->repo->destroy($id);
	}

}