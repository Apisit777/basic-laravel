<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function showusers() {
        return view('users.index');
    }

    public function store(Request $request) {
        $request->validate([
            'inputs.*.name' => 'required'
        ],
        [
            'inputs.*.name' => 'The name field is required!'
        ]
    );

        foreach ($request->inputs as $key => $value) {
            User::create($value);
        }

        return back()->with('success', 'The post has been added!');
    }

    public function checkname_brand(Request $request) {

        $data = User::select('id')
            ->where('name', $request->name)
            ->count();

        return response()->json($data > 0 ? false : true);
    }
}
