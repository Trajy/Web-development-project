<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employer;

class EmployerController extends AuthController
{

    public function index()
    {
        return Employer::all();
    }

    public function show(string $id)
    {
        return Employer::findOrFail($id);
    }

    public function store(Request $request)
    {
        Employer::create($request);
    }

    public function update(Request $request, string $id)
    {
        Employer::update($request, $id);
    }

    public function destroy(string $id)
    {
        Employer::delete($id);
    }

    /**
     * @OA\POST(
     *  tags={"AuthController"},
     *  summary="Registrar um novo empregador",
     *  description="end-point utilizado para registrar um novo empregador",
     *  path="/api/auth/employer/register",
     *  @OA\RequestBody(
     *      @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              required={"email","password"},
     *              @OA\Property(property="cnpj", type="string", example="11222333000188"),
     *              @OA\Property(property="bussiness_name", type="string", example="Empresa Tal"),
     *              @OA\Property(property="fansasy_name", type="string", example="Tal Empresa"),
     *              @OA\Property(property="name", type="string", example="Tal Empresa"),
     *              @OA\Property(property="email", type="string", example="teste_usuario@example.org"),
     *              @OA\Property(property="password", type="string", example="1234"),
     *          )
     *      ),
     *  ),
     *  @OA\Response(
     *    response=200,
     *    description="Retorna dados do usuario e dados do empregador",
     *  ),
     * @OA\Response(
     *    response=500,
     *    description="Interna Server Error",
     *  ),
     * )
     */
    public function register(Request $request)
    {
        $user = parent::register($request);
        $values = $request->only('cnpj', 'bussiness_name', 'fantasy_name');
        $values['user_id'] = $user->id;
        $employer = Employer::create($values);
        if(!$employer) {
            abort(418, 'Register Fail');
        }
        return response()->json([$employer, $user]);
    }

}
