<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReportMessage;
use App\Models\Report;
use App\Events\MessageCreated;
use Illuminate\Support\Facades\Auth;

class ReportMessageController extends Controller
{
     function getMessages(){  
        $user = Auth::user();
        return  ReportMessage::with(['report'])->where(function ($query) use ($user) {
               return $query->where('from', '=', $user->id)
                      ->orWhere('to', '=', $user->id);
             })->get();

    }
     function getReportMessages($id){  
        $user = Auth::user();
        return  ReportMessage::where('report_id',$id)->where(function ($query) use ($user) {
               return $query->where('from', '=', $user->id)
                      ->orWhere('to', '=', $user->id);
             })->get();

    }
    function store(Request $request,$id){  
        $user = Auth::user();
        $message = new ReportMessage();
        $report = Report::findOrFail($id);
        if($request->input('message')) $message->message = $request->input('message');
        if($request->input('type')) $message->type = $request->input('type');
        if($request->input('report_id')) $message->report_id = $id;
        $message->from = $user->id;
        if($request->input('type') == "ma") $message->to = $report->assigned_to_admin;
        if($request->input('type') == "mu") $message->to = $report->user_id;
        $message->save();
        event(new MessageCreated($message));
        return $message;
        
    }
}
