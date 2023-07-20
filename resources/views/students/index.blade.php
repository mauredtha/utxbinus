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
                                            <th class="border-top-0">Commentar</th>
                                            <th class="border-top-0" colspan="3">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(count($generators) > 0) { ?>
                                        <?php
                                            $i = $generators->firstItem();
                                        ?>
                                        @foreach ($generators as $key => $value)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{$value->user_id}}</td>
                                            <td>{{$value->users_name}}</td>
                                            <td style="width: 200px;word-break: break-all;white-space: normal;">{{$value->topic}}</td>
                                            <td style="width: 200px;word-break: break-all;white-space: normal;">{{$value->aspect}}</td>
                                            <td style="width: 200px;word-break: break-all;white-space: normal;">{{$value->question}}</td>
                                            <td style="width: 200px;word-break: break-all;white-space: normal;">{{$value->answer}}</td>
                                            <td>{{$value->score}}</td>
                                            <?php if($value->score < 80) { $status = 'TIDAK LULUS'; $style="color:red;"; }else { $status = 'LULUS'; $style="";} ?>
                                            <td style="{{$style}}">{{$status}}</td>
                                            <td style="width: 200px;word-break: break-all;white-space: normal;">{{$value->comment}}</td>
                                            <td>
    
                                                <a class="btn btn-primary text-white" href="{{ route('students.show',$value->id) }}">Show</a>

                                                <!-- <a class="btn btn-primary text-white" href="{{ route('students.create','id='.$value->id) }}">Jawab</a> -->

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
        {{ $generators->links() }}
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
