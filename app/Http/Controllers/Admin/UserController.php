<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // https://www.youtube.com/watch?v=xY9OYug0uaQ&list=PLLUtELdNs2ZaAC30yEEtR6n-EPXQFmiVu&index=150



    // Render admin/users/users.blade.php page in the Admin Panel    // https://www.youtube.com/watch?v=xY9OYug0uaQ&list=PLLUtELdNs2ZaAC30yEEtR6n-EPXQFmiVu&index=150
    public function users() {
        // Correcting issues in the Skydash Admin Panel Sidebar using Session:  Check 6:33 in https://www.youtube.com/watch?v=i_SUdNILIrc&list=PLLUtELdNs2ZaAC30yEEtR6n-EPXQFmiVu&index=29
        \Session::put('page', 'users');


        $users = \App\Models\User::get()->toArray();
        // dd($users);


        return view('admin.users.users')->with(compact('users'));
    }



    // Update User Status (active/inactive) via AJAX in admin/users/users.blade.php, check admin/js/custom.js    // https://www.youtube.com/watch?v=xY9OYug0uaQ&list=PLLUtELdNs2ZaAC30yEEtR6n-EPXQFmiVu&index=151
    public function updateUserStatus(Request $request) {
        if ($request->ajax()) { // if the request is coming via an AJAX call
            $data = $request->all(); // Getting the name/value pairs array that are sent from the AJAX request (AJAX call)
            // dd($data); // dd() method DOESN'T WORK WITH AJAX! - SHOWS AN ERROR!! USE var_dump() and exit; INSTEAD!
            // echo '<pre>', var_dump($data), '</pre>';
            // exit;

            if ($data['status'] == 'Active') { // $data['status'] comes from the 'data' object inside the $.ajax() method    // reverse the 'status' from (ative/inactive) 0 to 1 and 1 to 0 (and vice versa)
                $status = 0;
            } else {
                $status = 1;
            }


            \App\Models\User::where('id', $data['user_id'])->update(['status' => $status]); // $data['user_id'] comes from the 'data' object inside the $.ajax() method
            // echo '<pre>', var_dump($data), '</pre>';

            return response()->json([ // JSON Responses: https://laravel.com/docs/9.x/responses#json-responses
                'status'  => $status,
                'user_id' => $data['user_id']
            ]);
        }
    }
}