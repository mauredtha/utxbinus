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
                                        <a href="{{ route('users.create') }}" class="btn btn-primary text-white"
                                            target="_self">Add User</a>
                                    </div>
                                </div>
                            </div>
                            <!-- title -->
                            <div class="table-responsive">
                                <table class="table mb-0 table-hover align-middle text-nowrap">
                                    <thead>
                                        <tr>
                                            <th class="border-top-0">No</th>
                                            <th class="border-top-0">Name</th>
                                            <th class="border-top-0">Email</th>
                                            <th class="border-top-0">Role</th>
                                            <th class="border-top-0" colspan="3">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(count($users) > 0) { ?>
                                        <?php
                                            $i = $users->firstItem();
                                        ?>
                                        @foreach ($users as $key => $value)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{$value->name}}</td>
                                            <td>{{$value->username}}</td>
                                            <td>{{$value->email}}</td>
                                            <td>{{$value->role}}</td>
                                            <td>{{$value->status}}</td>
                                            <td>
    
                                                <!-- <a class="btn btn-info text-white" href="{{ route('users.show',$value->id) }}">Show</a> -->

                                                <a class="btn btn-primary text-white" href="{{ route('users.edit',$value->id) }}">Edit</a>

                                            </td>
                                        </tr>
                                        @endforeach
                                        <?php } else { ?>
                                        <tr>
                                            <td colspan="7"><p align="center">Belum Ada Data, Silakan Melakukan Penambahan Data</p></td>
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
        {{ $users->links() }}
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
