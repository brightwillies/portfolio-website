<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Catalogue\RolePermission;
use App\Models\Personnel\Administrator;
use App\Models\Personnel\Superadministrator;
use DateTime;
use Exception;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    //
    public function superadminlogin(Request $request)
    {

        try {
            $rules = [

                'email'    => 'required',
                'password' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                return $this->validationResponse($errors);
            }

            $password = $request->password;
            $email    = $request->email;
            $admin    = Superadministrator::where('email', (string) $email)->first();
            if (! $admin) {
                return $this->wrongCredentialsResponse();
                //  return $this->errorResponse('You have entered an invalid email or password');
            }

            if (Hash::check($password, $admin->password)) {
                $now_seconds    = time();
                $userpemissions = [];
                $payload        = [
                    "iss" => url("/"),
                    "iat" => time(),
                    "exp" => $now_seconds + (60 * 6300),
                    "id"  => $admin->id,
                ];
                // Generate token
                if ($token = JWT::encode($payload, config("app.key"), 'HS256')) {

                    $admin->last_login = new DateTime();
                    $admin->save();

                    $roleId         = $admin->role_id;
                    $userpemissions = [];
                    $getPermission  = RolePermission::where('role_id', $roleId)->get();
                    if (! empty($getPermission)) {
                        foreach ($getPermission as $key => $pem) {
                            $userpemissions[] = $pem->permission;
                        }
                    }
                    return $this->successResponse("Login Successful", [
                        "user"        => $admin,
                        "token"       => $token,
                        // 'permissions' =>[],
                        'permissions' => $userpemissions,
                    ]);
                }
            }
            return $this->wrongCredentialsResponse();

        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }
    public function adminLogin(Request $request)
    {

        try {
            $rules = [

                'email'    => 'required',
                'password' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                return $this->validationResponse($errors);
            }

            $password = $request->password;
            $email    = $request->email;
            $admin    = Administrator::where('email', (string) $email)->first();
            if (! $admin) {
                return $this->wrongCredentialsResponse();
                //  return $this->errorResponse('You have entered an invalid email or password');
            }

            if (Hash::check($password, $admin->password)) {
                $now_seconds    = time();
                $userpemissions = [];
                $payload        = [
                    "iss" => url("/"),
                    "iat" => time(),
                    "exp" => $now_seconds + (60 * 6300),
                    "id"  => $admin->id,
                ];
                // Generate token
                if ($token = JWT::encode($payload, config("app.key"), 'HS256')) {

                    $admin->last_login = new DateTime();
                    $admin->save();

                     $roleId         = $admin->role_id;
                    $userpemissions = [];
                    $getPermission  = RolePermission::where('role_id', $roleId)->get();
                    if (! empty($getPermission)) {
                        foreach ($getPermission as $key => $pem) {
                            $userpemissions[] = $pem->permission;
                        }
                    }
                    return $this->successResponse("Login Successful", [
                        "user"        => $admin,
                        "token"       => $token,
                        // 'permissions' =>[],
                        'permissions' => $userpemissions,
                    ]);
                }
            }
            return $this->wrongCredentialsResponse();

        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
