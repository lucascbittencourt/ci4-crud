<?php

$authUser = auth()->user();
$authUserName = $authUser->first_name . ' ' . $authUser->last_name;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>
        <?= $this->renderSection('title') ?> - Code Igniter 4
    </title>
    <meta name="description" content="Page Title">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
    <!-- Call App Mode on ios devices -->
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no">
    <!-- base css -->
    <link id="vendorsbundle" rel="stylesheet" media="screen, print" href="<?= base_url('assets/css/') ?>vendors.bundle.css">
    <link id="appbundle" rel="stylesheet" media="screen, print" href="<?= base_url('assets/css/') ?>app.bundle.css">
    <!-- Place favicon.ico in the root directory -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('assets/img/favicon/') ?>apple-touch-icon.png">
    <link rel="icon" sizes="32x32" href="<?= base_url('assets/img/favicon/') ?>favicon.ico">
    <link rel="mask-icon" href="<?= base_url('assets/img/favicon/') ?>safari-pinned-tab.svg" color="#5bbad5">

    <?= $this->renderSection('styles') ?>
</head>
<body class="mod-bg-1">

<div class="page-wrapper">
    <div class="page-inner">
        <!-- BEGIN Left Aside -->
        <aside class="page-sidebar">
            <div class="page-logo">
                <a href="#" class="page-logo-link press-scale-down d-flex align-items-center position-relative" data-toggle="modal" data-target="#modal-shortcut">
                    <img src="<?= base_url('assets/img/') ?>logo.png" alt="SmartAdmin WebApp" aria-roledescription="logo">
                    <span class="page-logo-text mr-1">Code Igniter 4</span>
                </a>
            </div>
            <!-- BEGIN PRIMARY NAVIGATION -->
            <nav id="js-primary-nav" class="primary-nav" role="navigation">
                <div class="info-card">
                    <img src="<?= base_url('assets/img/demo/avatars/') ?>avatar-admin.png" class="profile-image rounded-circle" alt="Dr. Codex Lantern">
                    <div class="info-card-text">
                        <a href="#" class="d-flex align-items-center text-white">
                                    <span class="text-truncate text-truncate-sm d-inline-block">
                                        <?= $authUserName ?>
                                    </span>
                        </a>
                        <span class="d-inline-block text-truncate text-truncate-sm"><?= auth()->user()->username ?></span>
                    </div>
                    <img src="<?= base_url('assets/img/card-backgrounds/') ?>cover-2-lg.png" class="cover" alt="cover">
                </div>
                <!--
                TIP: The menu items are not auto translated. You must have a residing lang file associated with the menu saved inside dist/media/data with reference to each 'data-i18n' attribute.
                -->
                <ul class="nav-menu">
                    <li class="nav-title">Features</li>
                    <li class="active">
                        <a class="nav-link-text waves" href="<?= url_to('users.index') ?>">
                            <i class="fal fa-users"></i>
                            <span class="nav-link-text">Users</span>
                        </a>
                    </li>
                </ul>
                <div class="filter-message js-filter-message bg-success-600"></div>
            </nav>
            <!-- END PRIMARY NAVIGATION -->
        </aside>
        <!-- END Left Aside -->
        <div class="page-content-wrapper">
            <!-- BEGIN Page Header -->
            <header class="page-header" role="banner">
                <!-- we need this logo when user switches to nav-function-top -->
                <div class="page-logo">
                    <a href="#" class="page-logo-link press-scale-down d-flex align-items-center position-relative" data-toggle="modal" data-target="#modal-shortcut">
                        <img src="<?= base_url('assets/img/') ?>logo.png" alt="SmartAdmin WebApp" aria-roledescription="logo">
                        <span class="page-logo-text mr-1">SmartAdmin WebApp</span>
                        <span class="position-absolute text-white opacity-50 small pos-top pos-right mr-2 mt-n2"></span>
                        <i class="fal fa-angle-down d-inline-block ml-1 fs-lg color-primary-300"></i>
                    </a>
                </div>
                <!-- DOC: mobile button appears during mobile width -->
                <div class="hidden-lg-up">
                    <a href="#" class="header-btn btn press-scale-down" data-action="toggle" data-class="mobile-nav-on">
                        <i class="ni ni-menu"></i>
                    </a>
                </div>
                <div class="ml-auto d-flex">
                    <!-- app user menu -->
                    <div>
                        <a href="#" data-toggle="dropdown" title="drlantern@gotbootstrap.com" class="header-icon d-flex align-items-center justify-content-center ml-2">
                            <img src="<?= base_url('assets/img/demo/avatars/') ?>avatar-admin.png" class="profile-image rounded-circle" alt="Dr. Codex Lantern">
                            <!-- you can also add username next to the avatar with the codes below:
                            <span class="ml-1 mr-1 text-truncate text-truncate-header hidden-xs-down">Me</span>
                            <i class="ni ni-chevron-down hidden-xs-down"></i> -->
                        </a>
                        <div class="dropdown-menu dropdown-menu-animated dropdown-lg">
                            <div class="dropdown-header bg-trans-gradient d-flex flex-row py-4 rounded-top">
                                <div class="d-flex flex-row align-items-center mt-1 mb-1 color-white">
                                            <span class="mr-2">
                                                <img src="<?= base_url('assets/img/demo/avatars/') ?>avatar-admin.png" class="rounded-circle profile-image" alt="Dr. Codex Lantern">
                                            </span>
                                    <div class="info-card-text">
                                        <div class="fs-lg text-truncate text-truncate-lg"><?= $authUserName ?></div>
                                        <span class="text-truncate text-truncate-md opacity-80"><?= $authUser->email ?> </span>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown-divider m-0"></div>
                            <a class="dropdown-item fw-500 pt-3 pb-3" href="<?= url_to('logout') ?>">
                                <span data-i18n="drpdwn.page-logout">Logout</span>
                            </a>
                        </div>
                    </div>
                </div>
            </header>
            <!-- END Page Header -->
            <!-- BEGIN Page Content -->
            <!-- the #js-page-content id is needed for some plugins to initialize -->
            <main id="js-page-content" role="main" class="page-content">
                <div class="row">
                    <?= $this->renderSection('content') ?>
                </div>
            </main>
            <!-- this overlay is activated only when mobile menu is triggered -->
            <div class="page-content-overlay" data-action="toggle" data-class="mobile-nav-on"></div> <!-- END Page Content -->
            <!-- BEGIN Page Footer -->
            <footer class="page-footer" role="contentinfo">
                <div class="d-flex align-items-center flex-1 text-muted">
                    <span class="hidden-md-down fw-700">2020 © SmartAdmin by&nbsp;<a href='https://www.gotbootstrap.com' class='text-primary fw-500' title='gotbootstrap.com' target='_blank'>gotbootstrap.com</a></span>
                </div>
                <div>
                    <ul class="list-table m-0">
                        <li><a href="intel_introduction.html" class="text-secondary fw-700">About</a></li>
                        <li class="pl-3"><a href="info_app_licensing.html" class="text-secondary fw-700">License</a></li>
                        <li class="pl-3"><a href="info_app_docs.html" class="text-secondary fw-700">Documentation</a></li>
                        <li class="pl-3 fs-xl"><a href="https://wrapbootstrap.com/user/MyOrange" class="text-secondary" target="_blank"><i class="fal fa-question-circle" aria-hidden="true"></i></a></li>
                    </ul>
                </div>
            </footer>
            <!-- END Page Footer -->
        </div>
    </div>
</div>

<script src="<?= base_url('assets/js/') ?>vendors.bundle.js"></script>
<script src="<?= base_url('assets/js/') ?>app.bundle.js"></script>
<?= $this->renderSection('scripts') ?>
</body>
</html>
