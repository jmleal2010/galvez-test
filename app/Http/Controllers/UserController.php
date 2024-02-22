<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $credentials = request(['email', 'password']);

        if (!auth()->attempt($credentials)) {
            return response()->json(['error' => 'Credenciales no válidas'], 401);
        }


        $user = Auth::user();
        $token = $user->createToken('access_token')->plainTextToken;

        return response()->json(['user'=>$user, 'token'=>$token], 200);
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->logout();

        return response()->json(['message' => 'Se ha deslogueado satisfactoriamente']);
    }


    /**
     * @param UserRequest $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function register(UserRequest $request): JsonResponse
    {

        try {
           $request->validated();
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->validator->errors()], 422);
        }


        $user = new User();
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->password = Hash::make($request->get('password'));
        $user->email_verified_at = Carbon::now();
        $user->save();

        return $this->login($request);
    }

}
