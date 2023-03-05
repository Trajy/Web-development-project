<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Enployer;

class EmployerController extends Controller
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

}
