<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
