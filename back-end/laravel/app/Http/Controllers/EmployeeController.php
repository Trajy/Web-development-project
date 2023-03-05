<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Enployee;

class EmployeeController extends Controller
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
        EmployeeL::create($request);
    }

    public function update(Request $request, string $id)
    {
        Employee::update($request, $id);
    }

    public function destroy(string $id)
    {
        Employee::delete($id);
    }

}
