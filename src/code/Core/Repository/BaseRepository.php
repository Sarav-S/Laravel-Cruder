<?php

namespace Code\Core\Repository;

use Bosnadev\Repositories\Eloquent\Repository;
use Illuminate\Container\Container as App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;

abstract class BaseRepository extends Repository
{

    /**
     * @param App $app
     * @param Collection $collection
     * @throws \Bosnadev\Repositories\Exceptions\RepositoryException
     */
    public function __construct(App $app, Collection $collection)
    {
        parent::__construct($app, $collection);
    }

    abstract protected function setFallBack();

    abstract protected function module();



    /**
     * Returns the fallback url. This is used when user performs
     * create, edit or delete action we will redirect him back to
     * this url
     *
     * @return  String
     */
    public function getFallBack() : string
    {
        return $this->setFallBack();
    }

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return $this->assignModel();
    }

    /**
     * Returns the latest records
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function latest()
    {
        $this->applyCriteria();
        return $this->model->latest($this->model->getKeyName())->get();
    }

    /**
     * @return $this
     */
    public function applyCriteria()
    {
        View::share('model', $this->model);

        if ($this->skipCriteria === true) {
            return $this;
        }

        foreach ($this->getCriteria() as $criteria) {
            if ($criteria instanceof Criteria) {
                $this->model = $criteria->apply($this->model, $this);
            }
        }

        return $this;
    }

    /**
     * This function saves the record.
     *
     * @param      integer|null  $id     The identifier
     *
     * @return     \Illuminate\Http\RedirectResponse
     */
    public function save($id = null)
    {
        $record = $this->findOrCreate($id);

        if (!$record) {
            return $this->returnNotFound();
        }

        $record = $this->beforeSave($record);

        try {
            if ($record->save()) {
                $this->afterSave($record);
                $record->save();
                success(str_singular($this->module()).' saved successfully.');
            } else {
                error('Unable to save '.str_singular($this->module()).'. Please try again');
            }
        } catch (\Exception $e) {
            logger($e);
            error('Sorry. Something went wrong. Please check your log file');
        }

        return redirect($this->getFallBack());
    }

    /**
     * Deletes the given record
     *
     * @param      integer  $id     The identifier
     *
     * @return     \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if (is_null($id)) {
            error('Invalid parameter passed. Please try again');
            return redirect($this->getFallBack());
        }

        $record = $this->model->find($id);

        if (!$record) {
            return $this->returnNotFound();
        }

        $this->beforeDelete($record);

        $id = $record->id;

        try {
            if ($record->delete()) {
                $this->afterDelete($id);
                success(str_singular($this->module()).' deleted successfully.');
            } else {
                error('Unable to delete '.str_singular($this->module()).'. Please try again');
            }
        } catch (\Exception $e) {
            error("Sorry. Something went wrong. Please check your log file");
        }


        return redirect($this->getFallBack());
    }

    /**
     * This finds and creates new instance for the given id. But
     * know that, this is different from findOrNew. Because if given
     * id is not found we are gonna throw record not found message
     *
     * @param      integer|mixed  $id     The identifier
     *
     * @return     \Illuminate\Database\Eloquent\Model
     */
    protected function findOrCreate($id)
    {
        if (is_null($id)) {
            $record = $this->model;
        } else {
            $record = $this->model->find($id);
        }

        return $record;
    }

    /**
     * Handles the before save logic for the record
     *
     * @param      \Illuminate\Database\Eloquent\Model  $record  The record
     *
     * @return     \Illuminate\Database\Eloquent\Model
     */
    protected function beforeSave($record)
    {
        return $record;
    }

    /**
     * Handles the after save functionality like saving
     * image of the record after saving the record itself
     * so that user might get id of the recently saved
     * record
     *
     * @param   mixed
     */
    protected function afterSave($record)
    {
    }

    /**
     * This method is called before deletion of the record,
     * so if user needs to perform any action before delete
     *
     * @param   mixed
     */
    protected function beforeDelete($record)
    {
    }

    /**
     * This method is called after deletion of the record,
     * so if user needs to perform any action after delete
     *
     * @param   mixed
     */
    protected function afterDelete($record)
    {
    }

    /**
     * Returns not found message and redirects back to fallback url
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function returnNotFound()
    {
        error(str_singular($this->module()).' not found. Please try again.');

        return redirect($this->getFallBack());
    }
}
