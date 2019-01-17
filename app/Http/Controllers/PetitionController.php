<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\petition;
use App\company;
use App\grade;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade as PDF;

class PetitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $petitions = petition::with('company','grade')->get();
        $companies = company::all();
        $grades = grade::all();
        $petition = new petition;
        $abrir = false;

        return view('petitions.indexPetitions', compact('petitions','petition','companies','grades','abrir'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filtroPetitions(Request $request)
    {
        
        $petitions = petition::select('*');
        if($request->desde != null){
            $petitions->where('created_at','>=',$request->desde);
        }
        if($request->hasta != null){
            $petitions->where('created_at','<=',$request->hasta);
        }
        if($request->type != null){
            $petitions->where('type',$request->type);
        }
        if($request->grade != null){
            $petitions->where('id_grade',$request->grade);
        }
        $petitions = $petitions->with('company','grade')->get();
        

        $desde=$request['hasta'];
        $hasta=$request['desde'];
        $type=$request->type;
        $grade=$request->grade;
        $companies = company::all();
        $grades = grade::all();
        $petition = new petition;
        $abrir = false;

        return view('petitions.indexPetitions', compact('petitions','petition','companies','grades','abrir','desde','hasta','type','grade'));
    }

    public function listadoPdf(Request $request)
    {
        $petitions = petition::select('*');
        if($request->desde != null){
            $petitions->where('created_at','>=',$request->desde);
            $desde=$request->desde;
        }else{
            $desde=null;
        }
        if($request->hasta != null){
            $petitions->where('created_at','<=',$request->hasta);
            $hasta=$request->hasta;
        }else{
            $hasta=null;
        }
        if($request->type != null){
            $petitions->where('type',$request->type);
            $type=$request->type;
        }else{
            $type=null;
        }
        if($request->grade != null){
            $petitions->where('id_grade',$request->grade);
            $grade=grade::find($request->grade);
            $grade=$grade->name;
        }else{
            $grade=null;
        }
        $petitions = $petitions->with('company','grade')->get();

        set_time_limit(300);
        $pdf = PDF::loadView('petitions.pdf', compact('petitions','desde','hasta','type','grade'));
        $namefile="ListadoSolicitudes.pdf";
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->stream($namefile , array( 'Attachment'=> false ) );
        //return $pdf->download($namefile);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        petition::create($request->all());

        return redirect('petitions')->with("modificado",'Petición creada');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(petition $petition)
    {
        $petitions = petition::with('company','grade')->get();
        $companies = company::all();
        $grades = grade::all();
        $abrir = true;

        return view('petitions.indexPetitions', compact('petitions','petition','companies','grades','abrir'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, petition $petition)
    {
        $petition->update($request->all());

        return redirect('petitions')->with('modificado','Actualizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(petition $petition)
    {
        $petition->delete();

        return redirect('petitions')->with('eliminado','Petición borrada correctamente.');
    }
}
