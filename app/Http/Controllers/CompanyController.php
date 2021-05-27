<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyManager;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


class CompanyController extends Controller
{
    public function index()
    {
        return Company::withCount('managers')->paginate(10);
    }

    public function show()
    {
        return Company::findOrFail(Auth::user()->company_id);
    }
     public function getCodes()
    {
      $company = Company::findOrFail(Auth::user()->company_id);
      $company = $company->makeVisible(['alpha_code', 'beta_code']);
       return $company;
    }

    public function store(Request $request)
    {
        $company = new Company();
        if($request->input('name')) $company->name = $request->input('name');
        if($request->input('website')) $company->website = $request->input('website');
        if($request->input('email')) $company->email = $request->input('email');
        if($request->input('phone')) $company->phone = $request->input('phone');
        if($request->input('description')) $company->description = $request->input('description');
         if($request->file('logo')) $company->logo = $request->file('logo')->storeAs('companies', $request->logo->getClientOriginalName(), 'public');
        $company->alpha_code = substr(strtoupper(chunk_split(Str::random(16), 4, '-')),0,-1);
        $company->beta_code = substr(strtoupper(chunk_split(Str::random(16), 4, '-')),0,-1);
        $company->save();
        return $company;
    }

    public function update(Request $request)
    {
        $company = Company::findOrFail(Auth::user()->company_id);
        if($request->input('name')) $company->name = $request->input('name');
        if($request->input('website')) $company->website = $request->input('website');
        if($request->input('email')) $company->email = $request->input('email');
        if($request->input('phone')) $company->phone = $request->input('phone');
        if($request->input('description')) $company->description = $request->input('description');
         if($request->file('logo')) $company->logo = $request->file('logo')->storeAs('companies', $request->logo->getClientOriginalName(), 'public');
        $company->save();
        return $company;
    }
    public function generate(Request $request)
    {
        $company = Company::findOrFail(Auth::user()->company_id);
       if($request->input('type') == 'alpha_code') $company->alpha_code = substr(strtoupper(chunk_split(Str::random(16), 4, '-')),0,-1);
       else $company->beta_code = substr(strtoupper(chunk_split(Str::random(16), 4, '-')),0,-1);
        $company->save();
        $company = $company->makeVisible(['alpha_code', 'beta_code']);
       return $company;
    }


    public function destroy()
    {
        $company = Company::findOrfail(Auth::user()->company_id);
        if($company->delete()) return  true;
        return "Error while deleting";
    }

    public function getManagers()
    {
        return CompanyManager::with('manager')->where('company_id',Auth::user()->company_id)->get();
    }


    public function addManager(Request $request)
    {
        $company = new CompanyManager();
        $company->company_id = Auth::user()->company_id;
        $company->manager_id= $request->input('manager_id');
        $company->save();
        return $company;
    }
    public function deleteManager( $manager_id)
    {
        $company_manager = CompanyManager::where('manager_id',$manager_id)
            ->where('company_id',Auth::user()->company_id);
        if($company_manager->delete()) return  true;
        return "Error while deleting";
    }


}
