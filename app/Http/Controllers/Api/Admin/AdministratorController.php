<?php
namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Catalogue\Car;
use App\Models\Catalogue\Purchase;
use App\Models\Catalogue\RequestCar;
use App\Models\Personnel\Administrator;
use App\Models\Personnel\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdministratorController extends Controller
{
    public function stats()
    {

        $records         = [];
        $total_cars      = Car::count();
        $total_customers = Customer::count();
        $total_orders    = Purchase::count();
        $total_requests  = RequestCar::count();

        $data = [
            'total_cars'      => $total_cars,
            'total_customers' => $total_customers,
            'total_requests'  => $total_requests,
            'total_orders'    => $total_orders,
        ];
        return $this->successResponse('', $data);
    }

    public function index()
    {
        $records = Administrator::all();

        return $this->successResponse('', $records);
    }

    public function store(Request $request)
    {
        try {
            $rules = [
                'first_name'       => 'required',
                'last_name'        => 'required',
                'email'            => 'required|unique:administrators,email',
                // 'role_id' => 'required',
                // 'region_id' => 'required',
                'telephone_number' => 'required',
                'password'         => 'required|min:6',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                return $this->validationResponse($errors);
            }

            $newItem                   = new Administrator();
            $newItem->first_name       = $request->first_name;
            $newItem->last_name        = $request->last_name;
            $newItem->email            = $request->email;
            $newItem->telephone_number = $request->telephone_number;
            $newItem->role_id          = (int) $request->role_id ?: 1;
            $newItem->password         = Hash::make($request->password);
            $newItem->status           = ST_ACTIVE;

            // $webImage = $request->file('profile_image');

            //          if ($webImage) {

            //     $uploadResult = uploadItemImage($webImage, $request->first_name . '-' . $request->last_name, ST_ADMIN_FOLDER);
            //     if ($uploadResult) {
            //         $newItem->image = $uploadResult->path;
            //         $newItem->image_filename = $uploadResult->filename;
            //     }
            // }
            $newItem->mask = generate_mask();
            if ($newItem->save()) {

                // $data = array(
                //     'name' => $newItem->first_name,
                //     'email' => $newItem->email,
                //     'password' => $request->password,
                //     'as' => 'an administrator',
                //     'url' => 'techinchurch.com/admin-login',
                // );
                // if (isset($newItem->email)) {
                //     try {
                //         $mail = Mail::to($newItem->email)->send(new UserAddedNotificationMail($data));
                //     } catch (\Throwable $th) {
                //     }
                // }
                return $this->successResponse(' Administrator account created successfully');
            }
            return $this->errorResponse('Failed to process your request');
        } catch (Exception $e) {

            return $this->errorResponse($e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $newItem = Administrator::where('mask', $id)->first();
        if (! $newItem) {
            return $this->errorResponse('Record not found');
        }
        return $this->successResponse('', $newItem);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $newItem = Administrator::where('mask', $id)->first();
        if (! $newItem) {
            return $this->errorResponse('Record not found');
        }
        try {
            $rules = [
                'first_name'       => 'required',
                'last_name'        => 'required',
                'email'            => 'required',
                // 'role_id' => 'required',
                'telephone_number' => 'required',

            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                return $this->validationResponse($errors);
            }

            $newItem->first_name       = $request->first_name;
            $newItem->last_name        = $request->last_name;
            $newItem->email            = $request->email;
            $newItem->telephone_number = $request->telephone_number;
            // $newItem->role_id = (int) $request->role_id;
            $newItem->status = ST_ACTIVE;
            $webImage        = $request->file('profile_image');

            if ($newItem->save()) {
                return $this->successResponse($newItem->first_name . ' account updated successfully');
            }
            return $this->errorResponse('Failed to process your request');
        } catch (Exception $e) {

            return $this->errorResponse($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $newItem = Administrator::where('mask', $id)->first();
        if (! $newItem) {
            return $this->errorResponse('Resource not found');
        }
        $newItem->delete();
        return $this->successResponse(SUCCESS_DELETING_MESSAGE);

    }
}
