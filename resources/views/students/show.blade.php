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
                    
                        <div class="form-group">
                            <label class="col-md-12">Topik</label>
                            <div class="col-md-12">
                                <input id="topic" name="topic" type="text" readonly="readonly"
                                    class="form-control form-control-line" value="{{$student->topic}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12">Aspect</label>
                            <div class="col-md-12">
                                <input id="aspect" name="aspect" type="text" readonly="readonly"
                                    class="form-control form-control-line" value="{{$student->aspect}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12">Question</label>
                            <div class="col-md-12">
                                <textarea class="form-control form-control-line" name="question" id="question" rows="5" value="{{$student->question}}" readonly="readonly">{{$student->question}}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12">Your Answer</label>
                            <div class="col-md-12">
                                <textarea class="form-control form-control-line" name="answer" id="answer" rows="5" value="{{$student->answer}}" readonly="readonly">{{$student->answer}}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12">Score</label>
                            <div class="col-md-12">
                                <input id="score" name="score" type="text" readonly="readonly"
                                    class="form-control form-control-line" value="{{$student->score}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12">Status</label>
                            <div class="col-md-12">
                                <?php if($student->score >= 80) { $status = "LULUS"; $style="";} else { $status = "TIDAK LULUS"; $style="color:red;";} ?>
                                <input id="status" name="status" type="text" readonly="readonly" style="{{$style}}"
                                    class="form-control form-control-line" value="{{$status}}">
                            </div>
                        </div>
        
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