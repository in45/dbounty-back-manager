<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index()
    {
        return Report::with(['user','vuln','program'])->paginate(4);
    }

    public function show($id)
    {
        return Report::findOrFail($id);
    }
     public function getProgramReports(Request $request,$id)
    {
      $status = $request->input('status');
        $type = $request->input('type');
        $manager_id = Auth::user()->id;
        if(!$type) {
        
            return Report::with(['user', 'vuln', 'program'])->where('prog_id',$id)->where('status', 'like', $status . '%')->paginate(6);
       }
        else  return Report::with(['user','vuln','program'])->where('prog_id',$id)->where('status', 'like', $status . '%')->where('assigned_to_manager',$manager_id)->paginate(6);
    
     
    }

       public function getCompanyReports(Request $request)
    {
        $status = $request->input('status');
        $type = $request->input('type');
        $manager = Auth::user()->load('company');
        $programs =  Program::where('company_id',$manager->company_id)->pluck('id')->toArray();
        $reports = Report::with(['user','vuln','program'])->whereIn('prog_id',$programs)->where('status', 'like', $status . '%');
        if(!$type) {
            return $reports->paginate(6);
        }
        else  return $reports->where('assigned_to_manager',$manager->id)->paginate(6);
     
    }

       public function getUserReports($user_id)
    {
        return Report::with(['program','vuln'])->where('user_id',$user_id)->get();
    }


    public function store(Request $request)
    {

    
        $report = new Report();
         if($request->input('target')) $report->target = $request->input('target');
         if($request->input('vuln_id')) $report->vuln_id = $request->input('vuln_id');
         if($request->input('user_id')) $report->user_id = $request->input('user_id');
         if($request->input('prog_id')) $report->prog_id = $request->input('prog_id');
         if($request->input('vuln_name')) $report->vuln_name = $request->input('vuln_name');
         if($request->input('vuln_details')) $report->vuln_details = $request->input('vuln_details');
         if($request->input('validation_steps')) $report->validation_steps = $request->input('validation_steps');
         if($request->input('severity')) $report->severity = $request->input('severity');
         if($request->file('file_upload')) $report->file_upload = $request->file('file_upload')->storeAs('Reports', $request->file_upload->getClientOriginalName(), 'public');
         if($request->input('status')) $report->status = $request->input('status');
         if($request->input('bounty_win')) $report->bounty_win = $request->input('bounty_win');
         if($request->input('status')) $report->status = $request->input('status');
         $report->save();
         return $report;
    }

    public function update(Request $request,$id)
    {
        $report = Report::findOrFail($id);

         if($request->input('target')) $report->target = $request->input('target');
         if($request->input('vuln_id')) $report->vuln_id = $request->input('vuln_id');
         if($request->input('user_id')) $report->user_id = $request->input('user_id');
         if($request->input('prog_id')) $report->prog_id = $request->input('prog_id');
         if($request->input('vuln_name')) $report->vuln_name = $request->input('vuln_name');
         if($request->input('vuln_details')) $report->vuln_details = $request->input('vuln_details');
         if($request->input('validation_steps')) $report->validation_steps = $request->input('validation_steps');
         if($request->input('severity')) $report->severity = $request->input('severity');
         if($request->file('file_upload')) $report->file_upload = $request->file('file_upload')->storeAs('Reports', $request->file_upload->getClientOriginalName(), 'public');
         if($request->input('status')) $report->status = $request->input('status');
         if($request->input('bounty_win')) $report->bounty_win = $request->input('bounty_win');
         if($request->input('status')) $report->status = $request->input('status');
         $report->save();
         return $report;
    }
    public function destroy($id)
    {
        $report = Report::findOrfail($id);
        if($report->delete()) return  true;
        return "Error while deleting";
    }

    public function assigne(Request $request,$id){
          $report = Report::findOrFail($id);
          $report->assigned_to_manager = $request->input('manager_id');
          $report->save();
          return $report;
    }
}
