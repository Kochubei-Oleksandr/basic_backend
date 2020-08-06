<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

abstract class BaseController extends Controller
{
    protected string $modelClassController;
    protected object $baseModel;
    protected string $requestClassController = '';
    protected array $validationRules = [];

    public function __construct()
    {
        $this->baseModel = new $this->modelClassController;
        if ($this->requestClassController) {
            $requestClass = new $this->requestClassController;
            $this->validationRules = $requestClass->rules();
        }
    }

    public function getAll(Request $request)
    {
        return $this->baseModel->getCollections($request)->get();
    }

    public function getOne(Request $request)
    {
        return $this->baseModel->getCollections($request)->first();
    }

    public function createOne(Request $request)
    {
        if ($this->isValidateError($request)) {
            return $this->isValidateError($request);
        }

        return $this->baseModel->createOne($request);
    }

    public function updateOne(Request $request)
    {
        if ($this->isValidateError($request)) {
            return $this->isValidateError($request);
        }

        return $this->baseModel->updateOne($request, Auth::id())
            ?: $this->responseWithError('This record does not belong to you', 403);
    }

    public function deleteOne(Request $request)
    {
        return $this->baseModel->deleteOne($request, Auth::id())
            ?: $this->responseWithError('This record does not belong to you', 403);
    }

    public function isValidateError (Request $request) {
        $validator = Validator::make($request->all(), $this->validationRules);

        return $validator->fails()
            ? response()->json($validator->errors(), 422)
            : false;
    }

    protected function successResponse($responseData)
    {
        return response()->json($responseData, 200);
    }

    protected function responseWithError(string $error, int $code)
    {
        return response()->json(['error' => $error], $code);
    }
}
