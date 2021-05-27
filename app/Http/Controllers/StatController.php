<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Report;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StatController extends Controller
{
     public function getProgramsStatus()
    {

        return Program::where('company_id', Auth::user()->company_id)->groupBy('status')->select('status', DB::raw('count(*) as count'))->get();;

    }
    public function getProgramsStats()
    {

        return Program::withCount(['users','reports'])->where('company_id', Auth::user()->company_id)->get();

    }
//    public function getCompanyStats($id)
//    {
//
//        $programs =  Program::where('company_id',$id)->pluck('id')->toArray();
////         Report::with(['program'  => function ($query) use($id) {
////                        $query->where('company_id',$id)->select('id','name','company_id');
////                       }])->get(['title','bounty_win','prog_id']);
//        return  Report::whereIn('prog_id',$programs)->get(['bounty_win','created_at','prog_id']);
//
//    }

    public function CompanyBounty()
    {
        $stats = [] ;
        $now = Carbon::now();
        $programs =  Program::where('company_id', Auth::user()->company_id)->pluck('id')->toArray();
        for($i=0;$i<6;$i++)
        {
            array_push($stats,array(Carbon::parse($now)->format('F')=>Report::whereIn('prog_id',$programs)->whereMonth('bounty_at',$now->month)->sum("bounty_win")));
            $now->subMonth() ;

        }
        return  $stats;

    }

        public function getCompanyReportsStats()
    {
         $stats= new StatController();
        $programs =  Program::where('company_id', Auth::user()->company_id)->pluck('id')->toArray();
        $stats->status =  Report::whereIn('prog_id',$programs)->groupBy('status')->select('status', DB::raw('count(*) as status_count'))->get();
        $stats->severity = Report::whereIn('prog_id',$programs)->groupBy('severity')->select('severity', DB::raw('count(*) as severity_count'))->get();

        return response()->json($stats);
    }

}
