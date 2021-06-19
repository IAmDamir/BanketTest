<!--A Design by W3layouts 
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->

<?php
    include_once "connectToTheDatabase.php";

    $select_statement = "SELECT 
                                name,
                                picture,
                                content
                        FROM dishes
                        WHERE id = " . $_GET['dish_id'] . ";";
    $dish = $conn->query($select_statement);
    $dish = $dish->fetch_array(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
<title>Kitchen-Master A Hotel Category Flat Bootstrap Responsive Website Template | Single :: w3layouts</title>
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery.min.js"></script>
<!-- Custom Theme files -->
<!--theme-style-->
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />	
<!--//theme-style-->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Kitchen-Master Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!--fonts-->
<link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css'>
<!--//fonts-->
<script type="text/javascript" src="js/move-top.js"></script>
<script type="text/javascript" src="js/easing.js"></script>
				<script type="text/javascript">
					jQuery(document).ready(function($) {
						$(".scroll").click(function(event){		
							event.preventDefault();
							$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
						});
					});
					</script>

</head>
<body>
	<!--header-->
	<div class="header-in">
		<div class="container">	
			<!---->
			<div class="header-logo">
				<div class="logo">
				<a href="index.php"><img src="images/logo.png" alt="" ></a>
				</div>
				<div class="top-nav">
					<span class="menu"> </span>
					<ul>
						<li ><a href="about.html" data-hover="ABOUT">ABOUT  </a> </li>
						<li><a href="404.html" data-hover="CLASSES" > CLASSES</a></li>
						<li><a href="gallery.php" data-hover="GALLERY">GALLERY </a></li>
						<li><a href="contact.php" data-hover="CONTACT">CONTACT </a></li>
					</ul>
					<!--script-->
				<script>
					$("span.menu").click(function(){
						$(".top-nav ul").slideToggle(500, function(){
						});
					});
			</script>				
		</div>
		<div class="clearfix"> </div>
			</div>
			<!---->
				<div class="top-menu">					
					<ul>
						<li ><a href="about.html" data-hover="ABOUT">ABOUT  </a> </li>
						<li><a href="404.html" data-hover="CLASSES" > CLASSES</a></li>
						<li><a href="index.php"><img src="images/logo.png" alt="" ></a></li>
						<li><a href="gallery.php" data-hover="GALLERY">GALLERY </a></li>
						<li><a href="contact.php" data-hover="CONTACT">CONTACT </a></li>
					</ul>
					<!--script-->
							
		</div>
	</div>
</div>
	<div class="single">
			<div class="container">
				
				
				<div class="blog-top-in">
					<div class="col-md-4 top-blog">
						<a href="#"><img class="img-responsive" src="menu/<?php echo $dish['picture']?>" alt=" " ></a>
					</div>
					<div class="col-md-8 sed-in">
						<h4><?php echo $dish['name'];?></h4>
						<p><?php echo $dish['content']?></p>
					</div>
					<div class="clearfix"> </div>
				</div>
				<p class="at-in">Cras consequat iaculis lorem, id vehicula erat mattis quis. Vivamus laoreet velit justo, in ven e natis purus pretium sit amet. Praesent lectus tortor, tincidu nt in consectetur vestibulum, ultrices nec neque. Praesent nec sagittis mauris. Fusce convallis nunc neque. Integer egestas aliquam interdum. Nulla ante diam, interdum nec tempus eu, feugiat vel erat. Integer aliquam mi quis accum san porta.
						Quisque nec turpis nisi. Proin lobortis nisl ut orci euismod, et lobortis est scelerisque. Sed eget volutpat ipsum. </p>						
						
				<ul class="links">
				  		 <li><i class="date"> </i><span class="icon_text">July 14, 2014</span></li>
				  		 <li><a href="#"><i class="admin"> </i><span class="icon_text">Admin</span></a></li>
				  		 <li class="last"><a href="#"><i class="permalink"> </i><span class="icon_text">Permalink</span></a></li>
				    </ul>
		  		    <ul class="links links_middle">
			  		     <li><a href="#"><i class="title-icon"> </i><span class="icon_text">Lorem Ipsum Dolore</span></a></li>
				  		 <li><i class="tags"> </i><span class="icon_text">No tags</span></li>
		  		    </ul>
					<!---->
					<div class=" single-profile">
				<h4> RELATED POSTS</h4>
				<div class="single-left ">					
					<div class="col-md-3 post-top">
					<a href="#"><img class="img-responsive " src="images/si.jpg" alt="" /></a>
						<h6>Duis autem</h6>
						<p>Lorem ipsum dolor sit amet, consectetuer .</p>
					</div>
					<div class="col-md-3 post-top">
					<a href="#"><img class="img-responsive " src="images/si1.jpg" alt="" /></a>
						<h6>Duis autem</h6>
						<p>Lorem ipsum dolor sit amet, consectetuer .</p>
					</div>
					<div class="col-md-3 post-top">
					<a href="#"><img class="img-responsive " src="images/si2.jpg" alt="" /></a>
						<h6>Duis autem</h6>
						<p>Lorem ipsum dolor sit amet, consectetuer .</p>
					</div>
					<div class="col-md-3 post-top">
					<a href="#"><img class="img-responsive " src="images/si3.jpg" alt="" /></a>
						<h6>Duis autem</h6>
						<p>Lorem ipsum dolor sit amet, consectetuer .</p>
					</div>
					<div class="clearfix"> </div>
				</div>
			</div>
		<!--start-leavecomment-->
			<div class="leave-comment">
				<h3>COMMENTS</h3>
				<div class="table-form">
					<form >
				<div>
				<span>Name</span>
					<input type="text" value=" ">
				</div>
				<div>
					<span>Email</span>
					<input type="text" value=" ">
				</div>
				<div>
					<span>Your Comment</span>
					<textarea> </textarea>	
				</div>
				</form>
					<input type="submit" value="submit">		
			</div>
		</div>
		</div>			
	</div>
<!---->
	<div class="footer">
		<div class="container">
			<div class="footer-top">
				<div class="col-md-4 amet-sed">
				<h4>Kitchen-Master</h4>
				<p class="flan">443 Flanigan Oaks Drive<span>
					Alexandria, MD 22304</span></p>
				<p>PHONE : <label>+1 234 567890</label></p>
				<p>Mail: <a href="mailto:info@example.com">info@example.com</a></p>
				<ul class="social-in">
				
					<li><a href="#"><i> </i></a></li>						
					<li><a href="#"><i class="twitter"> </i></a></li>
				</ul>

				</div>
				<div class="col-md-3 amet-sed-box ">
					<ul class="nav-bottom">
						<li><a href="about.html" >About</a> </li>
						<li><a href="404.html" >Courses</a></li>
						<li><a href="gallery.php">Gallery </a></li>
						
						<li><a href="contact.php">Contact </a></li>
					</ul>
				</div>
				<div class="col-md-5 amet-sed-top ">				
						<div class="enter">
						<form>
							<input type="text" value="ENTER YOUR EMAIL TO SUBSCRIBE" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = '';}" >	
							<input type="submit" value="">
						</form>	
						</div>
<p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. 
<span>Excepteur sint occaecat cupidatat non proident, suntin culpa qui officia deserunt</span></p>						
				</div>
				<div class="clearfix"> </div>
			</div>
				<p class="footer-class">Copyright &copy; 2015 Kitchen-Master . All Rights Reserved Template by  <a href="http://w3layouts.com/" target="_blank">W3layouts</a></p>
		</div>
		 <script type="text/javascript">
						$(document).ready(function() {
							/*
							var defaults = {
					  			containerID: 'toTop', // fading element id
								containerHoverID: 'toTopHover', // fading element hover id
								scrollSpeed: 1200,
								easingType: 'linear' 
					 		};
							*/
							
							$().UItoTop({ easingType: 'easeOutQuart' });
							
						});
					</script>
				<a href="#" id="toTop" style="display: block;"> <span id="toTopHover" style="opacity: 1;"> </span></a>
	</div>

</body>
</html>