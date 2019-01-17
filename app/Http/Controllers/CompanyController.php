<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\company;
use App\petition;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = company::all();
        $company = new company;
        $abrir=false;

        return view('companies.indexCompanies', compact('companies','company','abrir'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'city' => 'required|max:100',
            'cp' => 'required|max:5|min:5',
        ]);
        // $n=ctype_digit($request->cp);
        company::create($request->all());
        

        return redirect('companies')->with("modificado",'Empresa creada');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $companies = company::all();
        $company=company::find($id);
        $abrir=true;

        return view('companies.indexCompanies', compact('companies','company','abrir'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $company=company::find($id);
        $company->update($request->all());

        return redirect('companies')->with('modificado','Actualizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $peticiones=petition::where('id_company',$id)->first();
        if(is_null($peticiones)){
            $empresa=company::find($id);
            $empresa->delete();
        }else{
            return redirect('companies')->with('eliminado','Esta empresa tiene solicitudes, no puedes borrarlo.');
        }
        
        return redirect('companies')->with('modificado','Borrado con exito!');
    }
}
