<?php
namespace App\Http\Controllers;

use App\Http\Controllers\FrontendController;
use App\Mail\Customer\Authentication\ForgotPassword;
use App\Mail\Customer\Authentication\WelcomeEmail;
use App\Models\Catalogue\Category;
use App\Models\Catalogue\Order;
use App\Models\Catalogue\Wishlist;
use App\Models\Personnel\Customer;
use Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use stdClass;

class AuthenticationController extends Controller
{

    public function setNewPassword(Request $request)
    {

        $findCustomer = Customer::where('reset_token', $request->mask)->first();
        if (empty($findCustomer)) {
            $message = "Your telephone number is wrong, kindly try again";
            session()->flash('serror', $message);
            return back();
        }
        $findCustomer->password = Hash::make($request->password);
        $findCustomer->save();
        $message = "Your password has been set successfully. Thank you !! ";
        session()->flash('message', $message);
        return redirect()->route('authentication');

    }
    public function resetPassword($mask)
    {
            $carTypes = Category::all();

        return view('website/authentication/setpassword', compact('carTypes', 'mask'));
    }

    public function forgotPassword(Request $request)
    {
        $userEmail    = $request->email;
        $findCustomer = Customer::where('email', $userEmail)->first();

        if ($findCustomer) {
            $link                        = \generate_mask();
            $tomorrow                    = mktime(0, 0, 0, gmdate("m"), gmdate("d") + 1, gmdate("Y"));
            $tomorrowDate                = gmdate('Y-m-d', $tomorrow);
            $findCustomer->reset_token   = $link;
            $findCustomer->expiring_date = $tomorrowDate;
            $findCustomer->save();

            Mail::to($findCustomer->email)->send(new ForgotPassword([
                "name" => "{$findCustomer->first_name}",
                "link" => url('/') . '/authentication/password-reset/' . $link,
            ]));
        }
        $message = "If the email you entered is connected to an account, you will received an email with instructions. Thank you !! ";
        session()->flash('message', $message);
        return back()->with('success', $message);
    }

    public function updateProfile(Request $request)
    {

        $findCustomer = Customer::find($request->customer_id);
        $message      = "Customer not identified";
        if ($findCustomer) {
            $findCustomer->first_name       = $request->first_name;
            $findCustomer->last_name        = $request->first_name;
            $findCustomer->telephone_number = $request->telephone_number;
            $findCustomer->email            = $request->email;
            $findCustomer->save();
            $message = "Customer profile updated";
        }

        session()->flash('message', $message);
        return back()->with('success', $message);
    }

    public function userAccount()
    {
        // Session::flush();
        $userData = session('eaglexpress-loggedin');

        if (! $userData) {

            $backurl = url()->previous();
            session(['backurl' => $backurl]);
            return redirect()->route('authentication');
        }

        $cityMask                = (new FrontendController)->getCity();
        $cityCategories          = (new FrontendController)->fetchCityCategories($cityMask);
        $customerMask            = $userData['customer_id'];
        $customer                = Customer::where("customer_id", $customerMask)->first();
        $orders                  = Order::where('customer_id', $customer->customer_id)->get();
        $totalOrders             = count($orders);
        $totalNotCompletedOrders = Order::where('customer_id', $customer->customer_id)->where('status', 'placed')->count();
        $totalCompletedOrders    = Order::where('customer_id', $customer->customer_id)->where('status', 'completed')->count();

        $order                          = null;
        $orderStats                     = new stdClass();
        $orderStats->total              = $totalOrders;
        $orderStats->completedOrders    = $totalCompletedOrders;
        $orderStats->notCompletedOrders = $totalNotCompletedOrders;
        $wishlistItems                  = Wishlist::where('city_id', $cityMask)->where('customer_id', $customerMask)->get();
        return view('website/authentication/dashboard', compact('orderStats', 'order', 'orders', 'cityCategories', 'customer', 'wishlistItems'));
    }


    public function viewForgotPassword()
    {

        // Session::flush();
        $userdata = session('eaglexpress-loggedin-name');

        if ($userdata) {
            $redirect = '/';
            return redirect($redirect);
        }

        $backurl = url()->previous();
        session(['backurl' => $backurl]);

        $carTypes = Category::all();

        return view('website/authentication/forgot-password', compact('carTypes'));
    }

    public function viewLogin()
    {

        // Session::flush();
        $userdata = session('eaglexpress-loggedin-name');

        if ($userdata) {
            $redirect = '/';
            return redirect($redirect);
        }

        $backurl = url()->previous();
        session(['backurl' => $backurl]);

        $carTypes = Category::all();

        return view('website/authentication/login', compact('carTypes'));
    }

