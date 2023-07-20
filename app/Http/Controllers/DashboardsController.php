<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Generator;
use App\Models\Student;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd($data);
        
        // $value = date('Y').'-'.$request->input('periode');

        $value = date('Y-m');
        $months = [];
        for ($i=1; $i<=12; $i++) { 
            if(strlen($i) < 2){
                $i = '0'.$i;
            }

            $months[$i] = date('F', mktime(0,0,0,$i, 1, date('Y')));
        }
        $user_generated = Generator::where(DB::raw("(DATE_FORMAT(created_at,'%Y-%m'))"),$value)->count();

        $topic_aspect = Generator::select('topic', 'aspect')->where(DB::raw("(DATE_FORMAT(created_at,'%Y-%m'))"),$value)->groupBy(['topic','aspect'])->paginate(10)->withQueryString();

        $siswa_lulus = Student::select('students.*', 'users.name as users_name', 'generators.topic', 'generators.aspect')
        ->join('users', 'users.id', '=', 'students.user_id')
        ->join('generators', 'generators.id', '=', 'students.question_id')
        ->where(DB::raw("(DATE_FORMAT(students.created_at,'%Y-%m'))"),$value)
        ->where('students.score','>=',80)->paginate(10)->withQueryString();

        $siswa_tidak_lulus = Student::select('students.*', 'users.name as users_name', 'generators.topic', 'generators.aspect')
        ->join('users', 'users.id', '=', 'students.user_id')
        ->join('generators', 'generators.id', '=', 'students.question_id')
        ->where(DB::raw("(DATE_FORMAT(students.created_at,'%Y-%m'))"),$value)
        ->where('students.score','<',80)->paginate(10)->withQueryString();

        $frekuensi = Student::select('users.name as users_name')
        ->join('users', 'users.id', '=', 'students.user_id')
        ->join('generators', 'generators.id', '=', 'students.question_id')
        ->selectRaw('count(*) as generated')
        ->selectRaw('(SELECT count(*) FROM students WHERE user_id = students.user_id AND score >= 80) as lulus')
        ->selectRaw('(SELECT count(*) FROM students WHERE user_id = students.user_id AND score < 80) as tdk_lulus')
        ->where(DB::raw("(DATE_FORMAT(students.created_at,'%Y-%m'))"),$value)
        ->groupBy('users.name')
        ->get();

        $query_diagram = $query = "
            SELECT 'LULUS' AS status, COUNT(*) AS jml
            FROM students
            WHERE DATE_FORMAT(created_at, '%Y-%m') = ? AND score >= 80
            UNION
            SELECT 'TIDAK LULUS' AS status, COUNT(*) AS jml
            FROM students
            WHERE DATE_FORMAT(created_at, '%Y-%m') = ? AND score < 80
        ";

        $diagram = DB::select($query, [$value, $value]);

        // dd($diagram);
        // if($value){
        //     dd($frekuensi);
        // }

        
        return view('dashboards.dashboards')->with(compact('months','topic_aspect','siswa_lulus','siswa_tidak_lulus','frekuensi','diagram'));
    }

    public function getData(Request $request){
        $value = date('Y').'-'.$request->input('periode');

        
        $months = [];
        for ($i=1; $i<=12; $i++) { 
            if(strlen($i) < 2){
                $i = '0'.$i;
            }

            $months[$i] = date('F', mktime(0,0,0,$i, 1, date('Y')));
        }
        $user_generated = Generator::where(DB::raw("(DATE_FORMAT(created_at,'%Y-%m'))"),$value)->count();

        $topic_aspect = Generator::select('topic', 'aspect')->where(DB::raw("(DATE_FORMAT(created_at,'%Y-%m'))"),$value)->groupBy(['topic','aspect'])->paginate(10)->withQueryString();

        $siswa_lulus = Student::select('students.*', 'users.name as users_name', 'generators.topic', 'generators.aspect')
        ->join('users', 'users.id', '=', 'students.user_id')
        ->join('generators', 'generators.id', '=', 'students.question_id')
        ->where(DB::raw("(DATE_FORMAT(students.created_at,'%Y-%m'))"),$value)
        ->where('students.score','>=',80)->paginate(10)->withQueryString();

        $siswa_tidak_lulus = Student::select('students.*', 'users.name as users_name', 'generators.topic', 'generators.aspect')
        ->join('users', 'users.id', '=', 'students.user_id')
        ->join('generators', 'generators.id', '=', 'students.question_id')
        ->where(DB::raw("(DATE_FORMAT(students.created_at,'%Y-%m'))"),$value)
        ->where('students.score','<',80)->paginate(10)->withQueryString();

        $frekuensi = Student::select('users.name as users_name')
        ->join('users', 'users.id', '=', 'students.user_id')
        ->join('generators', 'generators.id', '=', 'students.question_id')
        ->selectRaw('count(*) as generated')
        ->selectRaw('(SELECT count(*) FROM students WHERE user_id = students.user_id AND score >= 80) as lulus')
        ->selectRaw('(SELECT count(*) FROM students WHERE user_id = students.user_id AND score < 80) as tdk_lulus')
        ->where(DB::raw("(DATE_FORMAT(students.created_at,'%Y-%m'))"),$value)
        ->groupBy('users.name')
        ->get();

        $query_diagram = $query = "
            SELECT 'LULUS' AS status, COUNT(*) AS jml
            FROM students
            WHERE DATE_FORMAT(created_at, '%Y-%m') = ? AND score >= 80
            UNION
            SELECT 'TIDAK LULUS' AS status, COUNT(*) AS jml
            FROM students
            WHERE DATE_FORMAT(created_at, '%Y-%m') = ? AND score < 80
        ";

        $diagram = DB::select($query, [$value, $value]);

        $data = [
            'months'=>$months,
            'topic_aspect'=>$topic_aspect,
            'siswa_lulus'=>$siswa_lulus,
            'siswa_tidak_lulus'=>$siswa_tidak_lulus,
            'frekuensi'=>$frekuensi,
            'diagram' => $diagram
        ];

        // dd($data);

        return response()->json($data);
    }

    public function generateDates(Carbon $startDate, Carbon $endDate, $format = 'Y-m-d')
    {
        $dates = collect();
        $startDate = $startDate->copy();

        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $dates->put($date->format($format), 0);
        }

        return $dates;
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
        //
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
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
