<?php 

namespace Sarav\Http\Traits;

trait CreateViews
{
    public function processViews()
    {
        $formFields = request('formFields', []);

        $modelFields = '';

        $inputs          = request('inputs', []);
        $required        = request('requiredField', []);
        $helpBlock       = request('helpBlock', []);
        $hasRelationship = request('hasFieldRelationship', []);
        $keys            = request('pluckKey', []);
        $models          = request('modelFields', []);
        $display_name    = request('display_name', []);

        foreach ($formFields as $key => $field) {
            $option = '""';
            if (in_array($field, $hasRelationship)) {
                $table = strtolower(str_plural($models[$key]));
                $tableKeys = explode(',', $keys[$key]);
                
                $option = '\DB::table("'.$table.'")->pluck("'.trim($tableKeys[0]).'", "'.trim($tableKeys[1]).'")->toArray()';
            }

            $fieldDetails = '[
				"column"    => "'.$field.'",
				"label"     => "'.((isset($display_name[$key])) ? $display_name[$key] : null).'",
				"input"     => "'.((isset($inputs[$key])) ? $inputs[$key] : null).'",
				"required"  => "'.((in_array($field, $required)) ? 1 : 0).'",
				"helpBlock" => "'.((isset($helpBlock[$key])) ? "{$helpBlock[$key]}" : null).'",
				"value"     => "'.((in_array($inputs[$key], ['checkbox', 'radio'])) ? 1 : null).'",
				"option"    => '.$option.'
			],';

            $modelFields .= $fieldDetails;
        }

        $this->checkAndCreate($this->basePath.'Traits');

        $content = str_replace(
            ['DummyNamespace', 'DummyFields'],
            ['namespace Code\\'.$this->qualifiedName().'\\Traits', $modelFields],
            $this->file->get($this->stubsPath().'fields.stub')
        );

        if (!is_null($content)) {
            $this->file->put(
                $this->basePath.'Traits/Fields.php',
                $content
            );
        }

        $search = collect(
            $this->file->glob(base_path().'/code/'.$this->qualifiedName().'/Model/'.$this->qualifiedName().'.php')
        );

        $file = $search->first();

        $content = null;
        if ($file) {
            $content = str_replace(
                ['FieldNamespace', 'useFieldTrait'],
                ['use Code\\'.$this->qualifiedName().'\\Traits\\Fields;', 'use Fields;
				'],
                $this->file->get($file)
            );

            $this->file->put($this->basePath.'Model/'.$this->qualifiedName().'.php', $content);
        }

        $create = str_replace(
            ['DummyNameSingular', 'DummyNamePlural'],
            [$this->qualifiedName(), $this->pluralLower()],
            $this->file->get($this->stubsPath().'views/create.stub')
        );

        $this->checkAndCreate($this->basePath.'resources/views/'.$this->pluralLower().'/admin/');

        $this->file->put(
            $this->basePath.'resources/views/'.$this->pluralLower().'/admin/create.blade.php',
            $create
        );

        $edit = str_replace(
            ['DummyNameSingular', 'DummyNamePlural'],
            [$this->qualifiedName(), $this->pluralLower()],
            $this->file->get($this->stubsPath().'views/edit.stub')
        );

        $this->file->put(
            $this->basePath.'resources/views/'.$this->pluralLower().'/admin/edit.blade.php',
            $edit
        );

        $this->file->put(
            $this->basePath.'resources/views/'.$this->pluralLower().'/admin/_form.blade.php',
            $this->file->get($this->stubsPath().'views/_form.stub')
        );
    }
}
