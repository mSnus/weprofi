<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserViewsStoreRequest;
use App\Models\UserFeedback;
use Illuminate\Http\Request;

class UserViewsController extends Controller
{
    /**
     * @param \App\Http\Requests\UserViewsStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserViewsStoreRequest $request)
    {
        $userFeedback = UserFeedback::create($request->all());
    }
}
