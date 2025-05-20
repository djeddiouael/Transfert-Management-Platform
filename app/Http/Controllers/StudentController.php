<?php

namespace App\Http\Controllers;

use App\Models\student;
use App\Http\Requests\StorestudentRequest;
use App\Http\Requests\UpdatestudentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('student.index', [
            'students' => student::Paginate(5)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('student.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorestudentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorestudentRequest $request)
    {
        $student = new student();
        $student->name = $request->name;
        $student->age = $request->age;
        $student->phone = $request->phone;
        $student->email = $request->email;
        $student->matricule = $request->matricule;
        $student->save();

        return redirect()->route('students');
    }

    public function register(Request $request)
    {
          $message="";
          $error="success";
          if(student::whereEmail($request->email)->count() > 0){
            $message="تم التسجيل بهذا البريد الالكتروني من قبل";
            $error="danger";
          }
          elseif(student::wherePhone($request->phone)->count() > 0){
            $message="تم التسجيل بنفس رقم الهاتف  من قبل";
            $error="danger";
          }
          elseif(student::whereMatricule($request->matricule)->count() > 0){
              $message="تم التسجيل بنفس رقم التسجيل من قبل";
              $error="danger";
          }
          else{
            student::create($request->all());
            $message="تم التسجيل بنجاح";
          }
          return redirect(route('/') . '#inscrire')
                         ->with('error', $error)
                         ->with('message', $message);

    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\student  $student
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student = student::find($id)->first();
        return $student;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(student $student)
    {
        return view('student.edit', [
            'student' => $student
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatestudentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatestudentRequest $request, $id)
    {
        $student = student::find($id);
        $student->name = $request->name;
        $student->age = $request->age;
        $student->phone = $request->phone;
        $student->email = $request->email;
        $student->matricule = $request->matricule;
        $student->save();
        $page = $request->input('page', 1);
        // dd($page);
        return redirect()->route('students', ['page' => $page]);
        return redirect()->route('students');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        student::find($id)->delete();
        return redirect()->route('students');
    }

    /**
     * Display the student's profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function showProfile()
    {
        // Récupérer l'étudiant connecté
        $student = student::where('email', Auth::user()->email)->first();
        
        if (!$student) {
            return redirect()->back()->with('error', 'Profil étudiant non trouvé');
        }

        return view('student.student_profile', compact('student'));
    }
}
