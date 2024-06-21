<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\UserModel;
use App\Models\UrlModel;
use Exception;
use DateTime;
class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('CheckIsLogin');
    }

    public function view_shortenedURLs()
    {
        return view('shorten_urls');
    }

    public function load_view_shortenedURLs(Request $request)
    {
        $status = true;
        $msg = '';
        $datahtml = '';
        $data = array();
        try {

            $rs = UrlModel::_get_load_data($request)->get();
            if ($rs) {


                foreach ($rs as $i => $val) {

                    $no = $i + 1;
                    $fullname = $val->full_name;
                    $create_date= new DateTime( $val->create_date);

                    $original_url = $val->original_url;
                    $short_code = $val->short_code;

                    $fullUrl = $request->fullUrl();
                    $path = $request->path();
                    $baseUrl = str_replace($path, '', $fullUrl);
                    $shorten_url = $baseUrl . $short_code;
       
                    $btn_del    = '<a onclick="delete_shortenedURLs(' . $val->id . ')" class="btn text-danger" title="Delete Data">   <i aria-hidden="true" class="fa fa-trash"></i></a>';
         
                    $datahtml .= '<tr> <td >' . $no . '</td>
            <td>' . $fullname . ' </td>
            <td> ' . $original_url . '</td>
            <td> ' . $shorten_url . '</td>
            <td> ' . $create_date->format('d/m/Y H:i') . '</td>
            <td> ' . $btn_del . '</td></tr>';
                }
            } else {

                $datahtml = 'data not found';
            }
        } catch (Exception $e) {
            $msg = '';
            $status = false;
        }

        $data['status'] = $status;
        $data['msg'] =  $msg;
        $data['datahtml'] =  $datahtml;
        return response()->json($data);
    }

    public function delete_shortenedURLs(Request $request)
    {
        $status = true;
        $msg = '';
        $data = array();
        try {
        $id=$request['id'];
        $rs = UrlModel::_del_data($id);
        } catch (Exception $e) {
            $msg = '';
            $status = false;
        }

        $data['status'] = $status;
        $data['msg'] =  $msg;

        return response()->json($data);
    }
}
