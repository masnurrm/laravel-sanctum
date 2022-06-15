<?php

namespace App\Http\Controllers;

use App\Exceptions\ExpectedException;
use App\Models\User;
use App\Services\LoginUser\LoginUserRequest;
use App\Services\LoginUser\LoginUserService;
use App\Services\RegisterUser\RegisterUserRequest;
use App\Services\RegisterUser\RegisterUserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class UserController extends Controller
{
    /**
     * @throws Throwable
     */
    public function register(Request $request, RegisterUserService $service): JsonResponse
    {
        $input = new RegisterUserRequest(
            $request->input('username'),
            $request->input('password'),
            $request->input('email')
        );
        DB::beginTransaction();
        try {
            $service->run($input);
        } catch (Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
        DB::commit();
        return $this->success();
    }

    /**
     * @throws Throwable
     * @throws ExpectedException
     */
    public function login(Request $request, LoginUserService $service): JsonResponse
    {
        DB::beginTransaction();
        try {
            $response = $service->run(new LoginUserRequest(
                $request->input('name'),
                $request->input('password')
            ));
        } catch (Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
        DB::commit();
        return $this->successWithData($response);
    }

    /**
     * @throws Throwable
     */
    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();
        DB::beginTransaction();
        try {
            if ($user instanceof User) {
                $user->tokens()->delete();
            } else {
                throw new ExpectedException("error parsing user on server", 1005);
            }
        } catch (Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
        DB::commit();
        return $this->success();
    }
}
