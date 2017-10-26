<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>@yield('title')</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
	<link href="https://fonts.googleapis.com/css?family=Merriweather:300,400,700" rel="stylesheet">
	<link rel="stylesheet" href="/css/admin/admin.css">
</head>
<body>
	<header>
		<div class="container">
			<h1 class="main-logo">
				<a href="{{ url(config('admin.url')) }}">
					{{ setting('app_name') }}
				</a>
			</h1>
		</div>
		@if (auth()->guard('admin')->check())
		<nav class="navbar navbar-default">
			<div class="container">
				<div class="wrapper">
				    <div class="navbar-header">
				    	<span class="menu">Menu</span>
			            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#my-navigation" aria-expanded="false">
			                <span class="sr-only">
			                    Toggle navigation
			                </span>
			                <span class="icon-bar">
			                </span>
			                <span class="icon-bar">
			                </span>
			                <span class="icon-bar">
			                </span>
			            </button>
			        </div>

			        
			        <!-- Collect the nav links, forms, and other content for toggling -->
			        <div class="collapse navbar-collapse" id="my-navigation">
			            <ul class="nav navbar-nav navbar-left">
					        <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
					        <li><a href="{{ route('admin.admins.index') }}">Admins</a></li>
			               	<li><a href="{{ route('admin.users.index') }}">Users</a></li>
					        <li><a href="{{ route('admin.roles.index') }}">Roles</a></li>
					        <li><a href="{{ route('admin.settings.get') }}">Settings</a></li>
			            </ul>
			            <ul class="nav navbar-nav navbar-right">
			            	<li><a href="{{ route('admin.profile') }}">Profile</a></li>
					        <li>
					        	<form action="{{ route('admin.logout') }}" method="POST" class="logout-form">
									{{ csrf_field() }}
									<button type="submit" class="link">Logout</button>
								</form>
							</li>
			            </ul>
			        </div>
			        
				</div>
		        <!-- /.navbar-collapse -->
		    </div>
		    <!-- /.container-fluid -->
		</nav>
		@endif
	</header>
	
	
	<div class="container">
		<div class="main-wrapper @if (!auth()->guard('admin')->check()) margin-top-5 @endif">
			@if (auth()->guard('admin')->check())
			<h2 class="title-header">@yield('title')</h2>
			@endif
			@yield('content')
		</div>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script>
		jQuery(document).ready(function(){
		   $('.prevent-submission').submit(function(e){
		      e.preventDefault();
		   });
		   $('.prevent-submission').find('.form-control').attr('disabled', 'disabled');
		});
	</script>
</body>
</html>