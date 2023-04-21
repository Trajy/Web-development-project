<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenApi\Atributes as OA;
use App\Models\Employee;


class EmployeeController extends AuthController
{

    public function index()
    {
        return Employee::all();
    }

    public function show(string $id)
    {
        return Employee::findOrFail($id);
    }

    public function store(Request $request)
    {
        Employee::create($request);
    }

    public function update(Request $request, string $id)
    {
        Employee::update($request, $id);
    }

    public function destroy(string $id)
    {
        Employee::delete($id);
    }

    /**
     * @OA\POST(
     *  tags={"Auth Controller"},
     *  summary="Registrar um novo colaborador",
     *  description="end-point utilizado para registrar um novo colaborador",
     *  path="/api/auth/register",
     *  @OA\RequestBody(
     *      @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              required={"email","password"},
     *              @OA\Property(property="cpf", type="string", example="11222330188"),
     *              @OA\Property(property="name", type="string", example="Fulano"),
     *              @OA\Property(property="surname", type="string", example="De Tal"),
     *              @OA\Property(property="email", type="string", example="teste_usuario@example.org"),
     *              @OA\Property(property="password", type="string", example="1234"),
     *          )
     *      ),
     *  ),
     *  @OA\Response(
     *    response=200,
     *    description="Retorna dados do usuario e dados do colaborador",
     *  ),
     * @OA\Response(
     *    response=500,
     *    description="Interna Server Error",
     *  ),
     * )
     */
    public function register(Request $request)
    {   $user = parent::register($request);
        $values = $request->only('name', 'surname', 'cpf', 'birth_date');
        $values['user_id'] = $user->id;
        $employee = Employee::create($values);
        if(!$employee) {
            abort(418, 'Register Fail');
        }
        return response()->json([$employee, $user]);
    }

}
