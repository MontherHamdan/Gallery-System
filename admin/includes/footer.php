  <!-- /#wrapper -->

  <!-- jQuery -->
  <script src="js/jquery.js"></script>

  <!-- Bootstrap Core JavaScript -->
  <script src="js/bootstrap.min.js"></script>

  <!-- summernote JavaScript -->
  <script src="js/summernote.min.js"></script>

  <!-- dropzone js -->
  <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>


  <!-- custome javascript file -->
  <script src="js/scripts.js"></script>

  <!-- google chart script -->
  <script type="text/javascript">
    google.charts.load('current', {
      'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

      var data = google.visualization.arrayToDataTable([
        ['Task', 'Hours per Day'],
        ['Views', <?php echo $session->count; ?>],
        ['Users', <?php echo User::count_all(); ?>],
        ['Photo', <?php echo Photo::count_all(); ?>],
        ['Comment', <?php echo Comment::count_all(); ?>]
      ]);

      var options = {
        // legend: 'none',
        pieSliceText: 'label',
        title: 'My Daily Activities',
        slices: {
          0: {
            color: '#337AB7'
          },
          1: {
            color: '#F0AD4E'
          },
          2: {
            color: '#5CB85C'
          },
          3: {
            color: '#D9534F'
          }
        },
        backgroundColor: 'transparent'
      };

      var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));

      chart.draw(data, options);
    }
  </script>

  </body>

  </html>