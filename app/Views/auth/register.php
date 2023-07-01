<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.register') ?> <?= $this->endSection() ?>

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
                               <?= lang('Auth.haveAccount') ?>
                            </span>
        <a href="<?= url_to('login') ?>" class="btn-link text-white ml-auto ml-sm-0">
            <?= lang('Auth.login') ?>
        </a>
    </div>
</div>
<div class="flex-1" style="background: url(<?= base_url('assets/img/svg/') ?>pattern-1.svg) no-repeat center bottom fixed; background-size: cover;">
    <div class="container py-3 py-lg-4 my-lg-4 px-4 px-sm-0">
        <div class="row">
            <div class="col-xl-12">
                <h2 class="fs-xxl fw-500 mt-4 text-white text-center">
                    Register now, its free!
                    <small class="h3 fw-300 mt-3 mb-5 text-white opacity-60 hidden-sm-down">
                        Your registration is free for a limited time. Enjoy SmartAdmin on your mobile, desktop or tablet.
                        <br>It is ready to go wherever you go!
                    </small>
                </h2>
            </div>
            <div class="col-xl-6 ml-auto mr-auto">
                <div class="card p-4 rounded-plus bg-faded">
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

                    <form action="<?= url_to('register') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="form-group row">
                            <label class="col-xl-12 form-label" for="first_name">Your first and last name</label>
                            <div class="col-6 pr-1">
                                <input type="text" id="first_name" class="form-control" name="first_name" placeholder="First Name" value="<?= old('first_name') ?>" required>
                            </div>
                            <div class="col-6 pl-1">
                                <input type="text" id="last_name" class="form-control" name="last_name" placeholder="Last Name" value="<?= old('last_name') ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="mobile">Mobile</label>
                            <input id="mobile" type="tel" class="form-control" name="mobile" inputmode="text" placeholder="Mobile" value="<?= old('mobile') ?>" required />
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="email"><?= lang('Auth.email') ?></label>
                            <input id="email" type="email" class="form-control" name="email" inputmode="email" autocomplete="email" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>" required />
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="username"><?= lang('Auth.username') ?></label>
                            <input id="username" type="text" class="form-control" name="username" inputmode="text" autocomplete="username" placeholder="<?= lang('Auth.username') ?>" value="<?= old('username') ?>" required />
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="password"><?= lang('Auth.password') ?></label>
                            <input id="password" type="password" class="form-control" name="password" inputmode="text" autocomplete="new-password" placeholder="<?= lang('Auth.password') ?>" required />
                            <div class="help-block">Your password must be 8-20 characters long, contain letters and numbers, and must not contain spaces, special characters, or emoji.</div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="password_confirm"><?= lang('Auth.passwordConfirm') ?></label>
                            <input id="password_confirm" type="password" class="form-control" name="password_confirm" inputmode="text" autocomplete="new-password" placeholder="<?= lang('Auth.passwordConfirm') ?>" required />
                        </div>
                        <div class="row no-gutters">
                            <div class="col-md-4 ml-auto text-right">
                                <button type="submit" class="btn btn-block btn-danger btn-lg mt-3"><?= lang('Auth.register') ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="position-absolute pos-bottom pos-left pos-right p-3 text-center text-white">
        2020 © SmartAdmin by&nbsp;<a href='https://www.gotbootstrap.com' class='text-white opacity-40 fw-500' title='gotbootstrap.com' target='_blank'>gotbootstrap.com</a>
    </div>
</div>
<?= $this->endSection() ?>
