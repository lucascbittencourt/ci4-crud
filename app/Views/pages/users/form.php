<?= $this->extend('templates/main') ?>

<?php
$actionType = empty($user) ? 'Add' : 'Edit';
$method = empty($user) ? 'POST' : 'PUT';
$url = empty($user) ? url_to('api.users.store') : url_to('api.users.update', $user['id']);
?>

<?= $this->section('title') ?>
Users
<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('/assets/css/notifications/sweetalert2/') ?>sweetalert2.bundle.css">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="col-xl-12">
    <div id="panel-1" class="panel">
        <div class="panel-hdr">
            <h2>
                <?= $actionType ?> User
            </h2>
        </div>
        <div class="panel-container show">
            <div class="panel-content">
                <div class="panel-tag">
                    Be sure to use an appropriate type attribute on all inputs (e.g., code <code>email</code> for email
                    address or <code>number</code> for numerical information) to take advantage of newer input controls
                    like email verification, number selection, and more.
                </div>
                <form id="user-form">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="form-label" for="first_name">First Name</label>
                            <input type="text" id="first_name" class="form-control"
                                   value="<?= $user['first_name'] ?? '' ?>">
                            <div id="first_name_error" class="invalid-feedback hide"></div>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="form-label" for="last_name">Last Name</label>
                            <input type="text" id="last_name" class="form-control"
                                   value="<?= $user['last_name'] ?? '' ?>">
                            <div id="last_name_error" class="invalid-feedback hide"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="mobile">Mobile</label>
                        <input type="text" id="mobile" class="form-control" value="<?= $user['mobile'] ?? '' ?>">
                        <div id="mobile_error" class="invalid-feedback hide"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="username">Username</label>
                        <input type="text" id="username" class="form-control" value="<?= $user['username'] ?? '' ?>">
                        <div id="username_error" class="invalid-feedback hide"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="email">Email</label>
                        <input type="email" id="email" class="form-control" value="<?= $user['email'] ?? '' ?>">
                        <div id="email_error" class="invalid-feedback hide"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="password">Password</label>
                        <input type="password" id="password" class="form-control">
                        <div id="password_error" class="invalid-feedback hide"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="password_confirm">Confirm Password</label>
                        <input type="password" id="password_confirm" class="form-control">
                        <div id="password_confirm_error" class="invalid-feedback hide"></div>
                    </div>
                    <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0">
                        <div class="row">
                            <div class="col-md-6">
                                <button type="button" id="confirm-btn"
                                        class="btn btn-block btn-primary ml-auto waves-effect waves-themed"><?= $actionType ?></button>
                            </div>
                            <div class="col-md-6">
                                <a class="btn btn-block btn-danger ml-auto waves-effect waves-themed"
                                   href="<?= url_to('users.index') ?>">Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('/assets/js/notifications/sweetalert2/') ?>sweetalert2.bundle.js"></script>
<script>
    $(document).ready(() => {
        $('#confirm-btn').click(function () {
            $.ajax({
                url: '<?= $url ?>',
                method: 'POST',
                data: {
                    first_name: $('#first_name').val(),
                    last_name: $('#last_name').val(),
                    mobile: $('#mobile').val(),
                    username: $('#username').val(),
                    email: $('#email').val(),
                    password: $('#password').val(),
                    password_confirm: $('#password_confirm').val(),
                    _method: '<?= $method ?>'
                },
                success: data => {
                    Swal.fire({
                        icon: 'success',
                        timer: 2000,
                        timerProgressBar: true,
                    }).then(_ => window.location = '/users');
                },
                error: data => {
                    const errors = data?.responseJSON?.errors

                    for (const error in errors) {
                        $(`#${error}`).addClass('is-invalid');
                        $(`#${error}_error`).text(errors[error]).show();
                    }
                }
            });
        })

    })
</script>
<?= $this->endSection() ?>
