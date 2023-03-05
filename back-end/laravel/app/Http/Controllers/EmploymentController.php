<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employment;

class EmploymentController extends Controller
{
    public function index()
    {
        return Employment::all();
    }

    public function show(string $id)
    {
        return Employment::findOrFail($id);
    }

    public function store(Request $request)
    {
        $values = $request->all();
        $values['user_id'] = auth()->user()->id;
        Employment::create($values);
    }

    public function update(Request $request, string $id)
    {
        Employment::update($request);
    }

    public function destroy(string $id)
    {
        Employment::delete($id);
    }
}
