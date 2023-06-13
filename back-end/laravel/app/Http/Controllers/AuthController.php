<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * @OA\Info(
 *   title="Employment Api Documentation",
 *   version="1.0.0",
 * )
 * @OA\SecurityScheme(
 *  type="http",
 *  description="Baerer token obtido na autenticação",
 *  name="Authorization",
 *  in="header",
 *  scheme="bearer",
 *  bearerFormat="JWT",
 *  securityScheme="bearerToken"
 * )
 */
class AuthController extends Controller
{

    public function register(Request $resquest) {
        $values = $resquest->only('name', 'email', 'password');
        $values['type'] = str_contains(url()->current(), 'employer') ? 'employer' : 'employee';
        $user = User::create($values);
        if(!$user) {
            abort(418, 'Register Fail');
        }
        return $user;
    }


    /**
     * @OA\POST(
     *  tags={"AuthController"},
     *  summary="Realizar o login",
     *  description="end-point para obter um token de autorizacao para o usuario",
     *  path="/api/auth/login",
     *  @OA\RequestBody(
     *      @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              required={"email","password"},
     *              @OA\Property(property="email", type="string", example="teste_usuario@example.org"),
     *              @OA\Property(property="password", type="string", example="1234"),
     *          )
     *      ),
     *  ),
     *  @OA\Response(
     *    response=200,
     *    description="Retorna o Token e o tipo do usuario",
     *    @OA\JsonContent(
     *       @OA\Property(property="token", type="string", example="3|4pHV2Eb6zqJs3z6MWqPKmKoF7EUONp4MuJCfJYAt"),
     *       @OA\Property(property="type", type="string", example="employer"),
     *    )
     *  ),
     * @OA\Response(
     *    response=401,
     *    description="Retorna Invalid Credentials",
     *  ),
     * )
     */
    public function login(Request $request) {
        $user = User::where('email', $request->email)->where('password', $request->password)->first();
        if(!$user) {
            abort(401, 'Invalid Credentials');
        }
        $token = $user->createToken('auth_token', [$user->type]);
        return response()->json(['token' => $token->plainTextToken, 'client_type' => $user->type]);
    }

    /**
     * @OA\DELETE(
     *  tags={"AuthController"},
     *  summary="Realizar o logout",
     *  description="end-point para revogar um token de autorizacao",
     *  path="/api/auth/logout",
     *  security={ {"bearerToken":{}} },
     *   @OA\Parameter(
     *         name="Authorization",
     *         in="header",
     *         description="Baerer token que sera revogado",
     *     ),
     *  @OA\Response(
     *    response=200,
     *    description="Retorna o Token e o tipo do usuario",
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
    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();
    }


    /**
     * @OA\GET(
     *  tags={"AuthController"},
     *  summary="Obtem os dados do usuario",
     *  description="end-point obter os dados do usuario logado a partir do token",
     *  path="/api/auth/me",
     *  security={ {"bearerToken":{}} },
     *  @OA\Response(
     *    response=200,
     *    description="Retorna o Token e o tipo do usuario",
     *    @OA\JsonContent(
     *       @OA\Property(property="id", type="number", example=1),
     *       @OA\Property(property="name", type="string", example="Empresa Tal"),
     *       @OA\Property(property="email", type="string", example="fulano-de-tal@exemplo.com"),
     *       @OA\Property(property="email_verified_at", type="string", example="2023-03-05T21:48:55.000000Z"),
     *       @OA\Property(property="type", type="string", example="employer"),
     *       @OA\Property(property="created_at", type="string", example="2023-03-05T21:48:55.000000Z"),
     *       @OA\Property(property="updated_at", type="string", example="2023-03-05T21:48:55.000000Z"),
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
    public function user()
    {
        $user = auth()->user();
        $employerOrEmployee = null;
        if($user->type == 'employer')
        {
            $employerOrEmployee = DB::table('employers')->where('user_id', $user->id)->first();
        }
        else
        {
            $employerOrEmployee = DB::table('employees')->where('user_id', $user->id)->first();
        }
        return [$employerOrEmployee, $user];
    }

}
