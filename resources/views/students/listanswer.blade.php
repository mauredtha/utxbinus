@extends('layouts.template')

@section('content')
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Table -->
        <!-- ============================================================== -->
        <div class="row">
            <!-- column -->
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form class="row">
                            <!-- title -->
                            <div class="d-md-flex">
                                
                                <div class="col">
                                    <input class="form-control" type="text" name="q" value="{{ $q }}" placeholder="Search name..." />
                                </div>
                                <div class="col">
                                    <button class="btn btn-success">Search</button>
                                </div>
                            </div>
                            <!-- title -->
                            <div class="table-responsive">
                                <table class="table mb-0 table-hover align-middle text-nowrap">
                                    <thead>
                                        <tr>
                                            <th class="border-top-0">No</th>
                                            <th class="border-top-0">NIM</th>
                                            <th class="border-top-0">Nama</th>
                                            <th class="border-top-0">Topik</th>
                                            <th class="border-top-0">Aspek</th>
                                            <th class="border-top-0">Pertanyaan</th>
                                            <th class="border-top-0">Jawaban Siswa</th>
                                            <th class="border-top-0">Nilai</th>
                                            <th class="border-top-0">Status</th>
                                            <th class="border-top-0" colspan="3">Berikan Komentar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(count($students) > 0) { ?>
                                        <?php
                                            $i = $students->firstItem();
                                        ?>
                                        @foreach ($students as $key => $value)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{$value->user_id}}</td>
                                            <td>{{$value->users_name}}</td>
                                            <td style="width: 200px;word-break: break-all;white-space: normal;">{{$value->topic}}</td>
                                            <td style="width: 200px;word-break: break-all;white-space: normal;">{{$value->aspect}}</td>
                                            <td style="width: 200px;word-break: break-all;white-space: normal;">{{$value->question}}</td>
                                            <td style="width: 200px;word-break: break-all;white-space: normal;">{{$value->answer}}</td>
                                            <td>{{$value->score}}</td>
                                            <?php if($value->score < 80) { $status = 'TIDAK LULUS'; }else { $status = 'LULUS';} ?>
                                            <td>{{$status}}</td>
                                            <td>
                                            @if(isset($value->comment))
                                                {{$value->comment}}
                                            @else
                                            <form action="{{ route('listAnswer') }}" method="POST">
                                            @csrf
                                                <input type="hidden" value="{{$value->id}}" id="id_answer{{$key}}">
                                                <textarea type="text" class="form-control form-control-line" name="comment{{$key}}" id="comment{{$key}}" placeholder="Berikan Komentar"></textarea>
                                                <button class="btn bg-gradient-primary mt-3 w-60" type="submit">Submit</button>
                                            <!--  </form>
                                                <a class="btn btn-info text-white" href="{{ route('generators.show',$value->id) }}">Show</a> 

                                                <a class="btn btn-primary text-white" href="{{ route('students.create','id='.$value->id) }}">Jawab</a>-->

                                            @endif
                                            
                                                
                                            </td>
                                        </tr>
                                        @endforeach
                                        <?php } else { ?>
                                        <tr>
                                            <td colspan="10"><p align="center">Belum Ada Data</p></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        

        {{ $students->links() }}
        <!-- ============================================================== -->
        <!-- Table -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Page wrapper  -->
<!-- ============================================================== -->

@endsection
@section('scripts')
<script>
    function sendData(questionNum){

        alert(21);
        var comment = document.getElementById("comment" + (questionNum)).value;
        var id = document.getElementById("id_answer" + (questionNum)).value;


        // var data = {
        //     id: id,
        //     comment: comment
        // };
        // // Make an AJAX request to the controller route
        // var xhr = new XMLHttpRequest();
        // xhr.open('POST', '{{ route('students.store') }}', true);
        // xhr.setRequestHeader('Content-Type', 'application/json');
        // xhr.onreadystatechange = function() {
        //     alert(xhr.readyState);
        //     alert(xhr.status);
        //     if (xhr.readyState === 4 && xhr.status === 200) {
        //         alert(1);
        //         var response = JSON.parse(xhr.responseText);
        //         // Handle the response data
        //         console.log(response);
        //     }
        // };
        // xhr.send(JSON.stringify(data));
    }
</script>
@endsection
