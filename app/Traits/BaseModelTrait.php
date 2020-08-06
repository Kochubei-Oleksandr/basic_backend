<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

trait BaseModelTrait
{
    use CoreBaseModelTrait;

    /**
     * Return a collections of one or more records with or without translation
     *
     * @param Request $request
     * @param null $id
     * @return mixed
     */
    public function getCollections(Request $request, $id = null)
    {
        $params = $request->all();
        $id = $id ? $id : $this->getRequestId($request);

        if (class_exists($this->modelTranslationClass)) {
            $query = $this->getCollectionsWithTranslate($params['language'], $id);
        } else {
            if($id) {
                $query = $this->modelClass::where($this->tablePluralName.'.id', $id);
            } else {
                $query = new $this->modelClass;
            }
        }

        if (array_key_exists('order_by', $params)) {
            $query = $query->orderBy('id', $params['order_by']);
        }
        $params = $this->getQueryParams($this->filteringForParams($params));

        return $query->where($params);
    }

    /**
     * Creating a new record in the database
     * Return the created record
     *
     * @param Request $request
     * @return mixed
     */
    public function createOne(Request $request)
    {
        if(!$request->has('date')) {
            $request->merge(["date" => date("Y-m-d")]);
        }
        $request->merge(["user_id" => Auth::id()]);

        $model = new $this->modelClass;
        $model->fill($request->all());
        $model->save();

        return $model;
    }

    /**
     * Updates the model and then returns it (with checking for compliance of the record to the user)
     *
     * @param Request $request
     * @param string $columnName - column name to check whether a record matches a specific user
     * @param $valueForColumnName - column value to check whether a record matches a specific user
     * @return bool|mixed
     */
    public function updateOne(Request $request, $valueForColumnName, string $columnName = 'user_id')
    {
        if ($model = $this->getOneRecord($this->getRequestId($request))) {
            return $this->isRecordBelongToUser($model, $columnName, $valueForColumnName)
                ? $this->updateOneRecord($request->all(), $model)
                : false;
        } else {
            return false;
        }
    }

    /**
     * Delete one record with checking for compliance of the record to the user
     *
     * @param string $columnName - column name to check whether a record matches a specific user
     * @param $valueForColumnName - column value to check whether a record matches a specific user
     * @param Request $request
     * @return bool
     */
    public function deleteOne(Request $request, $valueForColumnName, string $columnName = 'user_id')
    {
        if ($model = $this->getOneRecord($this->getRequestId($request))) {
            return $this->isRecordBelongToUser($model, $columnName, $valueForColumnName)
                ? $model->delete()
                : false;
        } else {
            return false;
        }
    }
}
