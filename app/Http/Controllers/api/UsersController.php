<?php

namespace App\Http\Controllers\api;
use App\Models\User;
use App\Models\Tent;
use App\models\ttb_booking;
use App\models\food;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function showusers() {
        return view('users.index');
    }

    public function users()
    {
        $users = User::select(
            'users.*'
        )
        ->get();

        // $ttb_booking = ttb_booking::select(
        //     'ttb_booking.*'
        // )
        // ->get();

        // dd($users->pluck('name')->toArray());
        return response()->json($users);
    }

    public function foods()
    {
        // $trashFood = food::onlyTrashed()->get();
        $users = food::select(
            'food.*'
        )
        ->get();
        
        // ->pluck('name')
        // ->toArray();

        return response()->json($users);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'price' => 'required'
        ]);

        return food::create($request->all());
    }

    public function showfood($id)
    {
        return food::find($id);
    }

    public function updatefood(Request $request, $id)
    {
        $food = food::find($id);
        $food->update($request->all());
        return $food;
    }

    // public function store(Request $request) 
    // {
    //     $success = 0;
    //     $fail = 0;
    //     $fail_id_arr = [];
    //     $message = [];

    //     if(!isset($request->all()[0]) && $request->reference_id != NULL) {
    //         $qequest = [$request->all()[0]];
    //     } elseif (isset($request->all()[0])) {
    //         $request = $request->json();
    //     } else {
    //         $request = $request->json();
    //         $fail++;
    //     }

    //     // dd($request);
    //     foreach($request as $key => $value) {
    //         DB::beginTransaction();
    //         try {
    //             $validator = Validator::make($value, [
    //                 'reference_id' => 'required',
    //                 'car_brand' => 'required',
    //                 'car_model' => 'required',
    //             ]);
                
    //             // dd($value->id);

    //             if($validator->fails()) {
    //                 $fail++;
    //                 array_push($fail_id_arr, $value['reference_id']);
    //                 $message[$value['reference_id']] = $validator->errors()->all();
    //                 continue;
    //             }

    //             // $food = food::find($request->id);
    //             // if($food == null){
    //             //     $food = new food;
    //             // }

    //             // $food->name = $request->name;
    //             // $food->price = $request->price;
    //             // $food->save();

    //             $create_ttb_booking = ttb_booking::find($value->id);
    //             if($create_ttb_booking == null){
    //                 $create_ttb_booking = new ttb_booking;
    //             }

    //             $create_ttb_booking->reference_id = $value['reference_id']; 
    //             $create_ttb_booking->car_brand = $value['car_brand'];
    //             $create_ttb_booking->car_model = $value['car_model'];
    //             $create_ttb_booking->save();

    //             // $create_ttb_booking = ttb_booking::find($value->id);
    //             // if($create_ttb_booking == null){
    //             //     $create_ttb_booking = new ttb_booking;
    //             // }
    //             // $create_ttb_booking = [
    //             //     'reference_id' => $value['reference_id'],
    //             //     'car_brand' => $value['car_brand'],
    //             //     'car_model' => $value['car_model'],
    //             // ];
    //             // $ttb_booking = ttb_booking::update($create_ttb_booking);

    //             $success++;
    //             DB::commit();
    //         } catch(\Exception $e) {
    //             $fail++;
    //             array_push($fail_id_arr, $value['reference_id']);
    //             $message[$value['reference_id']] = 'Server Error!'.$e;
    //             DB::rollBack();
    //         }
    //     }
    //     return response()->json(['Success' => $success, 'Fail' => $fail, 'Fail_id_arr' => $fail_id_arr, 'Message' => $message]);
    // }

    public function update(Request $request)
    {
        $success = 0;
        $fail = 0;
        $fail_id_arr = [];
        $message = [];

        if(!isset($request->all()[0]) && $request->name != NULL) {
            $qequest = [$request->all()[0]];
        } elseif (isset($request->all()[0])) {
            $request = $request->json();
        } else {
            $request = $request->json();
            $fail++;
        }

        foreach($request as $key => $value) {
            DB::beginTransaction();
            try {
                $validator = Validator::make($value, [
                    'name' => 'required',
                    'price' => 'required'
                ]);

                if($validator->fails()) {
                    $fail++;
                    array_push($fail_id_arr, $value['name']);
                    $message[$value['name']] = $validator->errors()->all();
                    continue;
                }

                $food = food::find($value['id']);
                if($food == null) {
                    $food = new food;
                }

                $food['name'] = $value['name'];
                $food['price'] = $value['price'];
                $food->save();

                $success++;
                DB::commit();
            } catch (\Exception $e) {
                $fail++;
                array_push($fail_id_arr, $value['name']);
                $message[$value['name']] = 'Server Error!'.$e;
                DB::rollBack();
            }
        }
        return response()->json(['Success' => $success, 'Fail' => $fail, 'Fail_id_arr' => $fail_id_arr, 'Message' => $message]);
    }

    // public function tents()
    // {
    //     $tents = Tent::select(
    //         'tents.*'
    //     )
    //     ->pluck('company_name')->toArray();

    //     return response()->json($tents);
    // }
}
