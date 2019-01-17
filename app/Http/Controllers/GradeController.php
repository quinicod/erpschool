<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\grade;
use App\study;
use App\petition;
use App\student;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grades = grade::all();
        $grade = new grade;
        $abrir=false;

        return view('grades.indexGrades', compact('grades','grade','abrir'));
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
            'level' => 'required|max:2',
        ]);
        grade::create($request->all());
        

        return redirect('grades')->with("modificado",'Curso creado');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(grade $grade)
    {
        $grade->has('students')->get();
        $students=student::orderBy('name','asc')->get();

        return view('grades.studentsGrade', compact('grade','students','studentGrade'));
    }

    public function addStudent(Request $request, $id_g)
    {
        foreach($request->students as $s){
            study::create([
                'id_student' => $s,
                'id_grade' => $id_g
            ]);
        }

        return redirect()->route('grades.show',['id_g' => $id_g]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(grade $grade)
    {
        $grades = grade::all();
        $abrir=true;

        return view('grades.indexGrades', compact('grades','grade','abrir'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, grade $grade)
    {
        $grade->update($request->all());

        return redirect('grades')->with('modificado','Actualizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(grade $grade)
    {
        $alumnosCurso=study::where('id_grade',$grade->id)->first();
        // $peticionesGrado=petition::where('id_grade',$grade->id)->first();
        //dd(is_null($peticionesGrado));
        if(is_null($alumnosCurso)){
            $grade->delete();
        }else{
            return redirect('grades')->with('eliminado','El Curso tiene alumnos, no puedes borrarlo.');
        }
        
        return redirect('grades')->with('modificado','Borrado con exito!');
    }

    public function borrarAlumnoCurso($id_c, $id_a)
    {
        $estudio=study::where('id_grade',$id_c)->where('id_student',$id_a)->first();
        $estudio->delete();

        return redirect()->route('grades.show', ['id' => $id_c])->with('modificado','Alumno eliminado del curso');
    }
}
