
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>DGTFarm Online</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Kanit:100,200,300,400,500,600|Lato:100,300,400,700" rel="stylesheet">

</head>

<body class="home home-intro version-two three">
<header class="header header-intro" style="background: url(images/bg-themev302.jpg) no-repeat center center fixed;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;">
    <div class="text-vertical-center">
        <div class="header-title">
            <h1><span>DGT</span>Farm</h1>
            <h3><span>“</span>มิติใหม่สินค้าเกษตรไทยบนโลกออนไลน์<span>”</span></h3>
            <p>การจับคู่ธุรกิจยุคใหม่ที่เกษตรกรไทยและผู้บริโภคจะมาพบกันในโลกออนไลน์</p>
        </div>
        <div class="header-content">
            <div class="container">
                <div class="row row-eq-height">
                    <div class="header-container">
                        <div class="col-sm-4 col-lg-4 col-md-4">
                            <a href="{{url('user/chooseregister')}}" target="_self">
                                <div class="thumbnail register-section">
                                    <img src="images/icon-register.png" alt="">
                                    <div class="caption">
                                        <h4>สมัครสมาชิก</h4>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-4 col-lg-4 col-md-4">
                            <a href="{{url('/choosemarket?market=sale')}}" target="_self">
                                <div class="thumbnail shop-section">
                                    <img src="images/icon-shop.png" alt="">
                                    <div class="caption">
                                        <h4>ชมตลาด</h4>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-4 col-lg-4 col-md-4">
                            <a href="{{url('home')}}" target="_self">
                                <div class="thumbnail view-section">
                                    <img src="images/icon-view.png" alt="">
                                    <div class="caption">
                                        <h4>จับคู่ซื้อขาย</h4>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</header>
</body>

</html>
