<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width; initial-scale=1; maximum-scale=1; minimum-scale=1; user-scalable=no;" />
    <title>ULTRA POS</title>
	
	<!-- CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/app.css">


	<!-- JS -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/app.js"></script>
</head>
<body class="loading">
    <div class="login-container">
        <div class="login-cover">
            <img src="https://images.pexels.com/photos/935756/pexels-photo-935756.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940" alt="" class="bg">
            <div class="login-intro">
                <h2>ULTRAPOS</h2>
                <br/><br/><br/>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Hic eum voluptates est veritatis quae alias, natus sapiente, cumque blanditiis magni dolor laboriosam at doloribus praesentium, iure molestias nesciunt perspiciatis magnam.
                </p>
                <ul>
                    <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                    <li><a href="#"><i class="fa fa-youtube"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="login-form">
            <form class="form form-login" method="POST" action="<?php echo base_url();?>owner/home/login">
                <h2>Owner Sign In</h2>
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="text" name="email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Password</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="form-group">
                    <div class="checkbox">
                        <label><input type="checkbox"> Remember Me</label>
                    </div>
                </div>
                <br/>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">LOGIN</button>
                    <a href="register.html" class="btn btn-default">REGISTER</a>
                </div>
            </form>  
        </div>
    </div>
</body>
</html>