<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Unit Converter</title>

  <!-- Bootstrap Core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom Fonts -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
  <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link href="css/stylish-portfolio.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Header -->
  <header class="masthead d-flex">
    <div class="container text-center my-auto">
      <h1 class="mb-1">Unit Converter</h1>
      <h3 class="mb-5">
        <em>From Miles to Kilometers and Kilometers to Miles</em>
      </h3>
      <a class="btn btn-primary btn-xl js-scroll-trigger" href="#unit">Convert</a>
    </div>
    <div class="overlay"></div>
  </header>

  <!-- About -->
  <section class="content-section bg-light" id="unit">
    <div class="container text-center">
      <div class="row">
        <div class="col-lg-10 mx-auto">
           <form class="form-horizontal" action="unit.php" method="POST">
                <div class="form-group">
                    <label for="unit">Unit</label>
                    <input type="text" id="unit" name="unit" class="form-control" required autofocus>
                </div>

                <div class="form-group"> 
                    <div class="checkbox-inline">
                        <label for="miles">Miles to Kilometers</label>
                        <input type="radio" name="conversion" id="miles" value="miles">
                     </div>

                     <div class="checkbox-inline">
                        <label for="kilometers">Kilometers to Miles</label>
                        <input type="radio" name="conversion" id="kilometers" value="kilometers">
                     </div>
                 </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-primary">
                </div>
            </form>
        </div>
      </div>
    </div>
  </section>


  <!-- Footer -->
  <footer class="footer text-center">
    <div class="container">
      <p class="m-0 text-center text-black small">Copyright &copy Summer Poissonnier 2020 - Theme by <a href="http://startbootstrap.com">Start Bootstrap</a>
    </div>
  </footer>

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded js-scroll-trigger" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Plugin JavaScript -->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for this template -->
  <script src="js/stylish-portfolio.min.js"></script>

</body>

</html>
