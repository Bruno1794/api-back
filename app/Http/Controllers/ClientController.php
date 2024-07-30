<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    //Cadastrar client
    public function store(ClientRequest $request): JsonResponse
    {
        $userLogged = Auth::user();
        DB::beginTransaction();
        try {
            if ($userLogged) {
                $user = Client::create([
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'user_id' => $userLogged->id
                ]);
                DB::commit();
                return response()->json([
                    'success' => true,
                    'user' => $user,
                    'message' => 'Cliente cadastra com sucesso!'
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario não esta logado no sistema'
                ], 400);
            }

        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Falha ao cadastrar'
            ], 400);
        }
    }


    /*Lista Clientes referente ao usuario da sessao*/
    public function index(): JsonResponse
    {
        $userLogged = Auth::user();

        $clients = Client::where('user_id', $userLogged->id)->get();
        return response()->json([
            'success' => true,
            'users' => $clients,
        ], 201);
    }
}
