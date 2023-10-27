<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\models\ttb_score_detail;
use App\models\ttb_booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class TtbController extends Controller
{
    private function duplicate_vin($request, $value, $dup_type)
    {
        $exp_year_score = date_create(date('Y-m-d'));
        date_add($exp_year_score, date_interval_create_from_date_string('-365 days'));

        $new_value = ttb_booking::select('ttb_booking.*')
            ->leftjoin('ttb_score_detail', 'ttb_booking.id', 'ttb_score_detail.ttb_booking_id')
            ->where('expiry_date', '>=', $exp_year_score)
            ->where('ttb_booking.license_plate_number', $value['license_plate_number'])
            ->where('ttb_booking.vin', $value['vehicle_identification_number'])
            ->where('ttb_booking.status', 1)
            ->latest('id')
            ->first();

            
        if(!empty($new_value)) {
            $new_value['new_mile_number'] = $value['mile_number'];
            $new_value['appointment_status'] = 5;
            $new_value['reference_id'] = $value['reference_id'];
            $new_value['parent_id'] = $new_value['id'];
            $ttbbooking_id = $new_value['id'];
            unset($new_value['id']);
            unset($new_value['created_at']);
            unset($new_value['updated_at']);

            dd($request);

            $ttb_score_detail = ttb_score_detail::select('*')
                ->where('ttb_booking_id', $ttbbooking_id)
                ->whereNotNull('expiry_date')
                ->first();

            if ($ttb_score_detail) {
                $now_date = date_create(date('Y-m-d'));
                $exp_date = date_create($ttb_score_detail->expiry_date);
                $exp_year = date_create($ttb_score_detail->expiry_date);

                date_add($exp_date, date_interval_create_from_date_string('-7 days'));
                date_add($exp_year, date_interval_create_from_date_string('+365 days'));

                if ('renew' == $dup_type) {
                    unset($new_value['parent_id']);
                    $new_value['renew_form'] = $ttbbooking_id;
                    $new_value['meeting_status'] = 0;
                    $new_value['verify_status'] = 2;
                    $new_value['qc_status'] = 0;
                    $new_value['image_of_odo_meter'] = null;
                    $new_value['car_brand'] = $value['car_brand'];
                    $new_value['car_model'] = $value['car_model'];
                    $new_value['car_sub_model'] = $value['car_sub_model'];
                    $new_value['car_year'] = $value['car_year'];
                    $new_value['car_color'] = $value['car_color'];
                    $new_value['license_plate_number'] = $value['license_plate_number'];
                    $new_value['license_plate_province'] = $value['license_plate_province'];
                    $new_value['vin'] = $value['vehicle_identification_number'];
                    $new_value['request_person'] = $value['request_person'];
                    $new_value['request_mobile_number'] = $value['request_mobile_number'];
                    $new_value['requester_type'] = $value['requester_type'];
                    $new_value['dealer_name'] = $value['dealer_name'];
                    $new_value['address_province'] = $value['address_province'];
                    $new_value['appointment_date'] = $value['appointment_date'];
                    $new_value['appointment_time'] = $value['appointment_time'];
                    $new_value['gps_lat'] = $value['gps_lat'] ?? null;
                    $new_value['gps_long'] = $value['gps_long'] ?? null;
                    $new_value['promo_code'] = $value['promo_code'];
                    $new_value['payment_method'] = $value['payment_method'];
                    $new_value['mile_number'] = $value['mile_number'];
                    $new_value['full_price'] = $value['full_price'] ?? null;
                    $new_value['discount_price'] = $value['discount_price'] ?? null;
                    $new_value['net_price'] = $value['net_price'] ?? null;
                    $new_value['offline_campaign'] = $value['offline_campaign'] ?? null;

                    $create_ttbbooking = ttbbooking::create($new_value->toArray());
                    $status = true;

                } else if($now_date >= $exp_date && $now_date >= $exp_year) {
                    $status = false;

                } else {
                    unset($new_value['renew_form']);
                    $new_value['image_of_odo_meter'] = $value['image_of_odo_meter'];
                    $new_value['appointment_status'] = 6;
                    $new_value['meeting_status'] = 0;
                    $new_value['verify_status'] = 2;
                    $create_ttbbooking = ttbbooking::create($new_value->toArray());

                    $update_parent = ttbbooking::where('id', $ttbbooking_id)
                        ->where('license_plate_number', $value['license_plate_number'])
                        ->where('vin', $value['vehicle_identification_number'])
                        ->update([
                            'appointment_status' => $new_value['appointment_status'],
                            'meeting_status' => $new_value['meeting_status'],
                            'verify_status' => $new_value['verify_status'],
                            'image_of_odo_meter' => $value['image_of_odo_meter'],
                            'new_mile_number' => $value['mile_number']
                        ]);

                    $status = true;
                }
            } else {
                $create_ttbbooking = ttb_booking::create($new_value->toArray());
                $status = true;
            }
            return $status;
        } else {
            return false;
        }
    }
    
    public function store(Request $request)
    {
        $success = 0;
        $fail = 0;
        $fail_id_arr = [];
        $message = [];

        if (! isset($request->all()[0]) && null != $request->reference_id) {
            $request = [$request->all()];
        } elseif (isset($request->all()[0])) {
            $request = $request->json();
        } else {
            $request = $request->json();
            $fail++;
        }

        foreach ($request as $key => $value) {
            DB::beginTransaction();
            try {
                $validator = Validator::make($value, [
                    'reference_id' => 'required',
                    'request_date' => 'required',
                    'car_brand' => 'required',
                    'car_model' => 'required',
                    'car_sub_model' => 'required',
                    'license_plate_number' => 'required',
                    'license_plate_province' => 'required',
                    'vehicle_identification_number' => 'required',
                    'request_person' => 'required',
                    'request_mobile_number' => 'required',
                    'requester_type' => 'required',
                    'dealer_name' => 'required',
                    'address_province' => 'required',
                    'appointment_date' => 'required|date',
                    'appointment_time' => 'required|date_format:H:i',
                    'payment_method' => 'required',
                ]);

                if ($validator->fails()) {
                    $fail = $fail + 1;
                    array_push($fail_id_arr, $value['reference_id']);
                    $message[$value['reference_id']] = $validator->errors()->all();
                    continue;
                }

                if (! empty($value['image_of_odo_meter'])) {
                    $reference_id = ttb_booking::where('license_plate_number', $value['license_plate_number'])
                        ->where('vin', $value['vehicle_identification_number'])
                        ->orderBy('id', 'DESC')
                        ->first();

                    $data_ttb_renew = ttb_booking::where('license_plate_number', $value['license_plate_number'])
                        ->where('vin', $value['vehicle_identification_number'])
                        ->whereNotNull('renew_form')
                        ->orderBy('created_at', 'desc')
                        ->limit(1);

                    if (1 == $data_ttb_renew->count()) {
                        $reference_id = $data_ttb_renew->first();
                    }

                    if (! isset($reference_id)) {
                        $fail = $fail + 1;
                        array_push($fail_id_arr, $value['reference_id']);
                        $message[$value['reference_id']] = 'Not License Plate Number & VIN';
                        continue;
                    } else {
                        $check_exp_date = "";
                        if($reference_id->appointment_status == 7) {
                            $check_exp_date = ttb_score_detail::select('*')
                                ->where('reference_id', $this->getReferenceID($reference_id->reference_id))
                                ->first();
                        } else {
                            $check_exp_date = ttb_score_detail::select('*')
                                ->where(function ($query) use ($reference_id) {
                                    $query->where('reference_id', $this->getReferenceID($reference_id->reference_id));
                                })
                                ->first();
                        }

                        if (! $check_exp_date) {
                            $fail = $fail + 1;
                            array_push($fail_id_arr, $value['reference_id']);
                            $message[$value['reference_id']] = 'Data In progress';
                            continue;
                        }

                        $now_date_step_1 = date_create(date('Y-m-d'));
                        $exp_date_step_1 = date_create($check_exp_date->expiry_date);
                        date_add($exp_date_step_1, date_interval_create_from_date_string('-7 days'));

                        if ($now_date_step_1 <= $exp_date_step_1) {
                            $fail = $fail + 1;
                            array_push($fail_id_arr, $value['reference_id']);
                            $message[$value['reference_id']] = 'More Than 7 Day';
                            continue;
                        }

                        $now_date_step_2 = date_create(date('Y-m-d'));
                        $exp_date_step_2 = date_create($check_exp_date->expiry_date);
                        date_add($exp_date_step_2, date_interval_create_from_date_string('1 year'));

                        if ($now_date_step_2 >= $exp_date_step_2) {
                            $fail = $fail + 1;
                            array_push($fail_id_arr, $value['reference_id']);
                            $message[$value['reference_id']] = 'Expiry more than 1 year';
                            continue;
                        }

                        if ($value['mile_number'] - $reference_id->mile_number <= 30) {
                            $reference_id->update([
                                'appointment_status' => 6,
                                'verify_status' => 2,
                                'image_of_odo_meter' => $value['image_of_odo_meter'],
                                'new_mile_number' => $value['mile_number']
                            ]);

                            $status_dup = $this->duplicate_vin($request, $value, '');
                            if($status_dup) {
                                $new_reference_id = ttb_booking::where('license_plate_number', $value['license_plate_number'])
                                    ->where('vin', $value['vehicle_identification_number'])
                                    ->where('parent_id', $reference_id->id);
                                if ($new_reference_id->count()) {
                                    $new_reference_id->orderBy('created_at', 'desc')
                                        ->update([
                                            'appointment_status' => 6,
                                            'verify_status' => 2
                                        ]);
                                }
                                $success = $success + 1;
                                DB::commit();
                                continue;
                            } else {
                                $fail = $fail + 1;
                                array_push($fail_id_arr, $value['reference_id']);
                                $message[$value['reference_id']] = 'Exp date, Please renew form';
                                continue;
                            }
                        } else {
                            $fail = $fail + 1;
                            array_push($fail_id_arr, $value['reference_id']);
                            $message[$value['reference_id']] = 'Mile number > 30, Please renew form';
                            continue;
                        }
                    }
                }

                if (empty($value['image_of_odo_meter'])) {
                    $status_dup = $this->duplicate_vin($request, $value, 'renew');
                    if ($status_dup) {
                        $success = $success + 1;
                        DB::commit();
                        continue;
                    }
                }

                $create_booking = ttb_booking::create([
                    'reference_id' => $value['reference_id'],
                    'request_date' =>  date('Y-m-d H:i:s', strtotime($value['request_date'])),
                    'car_brand' => $value['car_brand'],
                    'car_model' => $value['car_model'],
                    'car_sub_model' => $value['car_sub_model'],
                    'car_year' => $value['car_year'],
                    'car_color' => $value['car_color'],
                    'license_plate_number' => $value['license_plate_number'],
                    'license_plate_province' => $value['license_plate_province'],
                    'vin' => $value['vehicle_identification_number'],
                    'request_person' => $value['request_person'],
                    'request_mobile_number' => $value['request_mobile_number'],
                    'requester_type' => $value['requester_type'],
                    'dealer_name' => $value['dealer_name'],
                    'address_province' => $value['address_province'],
                    'appointment_date' => date('Y-m-d', strtotime($value['appointment_date'])),
                    'appointment_time' => $value['appointment_time'],
                    'gps_lat' => $value['gps_lat'] ?? null,
                    'gps_long' => $value['gps_long'] ?? null,
                    'promo_code' => $value['promo_code'],
                    'payment_method' => $value['payment_method'],
                    'appointment_status' => 5,
                ]);
                $success = $success + 1;
                DB::commit();
            } catch (\Exception $e) {
                $fail = $fail + 1;
                array_push($fail_id_arr, $value['reference_id']);
                $message[$value['reference_id']] = 'Server Error! '.$e;
                DB::rollBack();
            }
        }
        return response()->json(['success' => $success, 'fail' => $fail, 'reference_id_fail' => $fail_id_arr, 'fail_message' => $message]);
    }

    public function getReferenceID($reference_id)
    {
        $get_reference_id = ttb_booking::select('reference_id', 'parent_id')
        ->where('reference_id', $reference_id)
        ->where('status', 1)
        ->latest('id')
        ->first();

        if ($get_reference_id && $get_reference_id->parent_id) {
            $get_parent_id = ttb_booking::select('reference_id', 'parent_id')
                ->where('id', '=', $get_reference_id->parent_id)
                ->where('status', 1)
                ->first();

            return $this->getReferenceID($get_parent_id->reference_id);
        } else {
            return $reference_id;
        }
    }
}
