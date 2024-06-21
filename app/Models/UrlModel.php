<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class UrlModel extends Model
{
    protected $table                    = 'tb_url';
    protected $primaryKey               = 'id';
    public $timestamps                  = false;

    //use inside model.
    private static $tbName              = 'tb_url';
    private static $fldName             = 'id';
    private static $lang;


    public static function _get_load_data($request)
    {
       
        $rs         = UrlModel::select(         
            'tb_url.id',
            'tb_url.original_url',
            'tb_url.short_code',
            'tb_url.user_id',
            'tb_url.create_date',
            'tb_url.isenabled',
            'tb_user.full_name',
            'tb_user.user_name',
            'tb_user.email'
        )
        ->leftJoin('tb_user', 'tb_url.user_id', '=', 'tb_user.user_id'); 
        $rs->orderBy('create_date', 'desc');

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
