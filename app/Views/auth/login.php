<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.register') ?> <?= $this->endSection() ?>

<?= $this->section('style')?>
    <link rel="stylesheet" media="screen, print" href="<?= base_url('assets/css/')?>fa-brands.css">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="height-10 w-100 shadow-lg px-4 bg-brand-gradient">
        <div class="d-flex align-items-center container p-0">
            <div class="page-logo width-mobile-auto m-0 align-items-center justify-content-center p-0 bg-transparent bg-img-none shadow-0 height-9 border-0">
                <a href="javascript:void(0)" class="page-logo-link press-scale-down d-flex align-items-center">
                    <img src="<?= base_url('assets/img/')?>logo.png" alt="SmartAdmin WebApp" aria-roledescription="logo">
                    <span class="page-logo-text mr-1">SmartAdmin WebApp</span>
                </a>
            </div>
            <span class="text-white opacity-50 ml-auto mr-2 hidden-sm-down">
                               <?= lang('Auth.needAccount') ?>
                            </span>
            <a href="<?= url_to('register') ?>" class="btn-link text-white ml-auto ml-sm-0">
                <?= lang('Auth.register') ?>
            </a>
        </div>
    </div>
    <div class="flex-1"
         style="background: url(<?= base_url('assets/img/svg/') ?>pattern-1.svg) no-repeat center bottom fixed; background-size: cover;">
        <div class="container py-4 py-lg-5 my-lg-5 px-4 px-sm-0">
            <div class="row">
                <div class="col col-md-6 col-lg-7 hidden-sm-down">
                    <h2 class="fs-xxl fw-500 mt-4 text-white">
                        The simplest UI toolkit for developers &amp; programmers
                        <small class="h3 fw-300 mt-3 mb-5 text-white opacity-60">
                            Presenting you with the next level of innovative UX design and engineering. The most modular
                            toolkit available with over 600+ layout permutations. Experience the simplicity of
                            SmartAdmin, everywhere you go!
                        </small>
                    </h2>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-5 col-xl-4 ml-auto">
                    <h1 class="text-white fw-300 mb-3 d-sm-block d-md-none">
                        <?= lang('Auth.login') ?>
                    </h1>

                    <?php if (session('error') !== null) : ?>
                        <div class="alert alert-danger" role="alert"><?= session('error') ?></div>
                    <?php elseif (session('errors') !== null) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?php if (is_array(session('errors'))) : ?>
                                <?php foreach (session('errors') as $error) : ?>
                                    <?= $error ?>
                                    <br>
                                <?php endforeach ?>
                            <?php else : ?>
                                <?= session('errors') ?>
                            <?php endif ?>
                        </div>
                    <?php endif ?>

                    <?php if (session('message') !== null) : ?>
                        <div class="alert alert-success" role="alert"><?= session('message') ?></div>
                    <?php endif ?>
                    <div class="card p-4 rounded-plus bg-faded">
                        <form action="<?= url_to('login') ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="form-group">
                                <label class="form-label" for="email"><?= lang('Auth.email') ?></label>
                                <input type="email" id="email" class="form-control form-control-lg" name="email"
                                       inputmode="email" autocomplete="email" placeholder="<?= lang('Auth.email') ?>"
                                       value="<?= old('email') ?>" required/>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="password"><?= lang('Auth.password') ?></label>
                                <input type="password" id="password" class="form-control form-control-lg"
                                       name="password" inputmode="text" autocomplete="current-password"
                                       placeholder="<?= lang('Auth.password') ?>" required/>
                            </div>
                            <div class="form-group text-left">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="remember" class="custom-control-input"
                                           id="rememberme" <?php if (old('remember')): ?> checked<?php endif ?>>
                                    <label class="custom-control-label"
                                           for="rememberme"><?= lang('Auth.rememberMe') ?></label>
                                </div>
                            </div>
                            <button type="submit"
                                    class="btn btn-danger btn-block btn-lg"><?= lang('Auth.login') ?></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="position-absolute pos-bottom pos-left pos-right p-3 text-center text-white">
                2020 © SmartAdmin by&nbsp;<a href='https://www.gotbootstrap.com' class='text-white opacity-40 fw-500'
                                             title='gotbootstrap.com' target='_blank'>gotbootstrap.com</a>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>