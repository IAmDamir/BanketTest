<!--A Design by W3layouts 
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<?php
include 'connectToTheDatabase.php';
// SELECT statement
$select_statement = "SELECT 
                            id,
                            picture,
                            category
                    FROM dishes;";
// Execute the SELECT statement
$result = $conn->query($select_statement);
// Throw message if there's no result
if (!$result) die("Result is empty");
// Preparing arrays to store dishes
$main_picture_array = array();
$salad_picture_array = array();
$snack_picture_array = array();
$dessert_picture_array = array();
// Storing dishes in arrays by categories
while ($row = $result->fetch_assoc()) {
    if ($row['picture'] != "green салат по-французский") {
        if (!is_null($row['picture']) && !empty($row['picture'])) {
            if ($row['category'] == 'горячее') {
                $main_picture_array[$row['id']] = $row['picture'];
            } else if ($row['category'] == 'салат') {
                $salad_picture_array[$row['id']] = $row['picture'];
            } else if ($row['category'] == 'закуски') {
                $snack_picture_array[$row['id']] = $row['picture'];
            } else if ($row['category'] == 'десерт') {
                $dessert_picture_array[$row['id']] = $row['picture'];
            }
        }
    }
}

function outputTheImages($arr) {
    foreach ($arr as $id => $picture) {
        echo
            '<div class="col-md-4 img-top ">
                <div class="portfolio-wrapper">
                    <a class="b-link-stripe b-animate-go " href="single.php?dish_id=' . $id . '">
                        <img alt="" class="img-responsive" src="menu/' . $picture . '"/>
                        <span class="zoom-icon"> </span>
                    </a>
                </div>
            </div>';
    }
}
?>
<html>
<head>
    <style>
        .img-responsive {
            height: 200px !important;
        }
        .resp-tabs-container {
            height: 1200px;
            width: 1020px;
            object-fit: contain;
        }
    </style>
    <title>Kitchen-Master A Hotel Category Flat Bootstrap Responsive Website Template | Gallery :: w3layouts</title>
    <link href="css/bootstrap.css" media="all" rel="stylesheet" type="text/css"/>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.min.js"></script>
    <!-- Custom Theme files -->
    <!--theme-style-->
    <link href="css/style.css" media="all" rel="stylesheet" type="text/css"/>
    <!--//theme-style-->
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
    <meta content="Kitchen-Master Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template,
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design"
          name="keywords"/>
    <script type="application/x-javascript"> addEventListener("load", function () {
        setTimeout(hideURLbar, 0);
    }, false);

    function hideURLbar() {
        window.scrollTo(0, 1);
    } </script>
    <!--fonts-->
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css'>
    <!--//fonts-->
    <script src="js/move-top.js" type="text/javascript"></script>
    <script src="js/easing.js" type="text/javascript"></script>
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            $(".scroll").click(function (event) {
                event.preventDefault();
                $('html,body').animate({scrollTop: $(this.hash).offset().top}, 1000);
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
                <a href="index.php"><img alt="" src="images/logo.png"></a>
            </div>
            <div class="top-nav">
                <span class="menu"> </span>
                <ul>
                    <li><a data-hover="ABOUT" href="about.html">ABOUT </a></li>
                    <li><a data-hover="CLASSES" href="404.html"> CLASSES</a></li>
                    <li><a data-hover="GALLERY" href="gallery.php">GALLERY </a></li>
                    <li><a data-hover="CONTACT" href="contact.php">CONTACT </a></li>
                </ul>
                <!--script-->
                <script>
                    $("span.menu").click(function () {
                        $(".top-nav ul").slideToggle(500, function () {
                        });
                    });
                </script>
            </div>
            <div class="clearfix"></div>
        </div>
        <!---->
        <div class="top-menu">
            <ul>
                <li><a data-hover="ABOUT" href="about.html">ABOUT </a></li>
                <li><a data-hover="CLASSES" href="404.html"> CLASSES</a></li>
                <li><a href="index.php"><img alt="" src="images/logo.png"></a></li>
                <li class="active"><a href="gallery.php">GALLERY </a></li>
                <li><a data-hover="CONTACT" href="contact.php">CONTACT </a></li>
            </ul>
            <!--script-->

        </div>

    </div>
</div>
<!---->
<div class="container">
    <div class="product">
        <h2>GALLERY</h2>
        <script src="js/easyResponsiveTabs.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#horizontalTab').easyResponsiveTabs({
                    type: 'default', //Types: default, vertical, accordion
                    width: 'auto', //auto or any width like 600px
                    fit: true   // 100% fit in a container
                });
            });

        </script>
        <div class="sap_tabs">
            <div id="horizontalTab" style="display: block; width: 100%; margin: 0;">
                <ul class="resp-tabs-list">
                    <li aria-controls="tab_item-0" class="resp-tab-item" role="tab"><span>ALL</span></li>
                    /
                    <li aria-controls="tab_item-1" class="resp-tab-item" role="tab"><span>Горячее</span></li>
                    /
                    <li aria-controls="tab_item-2" class="resp-tab-item" role="tab"><span>Закуски</span></li>
                    /
                    <li aria-controls="tab_item-3" class="resp-tab-item" role="tab"><span>Салаты</span></li>
                    /
                    <li aria-controls="tab_item-4" class="resp-tab-item" role="tab"><span>Десерты</span></li>
                </ul>
                <div class="resp-tabs-container">
                    <div aria-labelledby="tab_item-0" class="tab-1 resp-tab-content">
                        <div class="tab_img">
                            <?php
                            outputTheImages($main_picture_array);
                            outputTheImages($dessert_picture_array);
                            outputTheImages($salad_picture_array);
                            outputTheImages($snack_picture_array);
                            ?>
                            <div class="clearfix"></div>
                        </div>

                    </div>
                    <div aria-labelledby="tab_item-1" class="tab-1 resp-tab-content">
                        <div class="tab_img">
                            <?php
                            outputTheImages($main_picture_array);
                            ?>

                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div aria-labelledby="tab_item-2" class="tab-1 resp-tab-content">
                        <div class="tab_img">
                            <?php
                            outputTheImages($snack_picture_array);
                            ?>
                        </div>
                    </div>
                    <div aria-labelledby="tab_item-3" class="tab-1 resp-tab-content">
                        <div class="tab_img">
                            <?php
                            outputTheImages($salad_picture_array);
                            ?>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div aria-labelledby="tab_item-4" class="tab-1 resp-tab-content">
                        <div class="tab_img">
                            <?php
                            outputTheImages($dessert_picture_array);
                            ?>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
                    <li><a href="about.html">About</a></li>
                    <li><a href="404.html">Courses</a></li>
                    <li><a href="gallery.php">Gallery </a></li>
                    <li><a href="contact.php">Contact </a></li>
                </ul>
            </div>
            <div class="col-md-5 amet-sed-top ">
                <div class="enter">
                    <form>
                        <input onblur="if (this.value === '') {this.value = '';}" onfocus="this.value = '';" type="text"
                               value="ENTER YOUR EMAIL TO SUBSCRIBE">
                        <input type="submit" value="">
                    </form>
                </div>
                <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
                    pariatur.
                    <span>Excepteur sint occaecat cupidatat non proident, suntin culpa qui officia deserunt</span></p>
            </div>
            <div class="clearfix"></div>
        </div>
        <p class="footer-class">Copyright &copy; 2015 Kitchen-Master. All Rights Reserved Template by <a
                href="http://w3layouts.com/" target="_blank">W3layouts</a></p>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $().UItoTop({easingType: 'easeOutQuart'});
        });
    </script>
    <a href="#" id="toTop" style="display: block;"> <span id="toTopHover" style="opacity: 1;"> </span></a>
</div>

</body>
</html>