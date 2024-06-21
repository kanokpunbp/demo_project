<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class UserModel extends Model
{
    protected $table                    = 'tb_user';
    protected $primaryKey               = 'user_id';
    public $timestamps                  = false;

    //use inside model.
    private static $tbName              = 'tb_user';
    private static $fldName             = 'user_id';
    private static $lang;


    public static function _get_load_data($request)
    {
        $surveyId                                   = $request['txt_search'];

        $rs                                         = DB::table(static::$tbName);
        $rs->select('id', 'name', '_order');

        if(!empty($request['txt_search']))
        {
            $rs->where('name', 'like', '%'.$request['txt_search'].'%');
        }

        $rs->orderBy('_order', 'asc');

        return $rs;
    }
    
    public static function _insert_data($data=array())
    {
        DB::beginTransaction();
        try{
            $rs                                     = DB::table(static::$tbName)->insert($data);
            DB::commit();
            $msg                                    = TRUE;
        }catch(\Exception $e){
            DB::rollback();
            $msg                                    = FALSE;
        }

	    return $msg;
    }
    public static function _update_data($data=array(), $id)
    {
        DB::beginTransaction();
        try{
            $rs                                     = DB::table(static::$tbName)->where(static::$fldName, $id)->update($data);
            DB::commit();
            $msg                                    = TRUE;
        }catch(\Exception $e){
            DB::rollback();
            $msg                                    = FALSE;
        }

	    return $msg;
    }
    public static function _del_data($id)
    {
        DB::beginTransaction();
        try{
            $rs                                     = DB::table(static::$tbName)->where(static::$fldName, $id)->delete();
            DB::commit();
            $msg                                    = TRUE;
        }catch(\Exception $e){
            echo $e;
            DB::rollback();
            $msg                                    = FALSE;
        }

	    return $msg;
    }
 
}
