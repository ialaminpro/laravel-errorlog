<?php

namespace Acolyte\ErrorLog\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Acolyte\ErrorLog\Models\ErrorLog;
use Acolyte\ErrorLog\Helpers\SendMails;
use DB;
use Mail;

class ErrorLogController extends Controller
{
    public function index(Request $request){
        try {

            $page_name = 'error_log';

            $search = $request->search_string;
            $type = $request->type;

            $error_logs = ErrorLog::orderBy('created_at', 'DESC');

            if (!empty($search)) {
                $error_logs = $error_logs->where(function ($query) use ($search) {
                    $query->orwhere('exception_message', 'LIKE', '%' . $search . '%');
                });
            }
            if ($type != '') {
                $error_logs = $error_logs->where('is_resolved', $type);
            }
            $error_logs = $error_logs->paginate(100);
            return view('acolyte.errorlog.index', compact('error_logs', 'page_name'));
        }catch ( \Exception $e) {
            SendMails::sendErrorMail($e->getMessage(), null, 'ErrorLogController', 'errorLogs', $e->getLine(), $e->getFile(),
                '', '', '', '');
            return back();
        }

    }


    public function errorLogDelete($log_id){
        try{

            ErrorLog::where('id', '=', $log_id)->delete();

        }catch ( \Exception $e) {
            SendMails::sendErrorMail($e->getMessage(), null, 'ErrorLogController', 'errorLogDelete', $e->getLine(), $e->getFile(),
            '', '', '', '');
            return back();
        }
    }

    public function errorLogDeleteAll(){
        try{
            ErrorLog::truncate();
            return ['status'=>200,'reason'=>'Error logs removed successfully'];
        }catch ( \Exception $e) {
            SendMails::sendErrorMail($e->getMessage(), null, 'ErrorLogController', 'errorLogDeleteAll', $e->getLine(), $e->getFile(),
                '', '', '', '');
            return back();
        }
    }

    public function errorLogResolve($log_id){
        try{
            $row = ErrorLog::where('id', '=', $log_id)->first();

            // toggle the resolved status.
            if($row->is_resolved){
                $row->is_resolved = false;
            }else{
                $row->is_resolved = true;
            }
            $row->save();

            return ['status'=>200,'reason'=>'Successfully updated'];
        }catch ( \Exception $e) {
            SendMails::sendErrorMail($e->getMessage(), null, 'ErrorLogController', 'errorLogResolve', $e->getLine(), $e->getFile(),
                '', '', '', '');
            return back();
        }
    }
}
