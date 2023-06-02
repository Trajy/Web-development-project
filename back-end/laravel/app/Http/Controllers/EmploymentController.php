<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employment;
use Illuminate\Support\Facades\DB;

class EmploymentController extends Controller
{

    private const DEFAULT_PAGINATION_LENGTH = 10;

    /**
     * @OA\GET(
     *  tags={"EmploymentController"},
     *  summary="Obter todas as vagas cadastradas no sistema (Acesso publico para a area nao logada)",
     *  description="end-point os dados referentes as vagas do colaborador ou empregador logado utilizando o token de autorizacao",
     *  path="/api/employments",
     *  @OA\Response(
     *    response=200,
     *    description="Retorna um array de objetos com os dados referentes as vagas (Acesso publico)",
     *    @OA\JsonContent(
     *       type="array",
     *       @OA\Items(
     *           @OA\Property(property="id", type="number", example=1),
     *           @OA\Property(property="office", type="string", example="Gerente"),
     *           @OA\Property(property="description", type="string", example="Descricao da vaga como atribuicoes e responsabilidades"),
     *           @OA\Property(property="salary", type="number", example=6000.00),
     *           @OA\Property(property="created_at", type="string", example="2023-03-05T21:48:55.000000Z"),
     *           @OA\Property(property="updated_at", type="string", example="2023-03-05T21:48:55.000000Z"),
     *       ),
     *    )
     *  ),
     * @OA\Response(
     *    response=500,
     *    description="Internal Server Erro",
     *  ),
     * )
     */
    public function index()
    {
        return Employment::filter()->simplePaginate(self::DEFAULT_PAGINATION_LENGTH)->items();
    }

    /**
     * @OA\GET(
     *  tags={"EmploymentController"},
     *  summary="Obter as vagas do colaborador ou empregador com base no token",
     *  description="end-point os dados referentes as vagas do colaborador ou empregador logado utilizando o token de autorizacao",
     *  path="/api/employments/me",
     *  security={ {"bearerToken":{}} },
     *  @OA\Response(
     *    response=200,
     *    description="Retorna um array de objetos com os dados referentes as vagas",
     *    @OA\JsonContent(
     *       type="array",
     *       @OA\Items(
     *           @OA\Property(property="id", type="number", example=1),
     *           @OA\Property(property="office", type="string", example="Gerente"),
     *           @OA\Property(property="description", type="string", example="Descricao da vaga como atribuicoes e responsabilidades"),
     *           @OA\Property(property="salary", type="number", example=6000.00),
     *           @OA\Property(property="created_at", type="string", example="2023-03-05T21:48:55.000000Z"),
     *           @OA\Property(property="updated_at", type="string", example="2023-03-05T21:48:55.000000Z"),
     *       ),
     *    )
     *  ),
     * @OA\Response(
     *    response=401,
     *    description="Retorno caso o token nao esteja registrado",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Unauthenticated."),
     *    )
     *  ),
     * )
     */
    public function showMe() {
        $user = auth()->user();
        if($user->type == 'employer') {
            return Employment::where('user_id', $user->id)->get()->simplePaginate(self::DEFAULT_PAGINATION_LENGTH)->items();
        } else {
            $employee_id = DB::table('employees')->where('user_id', $user->id)->first()->id;
            return DB::table('employees_employments')->where('employee_id', $employee_id)->get()->simplePaginate(self::DEFAULT_PAGINATION_LENGTH)->items();
        }
    }

    /**
     * @OA\GET(
     *  tags={"EmploymentController"},
     *  summary="Obter vaga especifica com base no id",
     *  description="end-point os dados referentes as vagas do colaborador ou empregador logado utilizando o token de autorizacao",
     *  path="/api/employments/{id}",
     *  @OA\Parameter(
     *      name="id",
     *      description="id da vaga cadastrada",
     *      in = "path",
     *      required=true,
     *      @OA\Schema(
     *          type="integer"
     *      )
     *  ),
     *  @OA\Response(
     *    response=200,
     *    description="Retorna os dados de uma vaga especifica",
     *    @OA\JsonContent(
     *       @OA\Property(property="id", type="number", example=1),
     *       @OA\Property(property="office", type="string", example="Gerente"),
     *       @OA\Property(property="description", type="string", example="Descricao da vaga como atribuicoes e responsabilidades"),
     *       @OA\Property(property="salary", type="number", example=6000.00),
     *       @OA\Property(property="created_at", type="string", example="2023-03-05T21:48:55.000000Z"),
     *       @OA\Property(property="updated_at", type="string", example="2023-03-05T21:48:55.000000Z"),
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
        return Employment::findOrFail($id);
    }

    /**
     * @OA\POST(
     *  tags={"EmploymentController"},
     *  summary="Registrar uma nova vaga",
     *  description="end-point utilizado para registrar uma nova vaga (apenas empregadores)",
     *  path="/api/employments",
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
     *    @OA\Header(
     *       header="Location",
     *       description="url para acessar a vaga",
     *       @OA\Schema(type="string")
     *    ),
     *  ),
     * @OA\Response(
     *    response=403,
     *    description="Forbiden (Ao tentar utilizar um token do tipo colaborador/employee)",
     *  ),
     * @OA\Response(
     *    response=500,
     *    description="Interna Server Error",
     *  ),
     * )
     */
    public function store(Request $request)
    {
        $values = $request->all();
        $values['user_id'] = auth()->user()->id;
        $model = Employment::create($values);
        return response(null, 204, ['Location' => request()->path().'/'.$model->id]);
    }

    /**
     * @OA\PUT(
     *  tags={"EmploymentController"},
     *  summary="Alterar uma vaga",
     *  description="end-point utilizado para alterar os dados da vaga (apenas empregadores)",
     *  path="/api/employments/{id}",
     *  security={ {"bearerToken":{}} },
     *  @OA\Parameter(
     *      name="id",
     *      description="id da vaga cadastrada",
     *      in = "path",
     *      required=true,
     *      @OA\Schema(
     *          type="integer"
     *      )
     *  ),
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
        $employment = EmploymentController::show($id);
        if(auth()->user()->id == $employment->user_id) {
            EmploymentController::show($id)->update($request->all());
            return response(null, 204);
        }
        else {
            return abort(403, 'Unauthorized');
        }
    }

    /**
     * @OA\DELETE(
     *  tags={"EmploymentController"},
     *  summary="Deletar uma vaga",
     *  description="end-point utilizado para deletar os dados da vaga (apenas empregadores)",
     *  path="/api/employments/{id}",
     *  security={ {"bearerToken":{}} },
     *  @OA\Parameter(
     *      name="id",
     *      description="id da vaga",
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
     *    description="Forbiden (Ao tentar utilizar um token do tipo colaborador/employee ou tentar deletar uma vaga que nao pertence a este usuario)",
     *  ),
     * @OA\Response(
     *    response=500,
     *    description="Interna Server Error",
     *  ),
     * )
     */
    public function destroy(string $id)
    {
        $employment = EmploymentController::show($id);
        if(auth()->user()->id == $employment->user_id) {
            EmploymentController::show($id)->delete();
            return response(null, 204);
        }
        else {
            return abort(403, 'Unauthorized');
        }
    }
}
