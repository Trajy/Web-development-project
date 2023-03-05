<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Enployment;

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
        Employment::create($request);
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
