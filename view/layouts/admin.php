<!DOCTYPE html>
<html>
    <head>
        <title>
          <?php
            if(isset($title)) {
              echo $title;
            } else {
              echo "Панель администратора";
            }
          ?>
        </title>

        <meta charset="UTF-8">
        <meta name="description" content="Clean and responsive administration panel">
        <meta name="keywords" content="Admin,Panel,HTML,CSS,XML,JavaScript">
        <meta name="author" content="Erik Campobadal">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="icon" type="image/png" href="/resources/images/icon.png"/>
        <link rel="stylesheet" href="/resources/styles/admin/uikit.min.css" />
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="/resources/styles/admin/style.css" />
        <link rel="stylesheet" href="/resources/styles/admin/notyf.min.css" />
        <?php
          if(isset($styles)) {
            foreach($styles as $style) {
               echo '<link rel="stylesheet" href="/resources/styles/admin/' . $style . '.css" />';
            }
          }
        ?>
	      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
        <script src="/resources/scripts/admin/uikit.min.js" ></script>
		    <script src="/resources/scripts/admin/uikit-icons.min.js"></script>
    </head>
    <body>
        <div uk-sticky class="uk-navbar-container tm-navbar-container uk-active">
            <div class="uk-container uk-container-expand">
                <nav uk-navbar>
                    <div class="uk-navbar-left">
                        <a id="sidebar_toggle" class="uk-navbar-toggle" uk-navbar-toggle-icon ></a>
                        <a href="#" class="uk-navbar-item uk-logo">
                            Управление
                        </a>
                    </div>
                    <div class="uk-navbar-right uk-light">
                        <ul class="uk-navbar-nav">
                            <li class="uk-active">
                                <a href="#">Аккаунт &nbsp;<span class="ion-ios-arrow-down"></span></a>
                                <div uk-dropdown="pos: bottom-right; mode: click; offset: -17;">
                                   <ul class="uk-nav uk-navbar-dropdown-nav">
                                       <li class="uk-nav-header">Настройки</li>
                                       <li><a href="/admin/profile">Редактировать</a></li>
                                       <li class="uk-nav-header">Действии</li>
                                       <li><a href="/admin/logout">Выход</a></li>
                                   </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <div id="sidebar" class="tm-sidebar-left uk-background-default">
            <center>
                <div class="user">
                    <img id="avatar" width="100" class="uk-border-circle" src="/resources/images/logotype.png" />
                    <div class="uk-margin-top"></div>
                </div>
                <br />
            </center>
            <ul class="uk-nav uk-nav-default">

                <li class="uk-nav-header">
                    Главная
                </li>
                <li class="sidebar__select"><a href="/admin">Информация</a></li>
                <li class="sidebar__select"><a href="/admin/product">Продукты</a></li>
                <li class="sidebar__select"><a href="/admin/category">Категории</a></li>
                <li class="sidebar__select"><a href="/admin/server">Сервера</a></li>
                <li class="sidebar__select"><a href="/admin/promocode">Промокоды</a></li>

                <li class="uk-nav-header">
                    Модули
                </li>
                <li class="sidebar__select"><a href="/admin/lastbuys">Последние покупки</a></li>
                <!-- <li class="sidebar__select"><a href="/admin/news" class="uk-text-danger" style="opacity: .5;">VK Новости <span class="uk-badge uk-label-danger" style="font-size: 11px; padding: 10px;">SOON</span></a></li> -->

                <li class="uk-nav-header">
                    Сайт
                </li>
                <li class="sidebar__select"><a href="/admin/settings">Настройки</a></li>
                <li class="sidebar__select"><a href="/admin/payments">Способы оплат</a></li>
            </ul>
        </div>
        <div class="content-padder content-background">
            <div class="uk-section-small uk-section-default header">
                <div class="uk-container uk-container-large">
                    <h1><span class="ion-clipboard"></span> <span id="ytitle"><? echo $name; ?></span></h1>
                </div>
            </div>
            <div class="uk-section-small">
                <div class="uk-container uk-container-large" style="overflow: scroll;">
                    <?php if(isset($content)) {require_once $content;} ?>
                </div>
            </div>
        </div>
		<!-- Load More Javascript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.min.js" integrity="sha256-UGwvyUFH6Qqn0PSyQVw4q3vIX0wV1miKTracNJzAWPc=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.transit/0.9.12/jquery.transit.min.js" integrity="sha256-rqEXy4JTnKZom8mLVQpvni3QHbynfjPmPxQVsPZgmJY=" crossorigin="anonymous"></script>
        <script src="/resources/scripts/admin/notyf.min.js"></script>
        <script src="/resources/scripts/admin/script.js"></script>
        <?php
          if(isset($scripts)) {
            foreach($scripts as $script) {
               echo '<script src="/resources/scripts/admin/' . $script . '.js"></script>';
            }
          }
        ?>
    </body>
</html>
