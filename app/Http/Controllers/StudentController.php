<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Generator;
use App\Models\Student;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $data['q'] = $request->query('q');

        // dd($data);

        $query = Student::select('students.*', 'users.name as users_name', 'generators.topic', 'generators.aspect')
            ->join('users', 'users.id', '=', 'students.user_id')
            ->join('generators', 'generators.id', '=', 'students.question_id')
            ->where(function ($query) use ($data) {
                $query->where('students.answer', 'like', '%' . $data['q'] . '%');
            });

        
        // if ($data['status'])
        //     $query->where('menus.status', $data['status']);

        $data['generators'] = $query->paginate(10)->withQueryString();
        // dd($data);
        return view('students.index', $data);

    }


    public function indexSiswa(Request $request)
    {
    
        $data['q'] = $request->query('q');

        // dd($data);

        $query = Student::select('students.*', 'users.name as users_name', 'generators.topic', 'generators.aspect')
            ->join('users', 'users.id', '=', 'students.user_id')
            ->join('generators', 'generators.id', '=', 'students.question_id')
            ->where(function ($query) use ($data) {
                $query->where('students.answer', 'like', '%' . $data['q'] . '%');
            });

        
        // if ($data['status'])
        //     $query->where('menus.status', $data['status']);

        // $data['students'] = $query->paginate(10)->withQueryString();
        $data['students'] = $query->paginate(10, ['*'], 'students_page')->appends(request()->query());

        // dd($data);
        // dd(count($data['students']));

        
            
        foreach ($data['students'] as $key => $value) {
            $var = 'comment'.$key;
            if(isset($request->$var)){
                $student = Student::find($data['students'][$key]->id);
                $updateData['comment'] =  $request->$var;
                if($student->update($updateData)){
                    return redirect()->back()->with('success', 'Data has been updated successfully.');
                }
                
                
            }        
        }
            
        

        // for ($i=0; $i < count($data['students']); $i++) { 
        //     $var = 'comment'.$i;
        //     if(isset($request->$var)){
        //         $student = Student::find($data['students'][$i]->id);
                
        //         $student->update($values);
        //     }
        // }

        

        return view('students.listanswer', $data);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        
        $id = $request->id;
        $data_question = Generator::where('id',$id)->get();
        $question = explode("\n", $data_question[0]->question);

        // dd($question);
        return view('students.create')->with(['id'=>$id, 'question'=>$question]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    //     // $data['question_id'] = $request->question_id;

    //     $data_question = Generator::where('id',$request->question_id)->get();
    //     $question = explode("\n", $data_question[0]->question);

    //     foreach ($question as $key => $value) {
    //         $answerKey = 'answer_' . $key;

    //         $student = new Student;
    //         $student->question_id = $request->question_id;
    //         $student->answer = $request->$answerKey;
    //         $student->user_id = auth()->user()->id;
            
    //         $student->save();
    //     }
        
    //     //dd($data);
        
    //    // Menu::create($data); //$request->all()
       
    //     return redirect()->route('students.index')
    //                     ->with('success','Answer has been submit successfully.');
        dd($request);
    }

    
    public function show(Student $student)
    {
        $generator = Generator::where(['id'=>$student->question_id])->get();
        // dd($generator);

        $student->topic = $generator[0]->topic;
        $student->aspect = $generator[0]->aspect;
        
        return view('students.show',compact('student'));
    }

    
    public function edit(string $id)
    {
        //
    }

    
    public function update(Request $request, string $id)
    {
        //
    }

    
    public function destroy(string $id)
    {
        //
    }
}
