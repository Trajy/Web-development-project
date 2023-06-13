<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenApi\Atributes as OA;
use App\Models\Employee;


class EmployeeController extends AuthController
{

    private const DEFAULT_PAGINATION_LENGTH = 10;

    /**
     * @OA\GET(
     *  tags={"EmployeeController"},
     *  summary="Obter dados de todos os colaboradores",
     *  description="end-point para obter os dados de todos os colaboradores",
     *  path="/api/employees",
     *  @OA\Parameter(
     *      name="page",
     *      description="pagina desejada da paginacao",
     *      in = "query",
     *      required=false,
     *      @OA\Schema(
     *          type="integer"
     *      )
     *  ),
     *  @OA\Response(
     *    response=200,
     *    description="Retorna uma lista com objetos contendo os dados dos colaboradores",
     *    @OA\JsonContent(
     *       type="array",
     *       @OA\Items(
     *           @OA\Property(property="id", type="number", example=1),
     *           @OA\Property(property="name", type="string", example="Fulano"),
     *           @OA\Property(property="surname", type="string", example="De Tal"),
     *           @OA\Property(property="salary", type="string", example=12334455690),
     *           @OA\Property(property="user_id", type="number", example="5"),
     *       ),
     *    )
     *  ),
     * @OA\Response(
     *    response=404,
     *    description="Not found",
     *  ),
     * @OA\Response(
     *    response=500,
     *    description="Internal Server Error",
     *  ),
     * )
     */
    public function index()
    {
        return Employee::simplePaginate(self::DEFAULT_PAGINATION_LENGTH)->items();
    }

    /**
     * @OA\GET(
     *  tags={"EmployeeController"},
     *  summary="Obter dados de um colaborador especifico com base no id",
     *  description="end-point para obter os dados referentes a um determinado colaborador",
     *  path="/api/employees/{id}",
     *  @OA\Parameter(
     *      name="id",
     *      description="id do colaborador",
     *      in = "path",
     *      required=true,
     *      @OA\Schema(
     *          type="integer"
     *      )
     *  ),
     *  @OA\Response(
     *    response=200,
     *    description="Retorna os dados do colaborador",
     *    @OA\JsonContent(
     *       @OA\Property(property="id", type="number", example=1),
     *       @OA\Property(property="name", type="string", example="Fulano"),
     *       @OA\Property(property="surname", type="string", example="De Tal"),
     *       @OA\Property(property="salary", type="string", example=12334455690),
     *       @OA\Property(property="user_id", type="number", example="5"),
     *    )
     *  ),
     * @OA\Response(
     *    response=404,
     *    description="Not found",
     *  ),
     * @OA\Response(
     *    response=500,
     *    description="Internal Server Error",
     *  ),
     * )
     */
    public function show(string $id)
    {
        return Employee::findOrFail($id);
    }

    /**
     * @OA\PUT(
     *  tags={"EmployeeController"},
     *  summary="Alterar dados do colaborador",
     *  description="end-point utilizado para alterar os dados de um colaborador",
     *  path="/api/employee",
     *  security={ {"bearerToken":{}} },
     *  @OA\RequestBody(
     *      @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              required={"email","password"},
     *              @OA\Property(property="office", type="string", example="Professor"),
     *              @OA\Property(property="description", type="string", example="Descricao da vaga"),
     *              @OA\Property(property="salary", type="number", example=1800.56),
     *          )
     *      ),
     *  ),
     *  @OA\Response(
     *    response=204,
     *    description="No Content",
     *  ),
     * @OA\Response(
     *    response=403,
     *    description="Forbiden (Ao tentar utilizar um token do tipo colaborador/employee ou tentar alterar uma vaga que nao pertence a este usuario)",
     *  ),
     * @OA\Response(
     *    response=500,
     *    description="Interna Server Error",
     *  ),
     * )
     */
    public function update(Request $request, string $id)
    {
        $employee = self::show($id);
        if(auth()->user()->id == $employee->user_id)
        {
           $employee->update($request->only(
                    'name', 'surname', 'cpf',
                    'nacionality', 'cep', 'number', 'state', 'city',
                    'address', 'neighborhood', 'number', 'phone'
                )
            );
            return response(null, 204);
        }
        else {
            return 'cai no else';
        }
    }

    /**
     * @OA\DELETE(
     *  tags={"EmployeeController"},
     *  summary="Deletar conta do colaborador",
     *  description="end-point utilizado para deletar a propria conta colaborador (Apenas a conta proprietaria do token de autorizacao pode ser deletada).",
     *  path="/api/employees/{id}",
     *  security={ {"bearerToken":{}} },
     *  @OA\Parameter(
     *      name="id",
     *      description="id do colaborador",
     *      in = "path",
     *      required=true,
     *      @OA\Schema(
     *          type="integer"
     *      )
     *  ),
     *  @OA\Response(
     *    response=204,
     *    description="No Content",
     *  ),
     * @OA\Response(
     *    response=403,
     *    description="Forbiden (Ao tentar apagar uma conta que nao seja a propria)",
     *  ),
     * @OA\Response(
     *    response=500,
     *    description="Interna Server Error",
     *  ),
     * )
     */
    public function destroy(string $id)
    {
        $user = auth()->user();
        $employee = Employee::findOrFail($id);
        if($user->id == $employee->user_id) {
            $employee->delete();
            return response(null, 204);
        }
        else {
            return abort(403, 'Unauthorized');
        }
    }

    /**
     * @OA\POST(
     *  tags={"AuthController"},
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
