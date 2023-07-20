@extends('layouts.template')

@section('content')

@if(auth()->user()->role == 'MAHASISWA')
<div class="container-fluid py-4">
  <div class="row">
      <div class="panel-heading">
        <p>Selamat Datang {{auth()->user()->name}}</p>
      </div>
  </div>
</div>
@else

<div class="container-fluid py-4">
      <div class="row">
        <div class="panel-heading">
            Pilih Periode Bulan :
            <select class="form-select shadow-none form-control-line" style="width: 200px;" id="month" name="month" onchange="changeMonth(this.value);">
                @foreach($months as $key => $month)
                    <option value="{{$key}}">{{$month}}</option>
                @endforeach
            </select>
        </div>
      </div>

      
      <div class="row mt-4">
        <div class="col-lg-6">
          <div class="card z-index-2">
            <div class="card-header pb-0">
              <h6>Periode Bulan</h6>
            </div>
            <div class="card-body p-3">
              <div class="chart">
                <canvas id="barChart"></canvas>
                
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 mb-lg-0 mb-4">
          <div class="card z-index-2">
            <div class="card-body p-3">
            <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">NIM- Nama</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Frekuensi</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Lulus</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tidak Lulus</th>
                    </tr>
                  </thead>
                  <tbody id="data-table-body">
                  <?php if(count($frekuensi) > 0) { ?>
                  
                  <?php } else { ?>
                    <tr>
                      <td colspan="4"><p align="center">Belum Ada Data</p></td>
                    </tr>
                  <?php } ?>
                  </tbody>
                </table>
            </div>
          </div>
        </div>
      </div>


      
      <div class="row my-4">
        <div class="col-lg-15 col-md-15 mb-md-0 mb-4">
          <div class="card">
            <div class="card-header pb-0">
              <div class="row">
                <div class="col-lg-6 col-7">
                  <h6>Daftar Topik & Aspek</h6>
                  
                </div>
                
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Topik</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Aspek</th>
                    </tr>
                  </thead>
                  <tbody id="data-table-topik">
                  <?php if(count($topic_aspect) > 0) { ?>
                  
                  <?php } else { ?>
                    <tr>
                      <td colspan="4"><p align="center">Belum Ada Data</p></td>
                    </tr>
                  <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        
      </div>
      

      <!-- siswa lulus & tidak lulus -->
      <div class="row my-4">
        <div class="col-lg-6 col-md-6 mb-md-0 mb-4">
          <div class="card">
            <div class="card-header pb-0">
              <div class="row">
                <div class="col-lg-6 col-7">
                  <h6>Daftar Siswa Lulus</h6>
                </div>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Topik</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Aspek</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">NIM - Nama</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nilai</th>
                    </tr>
                  </thead>
                  <tbody id="data-table-lulus">
                  <?php if(count($siswa_lulus) > 0) { ?>
                  
                  <?php } else { ?>
                    <tr>
                      <td colspan="4"><p align="center">Belum Ada Data</p></td>
                    </tr>
                  <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        

        <div class="col-lg-6 col-md-6 mb-md-0 mb-4">
          <div class="card">
            <div class="card-header pb-0">
              <div class="row">
                <div class="col-lg-10 col-7">
                  <h6>Daftar Siswa Tidak Lulus</h6>
                </div>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Topik</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Aspek</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">NIM - Nama</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nilai</th>
                    </tr>
                  </thead>
                  <tbody id="data-table-tdklulus">
                  <?php if(count($siswa_tidak_lulus) > 0) { ?>
                  
                  <?php } else { ?>
                    <tr>
                      <td colspan="4"><p align="center">Belum Ada Data</p></td>
                    </tr>
                  <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>


@endsection
@section('scripts')
<script>
  var barChart;

  function changeMonth(month) {
    // Make an AJAX request to the controller endpoint
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'getData?periode=' + month, true);
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        var response = JSON.parse(xhr.responseText);
        // Update the data on the page
        updateDataFrekuensi(response);
        updateDataTopik(response);
        updateDataLulus(response);
        updateDataTdkLulus(response);
        updateBarChart(response.diagram);
        // console.log(response)
      }
    };
    xhr.send();
  }

  function updateDataFrekuensi(data) {
    var tableBody = document.getElementById('data-table-body');
    tableBody.innerHTML = ''; // Clear the existing table data

    if (data.frekuensi.length > 0) {
      data.frekuensi.forEach(function (item) {
        var row = document.createElement('tr');
        var nameCell = document.createElement('td');
        nameCell.textContent = item.users_name;
        row.appendChild(nameCell);

        var generatedCell = document.createElement('td');
        generatedCell.textContent = item.generated;
        row.appendChild(generatedCell);

        var lulusCell = document.createElement('td');
        lulusCell.textContent = item.lulus;
        row.appendChild(lulusCell);

        var tdkLulusCell = document.createElement('td');
        tdkLulusCell.textContent = item.tdk_lulus;
        row.appendChild(tdkLulusCell);

        tableBody.appendChild(row);
      });
    } else {
      var row = document.createElement('tr');
      var emptyCell = document.createElement('td');
      emptyCell.setAttribute('colspan', '4');
      emptyCell.textContent = 'Belum Ada Data';
      row.appendChild(emptyCell);
      tableBody.appendChild(row);
    }
  }

  function updateDataTopik(data) {
    
    var tableBody = document.getElementById('data-table-topik');
    tableBody.innerHTML = ''; // Clear the existing table data

    if (data.topic_aspect.data.length > 0) {
      data.topic_aspect.data.forEach(function (item) {
        console.log(item.topic)
        var row = document.createElement('tr');
        var topikCell = document.createElement('td');
        topikCell.textContent = item.topic;
        row.appendChild(topikCell);

        var aspectCell = document.createElement('td');
        aspectCell.textContent = item.aspect;
        row.appendChild(aspectCell);

        tableBody.appendChild(row);
      });
    } else {
      var row = document.createElement('tr');
      var emptyCell = document.createElement('td');
      emptyCell.setAttribute('colspan', '4');
      emptyCell.textContent = 'Belum Ada Data';
      row.appendChild(emptyCell);
      tableBody.appendChild(row);
    }
  }

  function updateDataLulus(data) {
    var tableBody = document.getElementById('data-table-lulus');
    tableBody.innerHTML = ''; // Clear the existing table data

    if (data.siswa_lulus.data.length > 0) {
      data.siswa_lulus.data.forEach(function (item) {
        var row = document.createElement('tr');
        var topikCell = document.createElement('td');
        topikCell.textContent = item.topic;
        row.appendChild(topikCell);

        var aspectCell = document.createElement('td');
        aspectCell.textContent = item.aspect;
        row.appendChild(aspectCell);

        var namaCell = document.createElement('td');
        namaCell.textContent = item.users_name;
        row.appendChild(namaCell);

        var nilaiCell = document.createElement('td');
        nilaiCell.textContent = item.score;
        row.appendChild(nilaiCell);

        tableBody.appendChild(row);
      });
    } else {
      var row = document.createElement('tr');
      var emptyCell = document.createElement('td');
      emptyCell.setAttribute('colspan', '4');
      emptyCell.textContent = 'Belum Ada Data';
      row.appendChild(emptyCell);
      tableBody.appendChild(row);
    }
  }

  function updateDataTdkLulus(data) {
    var tableBody = document.getElementById('data-table-tdklulus');
    tableBody.innerHTML = ''; // Clear the existing table data

    if (data.siswa_tidak_lulus.data.length > 0) {
      data.siswa_tidak_lulus.data.forEach(function (item) {
        var row = document.createElement('tr');
        var topikCell = document.createElement('td');
        topikCell.textContent = item.topic;
        row.appendChild(topikCell);

        var aspectCell = document.createElement('td');
        aspectCell.textContent = item.aspect;
        row.appendChild(aspectCell);

        var namaCell = document.createElement('td');
        namaCell.textContent = item.users_name;
        row.appendChild(namaCell);

        var nilaiCell = document.createElement('td');
        nilaiCell.textContent = item.score;
        row.appendChild(nilaiCell);

        tableBody.appendChild(row);
      });
    } else {
      var row = document.createElement('tr');
      var emptyCell = document.createElement('td');
      emptyCell.setAttribute('colspan', '4');
      emptyCell.textContent = 'Belum Ada Data';
      row.appendChild(emptyCell);
      tableBody.appendChild(row);
    }
  }
    // function changeMonth(month){
        
    //     // Make an AJAX request to the controller endpoint
    //     var xhr = new XMLHttpRequest();
    //     xhr.open('GET', 'dashboards?periode=' + month, true);
    //     xhr.onreadystatechange = function() {
    //       if (xhr.readyState === 4 && xhr.status === 200) {
            
    //         var response = JSON.parse(xhr.responseText);
    //         // // Handle the response data
    //         console.log(response);
    //       }
    //     };
    //     xhr.send();
    // }

    // Function to update the bar chart
  function updateBarChart(diagramData) {
    // Extract the labels and data values from the diagram data
    var labels = diagramData.map(function(item) {
      return item.status;
    });
    var data = diagramData.map(function(item) {
      return item.jml;
    });

    // Update the bar chart using Chart.js
    barChart.data.labels = labels;
    barChart.data.datasets[0].data = data;
    barChart.update();
  }



  // Initial page load
window.onload = function() {
  var ctx = document.getElementById('barChart').getContext('2d');
  barChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: [],
      datasets: [{
        label: 'Student Status',
        data: [],
        backgroundColor: 'rgba(75, 192, 192, 0.2)',
        borderColor: 'rgba(75, 192, 192, 1)',
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
          precision: 0
        }
      }
    }
  });
};

  
</script>
@endif
@endsection
