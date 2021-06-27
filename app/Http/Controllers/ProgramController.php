<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Report;
use App\Models\ProgramUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgramController extends Controller
{
    public function index()
    {
        return Program::with('company')->withCount(['reports','users'])->paginate(6);
    }

    public function show($id)
    {
        return Program::with('company')->where('id',$id)->withCount(['reports','users'])->first();;
    }

     public function getCompanyPrograms()
    {
        return Program::where('company_id',Auth::user()->company_id)->withCount(['reports','users'])->paginate(6);
    }
      public function getUserPrograms($user_id)
    {
        return ProgramUser::with('program')->where('user_address',$user_id)->get();
    }
    public function getUsers($id)
    {
        return ProgramUser::with('user')->where('prog_id',$id)->limit(10)->get();
    }


    public function store(Request $request)
    {

        $program = new Program();
        $program->name = $request->input('name');
         $program->company_id =  Auth::user()->company_id;
        if($request->input('type')) $program->type = $request->input('type');
        if($request->file('logo')) $program->logo = $request->file('logo')->storeAs('programs', $request->logo->getClientOriginalName(), 'public');
        if($request->input('min_bounty')) $program->min_bounty = $request->input('min_bounty');
        if($request->input('max_bounty')) $program->max_bounty = $request->input('max_bounty');
        if($request->input('managed_by_dbounty') == 0 || $request->input('managed_by_dbounty') == 1) $program->managed_by_dbounty = $request->input('managed_by_dbounty');
        if($request->input('begin_at')) $program->begin_at = $request->input('begin_at');
        if($request->input('finish_at')) $program->finish_at = $request->input('finish_at');
        if($request->input('range_response')) $program->range_response = $request->input('range_response');
        if($request->input('scopes')) $program->scopes = $request->input('scopes');
        if($request->input('rules')) $program->rules = $request->input('rules');
        if($request->input('conditions')) $program->conditions = $request->input('conditions');
        if($request->input('info')) $description["info"] = $request->input('info');
        if($request->input('p1'))  $rewards["p1"] = $request->input('p1');
        if($request->input('p2'))  $rewards["p2"] = $request->input('p2');
        if($request->input('p3'))  $rewards["p3"] = $request->input('p3');
        if($request->input('p4'))  $rewards["p4"] = $request->input('p4');
        if($request->input('p5'))  $rewards["p5"] = $request->input('p5');
        $description["rewards"] = $rewards;
        $program->description = json_encode($description);
        $program->save();
        return $program;
    }

    public function update(Request $request,$id)
    {
        $program = Program::findOrFail($id);
        if($request->input('name')) $program->name = $request->input('name');
        if($request->input('type')) $program->type = $request->input('type');
        if($request->file('logo')) $program->logo = $request->file('logo')->storeAs('programs', $request->logo->getClientOriginalName(), 'public');
        if($request->input('min_bounty')) $program->min_bounty = $request->input('min_bounty');
        if($request->input('max_bounty')) $program->max_bounty = $request->input('max_bounty');
        if($request->input('begin_at')) $program->begin_at = $request->input('begin_at');
        if($request->input('finish_at')) $program->finish_at = $request->input('finish_at');
        if($request->input('range_response')) $program->range_response = $request->input('range_response');
        if($request->input('scopes')) $program->scopes = $request->input('scopes');
        if($request->input('rules')) $program->rules = $request->input('rules');
        if($request->input('conditions')) $program->conditions = $request->input('conditions');
        if($request->input('status')) $program->status = $request->input('status');
        if($request->input('info')) $description["info"] = $request->input('info');
        if($request->input('p1'))  $rewards["p1"] = $request->input('p1');
        if($request->input('p2'))  $rewards["p2"] = $request->input('p2');
        if($request->input('p3'))  $rewards["p3"] = $request->input('p3');
        if($request->input('p4'))  $rewards["p4"] = $request->input('p4');
        if($request->input('p5'))  $rewards["p5"] = $request->input('p5');
        $description["rewards"] = $rewards;
        $program->description = json_encode($description);
        $program->save();
        return $program;
    }
    public function destroy()
    {
        $program = Program::findOrfail(Auth::user()->company_id);
        if($program->delete()) return  true;
        return "Error while deleting";
    }

    public function searchProgram(Request $request)
    {

        $name = $request->input('name');
        return Program::where('name', 'like', $name . '%')->where('company_id',Auth::user()->company_id)->withCount(['reports','users'])->paginate(6);;
    }
}
