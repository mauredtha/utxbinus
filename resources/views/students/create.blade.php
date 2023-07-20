
@extends('layouts.template')

@section('content')
<div class="content-wrapper">
<!-- ============================================================== -->
<!-- Demos part -->
<!-- ============================================================== -->
<section class="spacer bg-light">
    <div class="container">
        
        <div class="row py-5">
            <!-- ============================================================== -->
            <!-- Lite Demo -->
            <!-- ============================================================== -->
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
                    <form class="form-horizontal form-material mx-2" action="{{ route('students.store') }}" method="POST">
                    @csrf
                    
                        <input type="hidden" value="{{$id}}" name="question_id" id="question_id">
                        @foreach ($question as $key => $value)
                        <div class="form-group">
                            <label class="col-md-12">{{$value}}</label>
                            <div class="col-md-12">
                                <textarea type="text"
                                    class="form-control form-control-line" name="answer_{{$key}}" id="answer_{{$key}}"></textarea>
                            </div>
                        </div>
                        @endforeach

                        
                        
                        
                        <div class="form-group">
                            <div class="col-sm-12">
                                <button class="btn bg-gradient-primary mt-3 w-25">Submit</button>
                            </div>
                        </div>
                    </form>
                

            </div>

            <!-- ============================================================== -->
            <!-- Pro Demo -->
            <!-- ============================================================== -->
            
        </div>
    </div>
</section>

</div>
@endsection

