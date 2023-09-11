<?php

namespace App\Http\Controllers\ApiControllers\AdminControllers;

use App\Http\Controllers\ApiControllers\ResponseController;
use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportsController extends ResponseController
{
    public function allreports(){
        $data['all_reports']=Report::with('post','comment','user_reported','userwhoreported')->ORDERBY('created_at','Desc')->paginate(15);
        
        $data['reports']=Report::count();

        $data['reports_per_day']=Report::where('created_at','LIKE',['%'.\Carbon\Carbon::now()->format('Y-m-d').'%'])->count();

        return $this->sendResponse($data,'All Reports Page Data'); 


    }


    public function dltreport(Request $req){
        $report=Report::find($req->id);
        if(!$report)
        return $this->sendError('This Report Does Not Exist'); 

        $report->delete();

        return $this->sendResponse($report,'Report Deleted Successfully'); 

        
    }
}
