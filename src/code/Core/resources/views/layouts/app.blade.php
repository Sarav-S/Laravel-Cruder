
<!DOCTYPE html>
<html>
<head>
	<title>@yield('title')</title>
  <!-- Mobirise Free Bootstrap Template, https://mobirise.com -->
  <meta name="robots" content="noindex" />
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  
</head>
<body class="@yield('body-class')">
    @yield('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</body>
</html>