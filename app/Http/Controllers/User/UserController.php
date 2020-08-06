<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\BaseController;
use App\Http\Requests\User\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    /**
     * the name of the model must be indicated in each controller
     * @var string
     */
    protected string $modelClassController = User::class;
    protected string $requestClassController = UserRequest::class;
    protected User $userModel;

    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
        parent::__construct();
    }

    public function getOne(Request $request)
    {
        return $this->userModel->getPersonalData($request);
    }

    public function updateOne(Request $request)
    {
        if ($this->isValidateError($request)) {
            return $this->isValidateError($request);
        }

        return $this->userModel->updatePersonalData($request)
            ?: $this->responseWithError('This record does not belong to you', 403);
    }
}
