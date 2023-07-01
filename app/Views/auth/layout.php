<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title><?= $this->renderSection('title') ?> - Code Igniter 4</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no">
    <!-- base css -->
    <link id="vendorsbundle" rel="stylesheet" media="screen, print"
          href="<?= base_url('assets/css/') ?>vendors.bundle.css">
    <link id="appbundle" rel="stylesheet" media="screen, print" href="<?= base_url('assets/css/') ?>app.bundle.css">
    <!-- Place favicon.ico in the root directory -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('assets/img/favicon/') ?>apple-touch-icon.png">
    <link rel="icon" sizes="32x32" href="<?= base_url('assets/img/favicon/') ?>favicon.ico">
    <link rel="mask-icon" href="<?= base_url('assets/img/favicon/') ?>safari-pinned-tab.svg" color="#5bbad5">
    <?= $this->renderSection('styles') ?>
</head>

<body>

<div class="page-wrapper auth">
    <div class="page-inner bg-brand-gradient">
        <div class="page-content-wrapper bg-transparent m-0">
            <?= $this->renderSection('content') ?>
        </div>
    </div>
</div>

<script src="<?= base_url('assets/js/') ?>vendors.bundle.js"></script>
<script src="<?= base_url('assets/js/') ?>app.bundle.js"></script>
<?= $this->renderSection('scripts') ?>
</body>
</html>
