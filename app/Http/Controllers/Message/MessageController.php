<?php

namespace App\Http\Controllers\Message;

use App\Http\Controllers\BaseController;
use App\Http\Requests\MessageRequest;
use App\Models\User;
use App\Services\MessageService;
use Illuminate\Http\Request;

class MessageController extends BaseController
{
    /**
     * the name of the model must be indicated in each controller
     * @var string
     */
    protected string $modelClassController = User::class;

    /**
     * the name of the request must be indicated if need validation
     * @var string
     */
    protected string $requestClassController = MessageRequest::class;

    public function createOne(Request $request) {
        if ($this->isValidateError($request)) {
            return $this->isValidateError($request);
        }

        $sendMessage = MessageService::sendToTelegram($request->name, $request->message, $request->email);

        if ($sendMessage['isError'] === true) {
            return $this->responseWithError($sendMessage['message'], 500);
        }

        return $sendMessage;
    }
}
