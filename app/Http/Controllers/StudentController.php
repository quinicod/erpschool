<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\student;
use App\study;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = student::with('cursos')->get();
        $student=new student;
        $abrir=false;

        return view('students.indexstudents', compact('students','student','abrir'));
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
            'name' => 'required|max:50',
            'lastname' => 'required|max:100',
            'age' => 'required|max:2|min:1',
        ]);
        student::create($request->all());
        

        return redirect('students')->with("modificado",'Estudiante creado');
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
    public function edit(student $student) 
    {
        $students = student::orderBy('name','asc')->get();
        $abrir=true;

        return view('students.indexstudents', compact('students','student','abrir'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, student $student)
    {
        $student->update($request->all());

        return redirect('students')->with('modificado','Actualizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(student $student)
    {
        $estudio=study::where('id_student',$student->id)->first();
        if(is_null($estudio)){
            $student->delete();
        }else{
            return redirect('students')->with('eliminado','El alumno está matriculado en un curso, no puedes borrarlo.');
        }
        
        return redirect('students')->with('modificado','Borrado con exito!');
    }
}
