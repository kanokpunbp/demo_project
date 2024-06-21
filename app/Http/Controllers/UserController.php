<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\UserModel;
use App\Models\UrlModel;
use Exception;

class UserController extends Controller
{

    public function ajax_login(Request $request)
    {

        $C_Username             = $request['txt_username'];
        $C_Password             =  $request['txt_password'];

        $rs = UserModel::where('user_name', $C_Username)->orWhere('email', $C_Username)->first();

        $status                 = false;
        $msg                    = '';
        try {
            if ($rs) {
                $hashedPassword = $rs->password_hash;
                if (password_verify($C_Password, $hashedPassword)) {
                    $request->Session()->put('sess_login', TRUE);
                    $request->Session()->put('sess_id', $rs->user_id);
                    $request->Session()->put('sess_fullname', $rs->full_name);
                    $request->Session()->put('sess_usertype', $rs->user_type);
                    $status                 = true;
                } else {
                    $msg = "Invalid password";
                }
            } else {
                $msg = "User account not found.";
            }
        } catch (\Exception $e) {
            $msg = $e->getMessage();
        }
        $data                   = array();
        $data["status"]         = $status;
        $data["msg"]            = $msg;
        return response()->json($data);
    }

    public function register()
    {

        if (session()->has('sess_id')) {
            return redirect('/');
        }

        return view('register_form');
    }



    public function ajax_save_register(Request $request)
    {

        $data = [];

        try {
            $fullname       = (!empty($request['fullname'])) ? $request['fullname'] : '';
            $email          = (!empty($request['email'])) ? $request['email'] : '';
            $user_name       = (!empty($request['user_name'])) ? $request['user_name'] : '';
            $password       = (!empty($request['password'])) ? $request['password'] : '';

            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $data_user   = [
                'full_name' => $fullname,
                'user_name' =>  $user_name,
                'email' => $email,
                'password_hash' => $hashedPassword,
                'user_type' => 'U',
                'isenabled' => 'Y'
            ];
            UserModel::_insert_data($data_user);

            $data['status']     = true;
            $data['msg']    = 'Registration successful';
        } catch (\Exception $e) {
            $e->getMessage();
            $data['status']     = false;
            $data['msg']    = 'Please try again.';
        }

        return response()->json($data);
    }


    
    public function check_duplicate(Request $request)
    {
        $data = [];

        try {
            $txt_check      = (!empty($request['txt_check'])) ? $request['txt_check'] : '';
            $field_name       = (!empty($request['field_name'])) ? $request['field_name'] : '';
            $txt_warning       = (!empty($request['txt_warning'])) ? $request['txt_warning'] : '';


            $msg = '';

            $rs =   UserModel::where( $field_name , $txt_check)->first();
            if (empty($rs)) {
                $status = true;
            } else {
                $status = false;
                $msg = 'Not available, this '. $txt_warning .' is already in use.';
            }

            $data['status'] = $status;
            $data['msg']    =  $msg ;
        } catch (\Exception $e) {
            $e->getMessage();
            $data['status'] = false;
            $data['msg']    = '';
        }

        return response()->json($data);
    }

    public function logout()
    {
        Session::flush();
        return redirect('./login');
    }
}
