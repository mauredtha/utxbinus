
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
                    <div class="form-group">
                    <label class="col-md-12">Silakan mempelajari tentang topik yang Anda pilih 
dengan cara ketikkan pada kolom inputan dibawah ini</label>
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
            @else
            Data is not available
            @endif 
            </div>
            <!-- ============================================================== -->
            <!-- Pro Demo -->
            <!-- ============================================================== -->
            
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

</script>
@endif
@endsection
