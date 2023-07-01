<?= $this->extend('templates/main') ?>

<?= $this->section('title') ?>
Users
<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('/assets/css/datagrid/datatables/') ?>datatables.bundle.css">
<link rel="stylesheet" href="<?= base_url('/assets/css/notifications/sweetalert2/') ?>sweetalert2.bundle.css">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="col-xl-12">
    <div id="panel-1" class="panel">
        <div class="panel-hdr">
            <h2>
                Users <span class="fw-300"><i>List</i></span>
            </h2>
            <div class="panel-toolbar">
                <a href="<?= url_to('users.create') ?>" class="btn btn-primary btn-sm">Adicionar</a>
            </div>
        </div>
        <div class="panel-container show">
            <div class="panel-content">
                <!-- datatable start -->
                <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <!-- datatable end -->
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('/assets/js/datagrid/datatables/') ?>datatables.bundle.js"></script>
<script src="<?= base_url('/assets/js/notifications/sweetalert2/') ?>sweetalert2.bundle.js"></script>
<script>
    $(document).ready(() => {
        const dataTable = $('#dt-basic-example').dataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: '/api/users',
                dataSrc: 'data'
            },
            lengthMenu: [
                [10, 25, 50],
                [10, 25, 50]
            ],
            fnServerParams: data => data['order'].forEach((items, index) => {
                const column = data['columns'][items.column];
                data['order'][index]['column'] = column['data'] ?? column['name'];
            }),
            columns: [
                {data: 'id'},
                {data: 'first_name'},
                {data: 'last_name'},
                {data: 'username'},
                {data: 'email'},
                {
                    data: null,
                    orderable: false,
                    mRender: data => {
                        return `
                            <a href="/users/edit/${data.id}" class="btn btn-primary btn-sm">
                                <i class="fal fa-pencil"></i> Edit
                            </a>
                            <button type="button" data-id="${data.id}" class="btn btn-danger btn-sm btn-delete">
                                <i class="fal fa-trash"></i> Delete
                            </button>
                        `;
                    }
                }

            ]
        });

        $(document).on('click', '.btn-delete', function () {
            Swal.fire({
                icon: 'warning',
                title: 'Are you sure of delete this user?',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "Yes, I'm sure!",
                denyButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    const userId = $(this).data('id')

                    $.ajax({
                        url: `/api/users/${userId}`,
                        method: 'DELETE',
                        success: function (data) {
                            Swal.fire({
                                icon: 'success',
                                title: 'User has been deleted!',
                                timer: 2000,
                                timerProgressBar: true,
                            });

                            location.reload();
                        },
                        error: function (data) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Failed to delete the user!',
                                timer: 2000,
                                timerProgressBar: true,
                            });
                        }
                    });

                    return
                }

                if (result.isDenied) {
                    Swal.fire('Changes are not saved', '', 'info')
                }
            })
        })
    });
</script>
<?= $this->endSection() ?>

