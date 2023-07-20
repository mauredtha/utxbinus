<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Generator;
use App\Models\Student;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Arr;
use OpenAI\Laravel\Facades\OpenAI;
use NlpTools\Similarity\CosineSimilarity;
use NlpTools\Tokenizers\WhitespaceTokenizer;


class GeneratorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $data['q'] = $request->query('q');

        // dd($data);

        $query = Generator::select('generators.*', 'users.name as users_name')
            ->join('users', 'users.id', '=', 'generators.user_id')
            ->where(function ($query) use ($data) {
                $query->where('generators.topic', 'like', '%' . $data['q'] . '%');
            });

        
        // if ($data['status'])
        //     $query->where('menus.status', $data['status']);

        $data['generators'] = $query->paginate(30)->withQueryString();
        // dd($data);
        return view('generators.index', $data);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('generators.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $prompt = "Dari aspek ".$request->aspect.', berikan deskripsi lengkap tentang '.$request->topic;

        $completions = OpenAI::completions()->create([
            "model" => "text-davinci-003",
            "prompt" => $prompt,
            "max_tokens" => 512,
            "n" => 7,
            "stop" => null,
            // "temperature" => 0.6
        ]);
    
        $narasi = ltrim($completions['choices'][0]['text']);
        
        $prompt_x = "Tuliskan 5 pertanyaan penting yang rujuk paragraf berikut: " . $narasi;
        
        $completions1 = OpenAI::completions()->create([
            "model" => "text-davinci-003",
            "prompt" => $prompt_x,
            "max_tokens" => 256,
            "n" => 9,
            "stop" => null,
            // "temperature" => 0.6
        ]);
    
        $pertanyaan = ltrim($completions1['choices'][0]['text']);

        $prompt_jawaban = "Tuliskan jawaban dari pertanyaan berikut: " . $pertanyaan;
        $completions2 = OpenAI::completions()->create([
            "model" => "text-davinci-003",
            "prompt" => $prompt_jawaban,
            "max_tokens" => 512,
            "n" => 7,
            "stop" => null,
            // "temperature" => 0.6
        ]);

        $jawaban = ltrim($completions2['choices'][0]['text']);

        ///DUMMY//
        // $narasi = "Ilmu Digital Bisnis adalah cabang baru dari ilmu manajemen yang menekankan pada penggunaan teknologi digital untuk meningkatkan produktivitas dan efisiensi bisnis. Ini mencakup penggunaan teknologi digital seperti aplikasi web, data mining, kecerdasan buatan, dan lainnya untuk membantu meningkatkan efisiensi bisnis. Ilmu Digital Bisnis juga mempelajari bagaimana menggabungkan teknologi digital dengan strategi bisnis yang tepat untuk mencapai tujuan bisnis. Di Indonesia, ilmu digital bisnis telah berkembang pesat dan merupakan salah satu disiplin yang paling penting di bidang pendidikan tinggi. Dengan menggunakan teknologi digital, organisasi bisnis di Indonesia dapat meningkatkan produktivitas dan efisiensi, serta meningkatkan kinerja mereka. Program-program pendidikan tinggi di Indonesia yang menawarkan kursus dan program studi ilmu digital bisnis mencakup Universitas Bina Nusantara, Universitas Indonesia, dan Universitas Gadjah Mada.";

        // $pertanyaan = "1. Apa yang dimaksud dengan Ilmu Digital Bisnis? 
        // 2. Apa yang dicakup oleh Ilmu Digital Bisnis? 
        // 3. Bagaimana teknologi digital dapat membantu meningkatkan efisiensi bisnis? 
        // 4. Bagaimana teknologi digital dapat digabungkan dengan strategi bisnis? 
        // 5. Bagaimana Ilmu Digital Bisnis berkembang di Indonesia? 
        // 6. Apa yang ditawarkan oleh program pendidikan tinggi di Indonesia yang berhubungan dengan Ilmu Digital Bisnis? 
        // 7. Apa universitas tertentu di Indonesia yang menawarkan kursus dan program studi Ilmu Digital Bisnis?";

        $listPertanyaan = explode("\n", $pertanyaan);

        // $jawaban = "1. Ilmu Digital Bisnis adalah suatu disiplin yang melibatkan penggunaan teknologi digital untuk meningkatkan efisiensi bisnis dan meningkatkan keuntungan. 
        // 2. Ilmu Digital Bisnis mencakup berbagai macam teknologi digital seperti Big Data, Pengolahan Data, Cloud Computing dan Teknologi Mobile. 
        // 3. Teknologi digital dapat membantu meningkatkan efisiensi bisnis dengan cara menghemat waktu, biaya dan sumber daya. Ini juga dapat membantu perusahaan untuk memperluas pasar, meningkatkan produktivitas dan meningkatkan layanan pelanggan. 
        // 4. Teknologi digital dapat digabungkan dengan strategi bisnis melalui penggunaan Big Data untuk memahami pelanggan dan pasar, meningkatkan pengalaman pelanggan, dan meningkatkan efisiensi operasional. 
        // 5. Ilmu Digital Bisnis telah berkembang pesat di Indonesia. Banyak perusahaan telah menggunakan teknologi digital untuk meningkatkan efisiensi dan meningkatkan keuntungan. 
        // 6. Program pendidikan tinggi di Indonesia yang berhubungan dengan Ilmu Digital Bisnis menawarkan kursus yang mencakup berbagai aspek teknologi digital, seperti Big Data, Pengolahan Data, Cloud Computing dan Teknologi Mobile. 
        // 7. Beberapa universitas di Indonesia yang menawarkan kursus dan program studi Ilmu Digital Bisnis termasuk Universitas Indonesia, Universitas Bina Nusantara, Universitas Multimedia Nusantara, dan Universitas Gunadarma.";



        $data = [
            'narasi' => $narasi,
            // 'pertanyaan' => $pertanyaan,
            // 'jawaban' => $jawaban,
            // 'similarity' => $similarity 
        ];

        $dataAll['topic'] = $request->topic;
        $dataAll['aspect'] = $request->aspect;
        $dataAll['naration'] = $narasi;
        $dataAll['question'] = $pertanyaan;
        $dataAll['key_answer'] = $jawaban;
        $dataAll['user_id'] = auth()->user()->id;
        
        //dd($data);
        
        Generator::create($dataAll); //$request->all()

        // $data = explode("\n", $pertanyaan);

        return View::make('generators.create')
            ->with('listPertanyaan', $listPertanyaan)
            ->with('data', $data);
    }

    public function cekAnswer(Request $request){
        // dd($request);
        $data_generators = Generator::where('question', 'like', "%$request->pertanyaan1%")->get();

        $data_key_answer = explode("\n", $data_generators[0]->key_answer);

        // dd($data_generators);
        // dd($data_key_answer);
        $text1 = "This is the first text.";
        $text2 = "This is the first text.";


        $questionNum = 1;
        $submitName = "submit" . $questionNum;
        $answerName = "answer" . $questionNum;

        // dd($data_key_answer[$questionNum - 1]);

        while (isset($request->$submitName)) {
            $userAnswer = $request->$answerName;
            $correctAnswer = $data_key_answer[$questionNum - 1];

            // Tokenize the texts into arrays of words or tokens
            $tokenizer = new WhitespaceTokenizer();
            $tokens1 = $tokenizer->tokenize($userAnswer);
            $tokens2 = $tokenizer->tokenize($correctAnswer);

            // Create an instance of the CosineSimilarity class
            $cosineSimilarity = new CosineSimilarity();

            // Calculate the similarity between the two tokenized texts
            $similarity = $cosineSimilarity->similarity($tokens1, $tokens2);
    
            if ($similarity >= 0.80) {
                // Move to the next question
                $questionNum++;
                $submitName = "submit" . $questionNum;
                $answerName = "answer" . $questionNum;

                if ($questionNum <= 5) {
                    return redirect()->back()->with('questionNum', $questionNum);
                } else {
                    return "Congratulations! You have answered all the questions correctly.";
                }
    
                // if ($questionNum <= 5) {
                //     echo "<script>showQuestion($questionNum);</script>";
                // } else {
                //     echo "Congratulations! You have answered all the questions correctly.";
                //     break;
                // }
            } else {
                return "Incorrect answer. Please try again.";
            }
        }

        
    }

    public function getDataAnswer(Request $request, $jawaban, $pertanyaan)
    {
        
        // dd($pertanyaan);
        $data_generators = Generator::where('question', 'like', "%$pertanyaan%")->get();

        $data_question = explode("\n", $data_generators[0]->question);
        $data_key_answer = explode("\n", $data_generators[0]->key_answer);

        $qst = array_values(array_filter(array_map('trim', $data_question)));
        $key_answer = array_values(array_filter(array_map('trim', $data_key_answer)));

        $keyIndexPertanyaan = array_search(trim($pertanyaan.'?'), array_map('trim', $qst));
        
        // print_r(array_map('trim', $data_question));
        // print_r($pertanyaan."<br>");
        // print_r($data_generators[0]->key_answer);
        // print_r($keyIndexPertanyaan."<br>");
        // print_r($jawaban."<br>");
        // print_r($key_answer[$keyIndexPertanyaan]."<br>");
        // dd(array_search($pertanyaan.'?', array_map('trim', $data_question)));
        // dd($data_key_answer[$keyIndexPertanyaan]);

        // Tokenize the texts into arrays of words or tokens
        $tokenizer = new WhitespaceTokenizer();
        $tokens1 = $tokenizer->tokenize($jawaban);
        $tokens2 = $tokenizer->tokenize($key_answer[$keyIndexPertanyaan]); //corect answer

        // print_r($tokens1);
        // print_r($tokens2);exit;

        // Create an instance of the CosineSimilarity class
        $cosineSimilarity = new CosineSimilarity();

        // Calculate the similarity between the two tokenized texts
        $similarity = $cosineSimilarity->similarity($tokens1, $tokens2);

        if($similarity){
            $student = new Student;
            $student->question_id = $data_generators[0]->id;
            $student->answer = $jawaban;
            $student->user_id = auth()->user()->id;
            $student->score = round($similarity*100);
            $student->question = $pertanyaan.'?';
            $student->save();
        }

        // Retrieve data from the controller or perform any other desired actions
        $data = ['message' => $similarity];
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
