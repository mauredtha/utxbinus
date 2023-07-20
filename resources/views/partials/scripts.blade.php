<!--   Core JS Files   -->
<script src="/assets/js/core/popper.min.js"></script>
  <script src="/assets/js/core/bootstrap.min.js"></script>
  <script src="/assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="/assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="/assets/js/plugins/chartjs.min.js"></script>
  <script>

    // Sample data for the bar chart
    // var data = {
    //         labels: ['January', 'February', 'March', 'April', 'May'],
    //         datasets: [{
    //             label: 'Sales',
    //             data: [120, 150, 200, 180, 250],
    //             backgroundColor: 'rgba(54, 162, 235, 0.5)'
    //         }]
    //     };

    //     // Configuration options for the bar chart
    //     var options = {
    //         responsive: true,
    //         scales: {
    //             y: {
    //                 beginAtZero: true
    //             }
    //         }
    //     };

    //     // Create a new bar chart
    //     var ctx = document.getElementById('barChart').getContext('2d');
    //     var barChart = new Chart(ctx, {
    //         type: 'bar',
    //         data: data,
    //         options: options
    //     });
    
  </script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="/assets/js/soft-ui-dashboard.min.js?v=1.0.7"></script>