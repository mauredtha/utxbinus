
@extends('layouts.template')

@section('content')
<div class="content-wrapper">
<!-- ============================================================== -->
<!-- Demos part -->
<!-- ============================================================== -->
<section class="spacer bg-light">
    <div class="container">
        
        <div class="row py-5">
            
            <div class="col-md-6">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="form-group">
                    <label class="col-md-12">Silakan mempelajari tentang topik yang Anda pilih dengan cara ketikkan pada kolom inputan dibawah ini</label>
                </div>
                    
                <form class="form-horizontal form-material mx-2" action="{{ route('generators.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="col-md-12">Topik</label>
                        <div class="col-md-12">
                            <textarea type="text"
                                class="form-control form-control-line" name="topic" id="topic" placeholder="Materi yang akan dipelajari"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-md-12">Aspek</label>
                        <div class="col-md-12">
                            <textarea type="email"
                                class="form-control form-control-line" name="aspect"
                                id="aspect" placeholder="Bagian khusus dari topik"></textarea>
                        </div>
                    </div>
                        
                    <div class="form-group">
                        <div class="col-sm-12">
                            <button class="btn bg-gradient-primary mt-3 w-25">Submit</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-md-6">
            
                @if(isset($data))
                    <div id="loader" style="position: fixed;  z-index:9999; width:50%; height: 50%; background: url('http://code.jquery.com/mobile/1.3.1/images/ajax-loader.gif') no-repeat center center rgba(0,0,0,0.25)"></div>
                    <div class="form-group" id="result">
                
                    </div>

                    <div class="form-group" id="listquestion">
                        <form method="POST" action="{{route('cekAnswer')}}">
                        @csrf
                        @php
                        $questionNum = session('questionNum', 1);
                        @endphp

                        @for ($i = 1; $i <= 5; $i++)
                            <div id="question{{ $i }}" style="display:none;" @if($i != $questionNum) style="display:none;" @endif>
                                <p>Question {{$listPertanyaan[$i-1]}}</p>
                                <input type="hidden" value="{{$listPertanyaan[$i-1]}}" name="pertanyaan{{ $i }}" id="pertanyaan{{ $i }}">
                                <textarea type="text"
                                class="form-control form-control-line" name="answer{{ $i }}" id="answer{{ $i }}"></textarea>
                                <label id="similarity{{ $i }}"></label>
                                <button class="btn bg-gradient-primary mt-3 w-25" name="submit{{ $i }}" id="submit{{ $i }}" onclick="showQuestion({{$i}})">Submit</button>
                                
                            </div>
                                <!-- Repeat the above structure for question 2 to 5 -->
                        @endfor
                        <!--<button class="btn bg-gradient-primary mt-3 w-25">Submit</button> -->
                        </form>
                    </div>
                @else
                    Data is not available
                @endif
                
                
            </div>
            
        </div>
    </div>
</section>

</div>
@endsection
@section('scripts')
@if(isset($data))
<script>

    document.onreadystatechange = function () {
        var state = document.readyState
        if (state == 'complete') {
            document.getElementById('interactive');    
            document.getElementById('loader').style.visibility="hidden";
        }
    }

    var data = @json($data);
    var dataArray = Object.values(data);
    var totalItems = dataArray.length;
    var processedItems = 0;

    // $(document).ready(function(){
    //     processNextItem();
    // });

    function updateResults(item) {
        var childDiv = document.createElement('div');
        childDiv.setAttribute('id', 'childDiv');
        childDiv.textContent = item;
        document.getElementById('result').appendChild(childDiv);

        //deskripsi untuk memulai pertanyaan
        var childBr = document.createElement('br');
        document.getElementById('result').appendChild(childBr);
        var childLabel = document.createElement('label');
        childLabel.textContent = "Untuk memperdalam pemahaman tentang topik diatas, silakan menjawab pertanyaan berikut";
        document.getElementById('result').appendChild(childLabel);
        //add button mulai
        var childBtn = document.createElement('button');
        childBtn.setAttribute('id', 'btnQuestion');
        childBtn.setAttribute('class', 'btn bg-gradient-primary mt-3 w-25');
        childBtn.setAttribute('onclick', 'starQuestion()');
        childBtn.textContent = "Start";
        document.getElementById('result').appendChild(childBtn);
    }

    function processNextItem() {
        if (processedItems < totalItems) {
            var item = dataArray[processedItems];
            updateResults(item);

            processedItems++;

            setTimeout(processNextItem, 500); // Delay between items (e.g., 500ms)
        }
    }

    // Start the process
    processNextItem();

    function starQuestion() {
        document.getElementById('result').style.display = "none";
        document.getElementById('question1').style.display = "block";
    }

    function showQuestion(questionNum) {
        event.preventDefault();

        var btnPrev = document.getElementById("submit" + (questionNum));
       
        var pertanyaan = document.getElementById("pertanyaan" + (questionNum)).value;
        var jawaban = document.getElementById("answer" + (questionNum)).value;

        var xhr = new XMLHttpRequest();
        var route = "{{ route('getAnswer', ['jawaban'=> ':jawaban','pertanyaan' => ':pertanyaan']) }}";
        route = route.replace(':jawaban', jawaban).replace(':pertanyaan', pertanyaan);

        xhr.open('GET', route, true);
        
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                // Handle the response data
                // console.log(response);
                var score = Math.round(response.message*100)
                document.getElementById('similarity'+(questionNum)).textContent = "Your score : "+ score;

                if(score < 80){
                    document.getElementById('result').style.display = "block";
                    document.getElementById('btnQuestion').style.display = "none";
                    
                    btnPrev.style.display = "block";

                    var currentQuestion = document.getElementById("question" + (questionNum+1));
                    
                    // var previousQuestion = document.getElementById("question" + (questionNum - 1));

                    // if (previousQuestion) {
                    //     previousQuestion.style.display = "none";
                    // }
                

                    currentQuestion.style.display = "none";
                }else{
                    document.getElementById('result').style.display = "none";
                    
                    btnPrev.style.display = "none";

                    var currentQuestion = document.getElementById("question" + (questionNum+1));
                    
                    // var previousQuestion = document.getElementById("question" + (questionNum - 1));

                    // if (previousQuestion) {
                    //     previousQuestion.style.display = "none";
                    // }
                

                    currentQuestion.style.display = "block";
                }
                
            }
        };
        xhr.send();
        
        
    }

</script>
@endif
@endsection
