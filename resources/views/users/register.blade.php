@extends('layouts.sign')

@section('content')
<section>
      <div class="page-header min-vh-75">
        <div class="container">
          <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
              <div class="card card-plain mt-8">
                <div class="card-header pb-0 text-left bg-transparent">
                  <h3 class="font-weight-bolder text-info text-gradient">Register Your Account</h3>
                 
                </div>
                <div class="card-body">
                @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                            </button>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                    @endif
                    @if (Session::has('error'))
                        <div class="alert alert-danger">
                            {{ Session::get('error') }}
                        </div>
                    @endif
                
                    <form class="form-horizontal form-material mx-2" action="{{ route('register') }}" method="POST">
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
                                <button class="btn btn-custom btn-info btn-lg">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                  <p class="mb-4 text-sm mx-auto">
                  Already have an account?
                    <a href="{{route('login')}}" class="text-info text-gradient font-weight-bold">Sign in</a>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
                <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6" style="background-image:url('/assets/img/curved-images/curved6.jpg')"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
@endsection