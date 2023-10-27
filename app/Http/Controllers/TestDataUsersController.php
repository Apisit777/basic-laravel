<?php

namespace App\Http\Controllers;

use App\Models\TestDataUsers;
use Illuminate\Http\Request;
use App\Imports\PGUsersImport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
// use Excel;

class TestDataUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function importForm() {
        return view('users.import_form');
    }

    public function saveImportFile(Request $request) {

        // Excel::import(new PGUsersImport, $request->file('file'));
        // return "Data imported";

        if ($request->file('pg_users')) {
            DB::beginTransaction();
            try {
                ini_set('max_execution_time', 300);
                // dd($request->file('pg_users'));
                Excel::import(new PGUsersImport, $request->file('pg_users'));

                // Excel::import(new BizcarsImport($request->branch), $request->file('pg_users'));
                // Bizcar::whereNull('created_by')->update(['created_by' => Auth::user()->id]);
                // BizcarHistory::whereNull('created_by')->delete();

                DB::commit();
                return response()->json(true);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['message' => 'Line '.$e->getLine().' => '.$e->getMessage()], 500);
            }
        } else {
            return response()->json(['message' => 'File required.'], 422);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TestDataUsers  $testDataUsers
     * @return \Illuminate\Http\Response
     */
    public function show(TestDataUsers $testDataUsers)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TestDataUsers  $testDataUsers
     * @return \Illuminate\Http\Response
     */
    public function edit(TestDataUsers $testDataUsers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TestDataUsers  $testDataUsers
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TestDataUsers $testDataUsers)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TestDataUsers  $testDataUsers
     * @return \Illuminate\Http\Response
     */
    public function destroy(TestDataUsers $testDataUsers)
    {
        //
    }
}
