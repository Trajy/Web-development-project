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
