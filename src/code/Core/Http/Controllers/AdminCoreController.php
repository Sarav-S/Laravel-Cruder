<?php

namespace Code\Core\Http\Controllers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Http\FormRequest;

abstract class AdminCoreController extends Controller
{
    protected $repo;

    protected $module = null;

    protected $route = null;

    protected $view = null;

    abstract public function rules();

    public function inputs()
    {
        return request()->all();
    }

    public function __construct()
    {
        View::share('model', $this->repo->makeModel());
    }

    public function index()
    {
        $records = $this->repo->paginate();

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
        $this->validateInputs($this->inputs(), $this->rules());

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
        if (function_exists('rulesForUpdation')) {
            $this->validateInputs($this->inputs(), $this->rulesForUpdation());
        } else {
            $this->validateInputs($this->inputs(), $this->rules());
        }

        return $this->repo->save($id);
    }

    public function destroy($id)
    {
        return $this->repo->destroy($id);
    }

    public function validateInputs($inputs, $rules)
    {
        $validator = Validator::make($inputs, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
