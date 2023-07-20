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
                                <div class="ms-auto">
                                    <div class="text-end upgrade-btn">
                                        <a href="{{ route('generators.create') }}" class="btn btn-primary text-white"
                                            target="_self">Generate Question</a>
                                    </div>
                                    
                                </div>
                            </div>
                            <!-- title -->
                            <div class="table-responsive">
                                <table class="table mb-0 table-hover align-middle text-nowrap">
                                    <thead>
                                        <tr>
                                            <th class="border-top-0">No</th>
                                            <th class="border-top-0">Topik</th>
                                            <th class="border-top-0">Aspek</th>
                                            <th class="border-top-0">Narasi</th>
                                            <th class="border-top-0">Pertanyaan</th>
                                            <th class="border-top-0">Jawaban</th>
                                            <th class="border-top-0">User</th>
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
                                            <td>{{$value->topic}}</td>
                                            <td>{{$value->aspect}}</td>
                                            <td>{{$value->naration}}</td>
                                            <td>{{$value->question}}</td>
                                            <td>{{$value->key_answer}}</td>
                                            <td>{{$value->user_id}}</td>
                                            <td>{{$value->created_at}}</td>
                                            <td>
    
                                                <!-- <a class="btn btn-info text-white" href="{{ route('generators.show',$value->id) }}">Show</a> -->

                                                <a class="btn btn-primary text-white" href="{{ route('generators.edit',$value->id) }}">Edit</a>

                                            </td>
                                        </tr>
                                        @endforeach
                                        <?php } else { ?>
                                        <tr>
                                            <td colspan="10"><p align="center">Belum Ada Data, Silakan Melakukan Generate Question</p></td>
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
