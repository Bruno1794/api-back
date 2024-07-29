<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /*LISTANDO TODOS OS REGISTRO DA TABELA USER*/
    public function index(): JsonResponse
    {
        $userAll = User::get();
        return response()->json([
            'success' => true,
            'users' => $userAll
        ], 200);
    }

    /*FIM*/

    /*alterando registro*/
    public function update(UserRequest $request, User $user): JsonResponse
    {
        DB::beginTransaction();
        try {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
            DB::commit();
            return response()->json([
                'success' => true,
                'users' => $user,
                'message' => 'usuario atualizado com sucesso'
            ], 200);

        }catch (\Exception $erro){
            DB::rollBack();
            return response()->json([
                'success' => false,
                'users' => $user,
                'message' => 'erro ao atualizar usuario'
            ], 200);
        }

    }
    /*FIM*/

    /*CADASTRA USUARIO DENTRO DO BANCO DE DADOS*/
    public function store(UserRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            DB::commit();
            return response()->json([
                'success' => true,
                'User' => $user,
                'message' => 'Usuario Criado com Sucesso!'
            ], 201);
        } catch (\Exception $erro) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Falha ao registrar o usuario!'
            ], 400);
        }
    }
    /*FIM*/

    /*DELETANDO REGISTRO*/
    public function destroy(User $user): JsonResponse
    {
        DB::beginTransaction();
        try {
            $user->delete();
            DB::commit();

            return response()->json([
                'success' => true,
                'User' => $user,
                'message' => 'Usuario Removido com Sucesso!'
            ]);

        }catch (\Exception $err){
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'falha ao remover o usuario!'
            ]);
        }

    }
    /*FIM*/

}
