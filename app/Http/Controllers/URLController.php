<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\UserModel;
use App\Models\UrlModel;
use Exception;

class URLController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('CheckIsLogin'));
    // }

    public function shortened()
    {
        return view('shortened');
    }


    public function create_shortened_url(Request $request)
    {
        $sess_user_id = session()->get('sess_id');

        if (empty($sess_user_id)) {

            return response()->json([
                'status' => false,
                'msg' => 'Session expired, redirecting to login page.',
                'redirect_url' => url('/login')
            ]);
        }

        $status = true;
        $data = array();
        try {


            $fullUrl = $request->fullUrl();
            $path = $request->path();
            $baseUrl = str_replace($path, '', $fullUrl);

            $request->validate(['original_url' => 'required|url']);
            $original_url = $request->input('original_url');

            $short_code = Str::random(6);
            while (UrlModel::where('short_code', $short_code)->exists()) {
                $short_code = Str::random(6);
            }

            $data_url   = [
                'original_url' => $original_url,
                'short_code' =>  $short_code,
                'user_id' => $sess_user_id,
                'create_date' =>  date('Y-m-d H:i:s'),
                'isenabled' => 'Y'
            ];
            UrlModel::_insert_data($data_url);

            $shorten_url = $baseUrl . $short_code;

            $msg = '';
            $status = true;

            $data['original_url'] = $original_url;
            $data['shorten_url'] =  $shorten_url;
        } catch (Exception $e) {
            $msg = 'Invalid URL';
            $status = false;
        }

        $data['status'] = $status;
        $data['msg'] =  $msg;
        $data['redirect_url'] = '';
        return response()->json($data);
    }

    public function redirectURL($code)
    {

        $url = UrlModel::where('short_code', $code)->first();
        $url_redirect = $url->original_url ?? '/';
        return redirect($url_redirect);
    }


}
