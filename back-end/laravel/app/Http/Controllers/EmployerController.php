<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employer;

class EmployerController extends AuthController
{

    private const DEFAULT_PAGINATION_LENGTH = 10;

    /**
     * @OA\GET(
     *  tags={"EmployerController"},
     *  summary="Obter dados de todos os empregadores",
     *  description="end-point para obter os dados de todos os empregadores",
     *  path="/api/employers",
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
     *    description="Retorna uma lista com objetos contendo os dados dos empregadores",
     *    @OA\JsonContent(
     *       type="array",
     *       @OA\Items(
     *           @OA\Property(property="id", type="number", example=1),
     *           @OA\Property(property="cnpj", type="string", example="11222333000181"),
     *           @OA\Property(property="bussiness_name", type="string", example="Empresa Tal"),
     *           @OA\Property(property="fantasy_name", type="string", example="Tal Empresa"),
     *           @OA\Property(property="user_id", type="number", example="8"),
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
        return Employer::simplePaginate(self::DEFAULT_PAGINATION_LENGTH)->items();
    }

    /**
     * @OA\GET(
     *  tags={"EmployerController"},
     *  summary="Obter dados de um empregador especifico com base no id",
     *  description="end-point para obter os dados referentes a um determinado empregador",
     *  path="/api/employers/{id}",
     *  @OA\Parameter(
     *      name="id",
     *      description="id do empregador",
     *      in = "path",
     *      required=true,
     *      @OA\Schema(
     *          type="integer"
     *      )
     *  ),
     *  @OA\Response(
     *    response=200,
     *    description="Retorna os dados do empregador",
     *    @OA\JsonContent(
     *       @OA\Property(property="id", type="number", example=1),
     *       @OA\Property(property="cnpj", type="string", example="11222333000181"),
     *       @OA\Property(property="bussiness_name", type="string", example="Empresa Tal"),
     *       @OA\Property(property="fantasy_name", type="string", example="Tal Empresa"),
     *       @OA\Property(property="user_id", type="number", example="8"),
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
        return Employer::findOrFail($id);
    }

    /**
     * @OA\PUT(
     *  tags={"EmployerController"},
     *  summary="Alterar dados do empregador",
     *  description="end-point utilizado para alterar os dados de um empregador",
     *  path="/api/employer/{id}",
     *  security={ {"bearerToken":{}} },
     *  @OA\Parameter(
     *      name="id",
     *      description="id do empregador",
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
     *              required={"name","surname", "cnpj"},
     *              @OA\Property(property="bussiness_name", type="string", example="Arcor Tintas Ltda."),
     *              @OA\Property(property="fantasy_name", type="string", example="Poly Still"),
     *              @OA\Property(property="cnpj", type="string", example="14627652373023"),
     *              @OA\Property(property="pais", type="string", example="Brasil"),
     *              @OA\Property(property="state", type="string", example="Rio de Janeiro"),
     *              @OA\Property(property="city", type="string", example="Copacabana"),
     *              @OA\Property(property="address", type="string", example="Rua Explendor"),
     *              @OA\Property(property="number", type="string", example="132"),
     *              @OA\Property(property="neighborhood", type="string", example="Sao Dias"),
     *              @OA\Property(property="phone", type="string", example="11934215738"),
     *          )
     *      ),
     *  ),
     *  @OA\Response(
     *    response=204,
     *    description="No Content",
     *  ),
     * @OA\Response(
     *    response=403,
     *    description="Forbiden (Ao tentar utilizar um token do tipo empregador/employer ou tentar alterar dados nao pertencentes a este usuario)",
     *  ),
     * @OA\Response(
     *    response=500,
     *    description="Interna Server Error",
     *  ),
     * )
     */
    public function update(Request $request, string $id)
    {
        $employer = self::show($id);
        if(auth()->user()->id == $employer->user_id)
        {
           $employer->update($request->only(
                'cnpj', 'bussiness_name', 'fantasy_name', 'user_id',
                'country', 'cep', 'state', 'city','address',
                'neighborhood', 'number', 'phone'
                )
            );
            return response(null, 204);
        }
        else {
            return abort(403, 'Unauthorized');
        }
    }

    /**
     * @OA\DELETE(
     *  tags={"EmployerController"},
     *  summary="Deletar conta do empregador",
     *  description="end-point utilizado para deletar a propria conta empregador (Apenas a conta proprietaria do token de autorizacao pode ser deletada).",
     *  path="/api/employers/{id}",
     *  security={ {"bearerToken":{}} },
     *  @OA\Parameter(
     *      name="id",
     *      description="id do empregador",
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
        $employer = Employer::findOrFail($id);
        if($user->id == $employer->user_id) {
            $employer->delete();
            return response(null, 204);
        }
        else {
            return abort(403, 'Unauthorized');
        }
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
     *              @OA\Property(property="fantasy_name", type="string", example="Tal Empresa"),
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
