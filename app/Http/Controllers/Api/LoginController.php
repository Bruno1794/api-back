<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //Login
    public function login(Request $request): JsonResponse
    {
        /*Verifico se exite no banco de dados*/
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            /*Pega os dados do usario logado*/
            $user = Auth::user();

            //Criar token de autenticação
            $token = $request->user()->createToken('api-backend')->plainTextToken;

            return response()->json([
                'status' => true,
                'token' => $token,
                'user' => $user,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Usuario ou senha Incorretos'
            ], 400);
        }
    }
    /*fim*/

    /*Logout*/
    public function logout(): JsonResponse
    {
        try {

            $userLogado = Auth::check();

            if ($userLogado) {
                $user = User::where('id', Auth::id())->first();
                $user->tokens()->delete();

                return response()->json([
                    'status' => true,
                    'message' => 'Logout realizado'
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Deslogado com sucesso'
                ], 400);
            }
        } catch (\Exception $erro) {

            return response()->json([
                'status' => false,
                'message' => 'Usuario ou senha Incorretos'
            ], 400);
        }
    }
}
