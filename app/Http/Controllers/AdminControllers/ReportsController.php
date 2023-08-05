<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function allreports(){
        $data['all_reports']=Report::with('post','comment','user_reported','userwhoreported')->ORDERBY('created_at','Desc')->paginate(15);
        
        $data['reports']=Report::count();

        $data['reports_per_day']=Report::where('created_at','LIKE',['%'.\Carbon\Carbon::now()->format('Y-m-d').'%'])->count();

        return view('Admin.all-reports',$data);

    }


    public function dltreport(Request $req){
        $report=Report::find($req->id);

        $report->delete();

        return response()->json(["status" =>true,
        'msg'=>'Report Deleted Successfully',
        'id'=>$req->id]);
    }
}
