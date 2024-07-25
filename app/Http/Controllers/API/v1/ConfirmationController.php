<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\MainController;
use App\Http\Requests\ConfirmationRequest;
use App\Services\ConfirmationService;
use Illuminate\Http\Request;

class ConfirmationController extends MainController
{
    public function send(ConfirmationRequest $request, ConfirmationService $service)
    {
        return $this->handleRequest(function () use ($request, $service) {
            $type = $request->type;
            $user = auth()->user();
            $service->sendConfirmationCode($user, $type);
        });
    }

    public function check(ConfirmationService $service, Request $request)
    {
        return $this->handleRequest(function () use ($service, $request) {
           $service->checkConfirmationCode(auth()->user(), $request->code);
        });
    }
}
