<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyManager;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class CompanyController extends Controller
{
    public function index()
    {
        return Company::withCount('managers')->paginate(10);
    }

    public function show($id)
    {
        $company = Company::findOrFail($id);
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

    public function update(Request $request,$id)
    {
        $company = Company::findOrFail($id);
        if($request->input('name')) $company->name = $request->input('name');
        if($request->input('website')) $company->website = $request->input('website');
        if($request->input('email')) $company->email = $request->input('email');
        if($request->input('phone')) $company->phone = $request->input('phone');
        if($request->input('description')) $company->description = $request->input('description');
         if($request->file('logo')) $company->logo = $request->file('logo')->storeAs('companies', $request->logo->getClientOriginalName(), 'public');
        $company->save();
        return $company;
    }
    public function generate(Request $request,$id)
    {
        $company = Company::findOrFail($id);
       if($request->input('type') == 'alpha_code') $company->alpha_code = substr(strtoupper(chunk_split(Str::random(16), 4, '-')),0,-1);
       else $company->beta_code = substr(strtoupper(chunk_split(Str::random(16), 4, '-')),0,-1);
        $company->save();
        $company = $company->makeVisible(['alpha_code', 'beta_code']);
       return $company;
    }


    public function destroy($id)
    {
        $company = Company::findOrfail($id);
        if($company->delete()) return  true;
        return "Error while deleting";
    }

    public function getManagers($id)
    {
        return CompanyManager::with('manager')->where('company_id',$id)->get();
    }


    public function addManager(Request $request,$id)
    {
        $company = new CompanyManager();
        $company->company_id = $id;
        $company->manager_address = $request->input('manager_address');
        $company->save();
        return $company;
    }
    public function deleteManager($id, $manager_id)
    {
        $company_manager = CompanyManager::where('manager_address',$manager_id)
            ->where('company_id',$id);
        if($company_manager->delete()) return  true;
        return "Error while deleting";
    }


}
