<!DOCTYPE html>
<?php
// Create mysql connection
$servername = "localhost";
$database = "labproject";
$username = "root";
$password = "MySQLPassIsPassWord";
// Create connection
$conn = new mysqli($servername, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// SELECT statement
$select_statement = "SELECT * FROM reviews ORDER BY id DESC;";
// Execute the SELECT statement
$result = $conn->query($select_statement);
// Submit review form to database
if (isset($_POST['reviewSubmit'])) {
    $name = $_POST['name'];
    $review = $_POST['review'];
    $insertStatement = 'INSERT INTO reviews (name, review) 
                        VALUES (\'' . $name . '\', \'' . $review . '\')';
    $conn->query($insertStatement);
    $result = $conn->query($select_statement);
}
// Submit question form to database
if (isset($_POST['questionSubmit'])) {
    $contact = $_POST['contact'];
    $question = $_POST['question'];
    $insertStatement = 'INSERT INTO Questions (contact, question) 
                        VALUES (\'' . $contact . '\', \'' . $question . '\')';
    $conn->query($insertStatement);
    $result = $conn->query($select_statement);
}
// Throw message if there's no result
if (!$result) die("Result is empty");
?>

<html>
<head>
    <title>almatypovar_banket</title>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all"/>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.min.js"></script>
    <!-- Custom Theme files -->
    <!--theme-style-->
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
    <!--//theme-style-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="keywords" content="Kitchen-Master Responsive web template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template,
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design"/>
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
    <script type="text/javascript" src="js/move-top.js"></script>
    <script type="text/javascript" src="js/easing.js"></script>
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
<div class="header">
    <div class="container">
        <!---->
        <div class="header-logo">
            <div class="logo">
                <a href="index.php"><img src="images/logo.png" alt=""></a>
            </div>
            <div class="top-nav">
                <span class="menu"> </span>
                <ul>
                    <li><a href="about.html" data-hover="О НАС">О НАС </a></li>
                    <li><a href="404.html" data-hover="ЗАКАЗАТЬ"> ЗАКАЗАТЬ</a></li>
                    <li><a href="gallery.php" data-hover="МЕНЮ">МЕНЮ </a></li>
                    <li><a href="contact.php" data-hover="КОНТАКТЫ">КОНТАКТЫ </a></li>
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
                <li><a href="about.html" data-hover="О НАС">О НАС </a></li>
                <li><a href="404.html" data-hover="ЗАКАЗАТЬ"> ЗАКАЗАТЬ</a></li>
                <li><a href="index.php"><img src="images/logo.png" alt=""></a></li>
                <li><a href="gallery.php" data-hover="МЕНЮ">МЕНЮ </a></li>
                <li><a href="contact.php" data-hover="КОНТАКТЫ">КОНТАКТЫ </a></li>
            </ul>
            <!--script-->
        </div>
        <div class="header-top">
            <img class="img-responsive" src="images/art.png" alt="">
            <h2>У вас мероприятие</h2>
            <p class="to-do">но некому накрыть на стол?</p>
            <h1>У нас есть решение! <span>Банкеты на заказ</span></h1>
            <p class="have">Мы все сделаем за вас!</p>
            <img class="img-responsive" src="images/ar.png" alt="">
        </div>
    </div>
</div>
<!---->
<div class="content">
    <div class="container">
        <div class="content-top">
            <div class="content-top-grid">
                <div class="col-md-6 content-top-bottom ">
                    <h3>Банкет</h3>
                    <p>Take world-class cooking courses in the heart of New York City! Travel the culinary world from
                        the comfort of our kitchens with our endless selection of hands-on cooking classes taught by
                        Kitchen-Master's renowned Chef Instructors.</p>
                </div>
                <div class="col-md-6">
                    <a href="single.php"><img class="img-responsive" src="images/pic1.jpg" alt=""></a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="content-top-grid">
                <div class="col-md-7">
                    <a href="single.php"><img class="img-responsive" src="images/pic.jpg" alt=""></a>
                </div>
                <div class="col-md-5 content-top-at ">
                    <h3>SauTE, Grill, Reduce, Plate, Taste and Learn</h3>
                    <p>Подберем повара, который приготовит на любой изысканный вкус. Представляем вам разные виды кухни:
                        Казахскую, Азиатскую, Европейскую. Повар составит меню с учетом особенностями ваших пожелании.
                        Сделает калькуляцию продуктов, составит праздничное меню и выполнит сервировку стола. <span>Это уникальная возможность избавить Вас и Ваших близких от суеты и хлопот! Мы проводим выездные мероприятия в удобном для Вас месте.</span>
                    </p>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <!---->
    <div class="content-middle">
        <a href="single.php"><img class="img-responsive" src="images/pi1.png" alt=""></a>
        <p>Whatever skill, technique or cuisine you want to learn,
            Kitchen-Master has the perfect cooking classes for you.
            Register online today and get started on your culinary adventure!</p>
        <a href="single.php" class="register">READ MORE</a>
    </div>
    <!---->

    <div class="content-bottom">
        <div class="container">
            <h3>ОТЗЫВЫ</h3>
            <div class="col-md-6 name-in">
                <?php
                $i = 0;
                while ($row = $result->fetch_assoc() and $i < 3) {
                    $i++;
                    echo '<div class="bottom-in">
                         <p class="para-in">' . $row['review'] . '</p>
                         <i class="dolor"> </i>
                         <div class="men-grid">
                         <div class="men">
                         <span>' . $row['name'] . '</span>
                         <p>Клиент</p>
                         </div>
                         <div class="clearfix"></div>
                         </div>
                         </div>';
                }
                ?>
                <form  method="post" action="index.php">
                    <label for="name">
                        <input name="name" type="text" placeholder="Напишите ваше имя" required>
                    </label>
                    <label for="review">
                        <input name="review" type="text" placeholder="Напишите ваш отзыв" required>
                    </label>
                    <button name="reviewSubmit" type="submit">Оставить отзыв</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!---->
<div class="footer">
    <div class="container">
        <div class="footer-top">
            <div class="col-md-4 amet-sed">
                <h4>almatypovar_banket</h4>
                <p class="flan">Город Алматы, Казахстан<span>
					Работаем по всему городу</span></p>
                <p>PHONE : <label>+7 707 758 41 82</label></p>
                <p>Instagram: <a href="almatypovar_banket">info@example.com</a></p>
                <ul class="social-in">
                    <li><a href="https://wa.me/+77077584182/"><i> </i></a></li>
                    <li><a href="https://www.instagram.com/almatypovar_banket/"><i class="instagram"> </i></a></li>
                </ul>
            </div>
            <div class="col-md-3 amet-sed-box ">
                <ul class="nav-bottom">
                    <li><a href="about.html">О НАС</a></li>
                    <li><a href="404.html">ЗАКАЗАТЬ</a></li>
                    <li><a href="gallery.php">МЕНЮ </a></li>

                    <li><a href="contact.php">КОНТАКТЫ </a></li>
                </ul>
            </div>
            <div class="col-md-5 amet-sed-top ">
                <div class="enter">
                    <form method="post">
                        <input name="contact" type="text" value="Оставьте ваши контаты что бы мы свзались с вами"
                               onfocus="this.value = '';" onblur="if (this.value == '') {this.value = '';}" required>
                        <input name="question" type="text"
                               value="Напишите свой вопрос для того что бы мы ответили на него"
                               onfocus="this.value = '';" onblur="if (this.value == '') {this.value = '';}">
                        <input name="questionSubmit" type="submit" value="">
                    </form>
                </div>
                <p>Для ответа на ваши вопросы, предложения, претензии вы можете оставить свои контактные данные для
                    того
                    что б наши операторы смогли с вами связаться
                    <span>Нам важен каждый клиент!</span></p>
            </div>
            <div class="clearfix"></div>
            <script type="text/javascript">
                $(document).ready(function () {
                    $().UItoTop({easingType: 'easeOutQuart'});
                });
            </script>
            <a href="#" id="toTop" style="display: block;"> <span id="toTopHover" style="opacity: 1;"> </span></a>
            <!--скрипты для формы и датабазы-->
            <script>
                if (window.history.replaceState) {
                    window.history.replaceState(null, null, window.location.href);
                }
            </script>

            <?php
            // Close the connection
            $conn->close();
            ?>
        </div>
    </div>
</div>
</body>
</html>