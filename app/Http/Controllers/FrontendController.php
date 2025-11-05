<?php
namespace App\Http\Controllers;

use App\Models\Project;

class FrontendController extends Controller
{

    public function index()
    {

        $projects = Project::where('status', 1)->orderBy('created_at', 'desc')->get();
        return view('website.index', compact('projects'));

    }

    // public function index()
    // {

    //     $carTypes = Category::all();
    //     $newCars  = Car::where('condition', 'new')->get()->take(8);
    //     $usedCars = Car::where('condition', 'used')->get()->take(8);

    //     // $allCars = Car::where('')->get()->take(4);
    //     $allCars     = Car::inRandomOrder()->get()->take(8);
    //     $popularCars = Car::inRandomOrder()->get()->take(6);
    //     $carMakes    = Make::all();
    //     $years       = range(Carbon::now()->year, Carbon::now()->year - 15);
    //     return view('website.index', compact('carMakes', 'years', 'carTypes', 'allCars', 'newCars', 'usedCars', 'popularCars'));

    // }

    public function mydashboard()
    {

        $userId       = 0;
        $customerData = Session::get('eaglexpress-loggedin');
        if ($customerData) {
            $userId = $customerData['c_table_id'];
        } else {

            $backurl = url()->previous();
            session(['backurl' => $backurl]);
            return redirect()->route('authentication');
        }

        $carTypes    = Category::all();
        $totalOrders = Purchase::where('customer_id', $userId)->count();

        $favouriteCars = Favourite::where('user_id', $userId)->count();
        $totalQuotes   = Carquote::where('customer_id', $userId)->count();

        return view('website.page-dashboard', compact('carTypes', 'totalQuotes', 'favouriteCars', 'totalOrders'));

    }
    public function profile()
    {

        $userId       = 0;
        $customerData = Session::get('eaglexpress-loggedin');
        if ($customerData) {
            $userId = $customerData['c_table_id'];
        }

        $Customer = Customer::find($userId);

        $carTypes = Category::all();
        return view('website.page-dashboard-profile', compact('carTypes', 'Customer', 'userId'));

    }
}
