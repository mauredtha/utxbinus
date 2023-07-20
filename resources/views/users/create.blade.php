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
        <div class="col-12">
            <div class="card">
                <div class="card-body">
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
                    <form class="form-horizontal form-material mx-2" action="{{ route('users.store') }}" method="POST">
                    @csrf
                        <div class="form-group">
                            <label class="col-md-12">Name</label>
                            <div class="col-md-12">
                                <input type="text"
                                    class="form-control form-control-line" name="name" id="name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-md-12">Email</label>
                            <div class="col-md-12">
                                <input type="email"
                                    class="form-control form-control-line" name="email"
                                    id="email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Password</label>
                            <div class="col-md-12">
                                <input type="password"
                                    class="form-control form-control-line" name="password" id="password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Re-Password</label>
                            <div class="col-md-12">
                                <input type="password" 
                                    class="form-control form-control-line" name="password_confirmation" id="password_confirmation">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Role</label>
                            <div class="col-md-12">
                                <select class="form-select shadow-none form-control-line" name="role" id="role">
                                    <option value="">Select Role</option>
                                    @foreach ($roles as $key => $value)
                                    <option value="{{$value}}">{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <button class="btn bg-gradient-primary mt-3 w-15">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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