    public function login(Request $request)
    {

        $userdata = session('eaglexpress-loggedin-name');
        if ($userdata) {
            $redirect = '/';
            return redirect($redirect);

        } else {
            $userEmail    = $request->email;
            $userPassword = $request->password;
            $findCustomer = Customer::where('email', $userEmail)->first();
            if ($findCustomer) {
                if (Hash::check($userPassword, $findCustomer->password)) {
                    $userdata = [
                        'c_table_id'  => $findCustomer->id,
                        'customer_id' => $findCustomer->customer_id,
                        'name'        => $findCustomer->first_name,
                    ];
                    Session::put('eaglexpress-loggedin', $userdata);
                    Session::put('eaglexpress-loggedin-name', $findCustomer->first_name);

                    $redirect = '/';
                    if (session('backurl')) {
                        $redirect = session('backurl');
                        session()->forget(['backurl']);

                    }

                    return redirect($redirect);
                }

                $message = "Your password is wrong, kindly try again";
                session()->flash('serror', $message);
                return back();

            }

            $message = "Your password is wrong, kindly try again";
            session()->flash('serror', $message);
            return back();
            //    return view('shop/pages/auth');
        }
    }

    public function viewRegisterPage()
    {
        $userdata = session('eaglexpress-loggedin');

        if ($userdata) {
            $redirect = '/';
            return redirect($redirect);
        }

        $carTypes = Category::all();
        return view('website/authentication/register', compact('carTypes'));
    }

    public function storeRegistration(Request $request)
    {

        $customerId = Cookie::get('eaglexpress-customer-id');
        if (empty($customerId)) {
            $customerId = generate_mask();
        }

        if ($request->password != $request->confirm_password) {

            $message = "Your password and confirm password does not match, Kindly try again";
            session()->flash('serror', $message);
            return back();

        }
        $verificationCode = rand(100000, 999999);

        $newcustomer                   = new Customer();
        $newcustomer->first_name       = $request->first_name;
        $newcustomer->last_name        = $request->last_name;
        $newcustomer->email            = $request->email;
        $newcustomer->telephone_number = $request->telephone_number;
        $newcustomer->customer_id      = $customerId;
        $newcustomer->mask             = generate_mask();
        // $newcustomer->verification_code = $verificationCode;
        $newcustomer->password      = Hash::make($request->password);
        $newcustomer->registered_on = gmdate('Y-m-d');

        if ($newcustomer->save()) {

            $userdata = [
                'c_table_id'  => $newcustomer->id,
                'customer_id' => $newcustomer->customer_id,
                'name'        => $newcustomer->first_name,
            ];
            Session::put('eaglexpress-loggedin', $userdata);
            Session::put('eaglexpress-loggedin-name', $newcustomer->first_name);

            $redirect = '/';
            if (session('backurl')) {
                $redirect = session('backurl');
                session()->forget(['backurl']);
            }

            // $mailData = [

            //     'title' => 'Mail from ItSolutionStuff.com',

            //     'body'  => 'This is for testing email using smtp.',

            // ];
            $newcustomer->url = URL('/'). '/authentication/login';
            Mail::to($newcustomer->email)->send(new WelcomeEmail($newcustomer));



            return redirect($redirect);
        }
    }

    public function getCustomer()
    {
        // working
        $customerId = null;
        $customerId = Cookie::get('dwapapa-customer-id');
        if (empty($customerId)) {
            $customerId = rand(1111111, 9999999) . "_" . date('Y-m-d') . "_" . time();
            Cookie::queue('dwapapa-customer-id', $customerId, 129600);
        }
        return $customerId;
        // end of working
    }

    public function verifyCode(Request $code)
    {

        $verification_code = $code->f . $code->ff . $code->fff . $code->ffff . $code->fffff . $code->ffffff;
        $customer_id       = $code->customer_id;
        if (empty($verification_code)) {
        }
        $findCustomer = Customer::where('customer_id', $customer_id)->first();
        if (! empty($findCustomer)) {
            if ($findCustomer->verification_code == $verification_code) {
                $findCustomer->status = ST_ACTIVE;
                $findCustomer->save();

                $userdata = [
                    'customer_id' => $findCustomer->customer_id,
                    'name'        => $findCustomer->first_name,
                ];
                Session::put('eaglexpress-loggedin', $userdata);
                Session::put('eaglexpress-loggedin-name', $findCustomer->first_name);

                $redirect = '/';
                if (session('backurl')) {
                    $redirect = session('backurl');
                    session()->forget(['backurl']);
                }

                return redirect($redirect);

                // return redirect()->route('home')
                //     ->with('success', 'You registration was successful');
            }
        } else {
            return 'Error';
        }

        return '';

    }

    public function logout()
    {
        Session::flush();

        $redirect = '/';
        return redirect($redirect);
    }
}
