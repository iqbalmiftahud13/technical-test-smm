<?php $__env->startSection('title'); ?>
    Barang
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            Data Master
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            Barang
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="text-sm-end">
        <button type="button" data-bs-toggle="modal" data-bs-target="#barangModal"
            class="btn btn-success btn-rounded waves-effect waves-light addContact-modal mb-2">
            <i class="mdi mdi-plus me-1"></i> Tambah
        </button>
    </div>

    <div class="card px-3 py-3 shadow p-3 mb-5 bg-white rounded-4">
        <table class="table table-bordered" id="barang-datatable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Barang</th>
                    <th>Lokasi</th>
                    <th>Tersedia</th>
                    <th>Satuan</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="barangModal" tabindex="-1" aria-labelledby="barangModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="barangModalLabel">Tambah Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form autocomplete="off" class="needs-validation createContact-form" id="barang-form" novalidate>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="barang" class="form-label">Nama Barang</label>
                                    <input type="text" id="barang" name="barang" class="form-control"
                                        placeholder="Masukan Nama Barang" required />
                                    <div class="invalid-feedback">Kolom wajib diisi.</div>
                                </div>
                                <div class="mb-3">
                                    <label for="lokasi" class="form-label">Lokasi</label>
                                    <input type="text" id="lokasi" name="lokasi" class="form-control"
                                        placeholder="Masukan Lokasi" required />
                                    <div class="invalid-feedback">Kolom wajib diisi.</div>
                                </div>
                                <div class="mb-3">
                                    <label for="stok" class="form-label">Stok Tersedia</label>
                                    <input type="text" id="stok" name="stok" class="form-control"
                                        placeholder="Masukan Stok Tersedia" required />
                                    <div class="invalid-feedback">Kolom wajib diisi.</div>
                                </div>
                                <div class="mb-3">
                                    <label for="satuan" class="form-label">Satuan</label>
                                    <input type="text" id="satuan" name="satuan" class="form-control"
                                        placeholder="Masukan Satuan" required />
                                    <div class="invalid-feedback">Kolom wajib diisi.</div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="text-end">
                                    <button type="button" class="btn btn-outline-secondary"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" id="btnSubmit" class="btn btn-success">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- end modal body -->
            </div>
            <!-- end modal-content -->
        </div>
        <!-- end modal-dialog -->
    </div>
    <!-- end Modal -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript">
        $(function() {

            var table = $('#barang-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '<?php echo url()->current(); ?>',
                },
                columns: [{
                        data: null,
                        width: '5%',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'barang',
                        name: 'barang',
                    },
                    {
                        data: 'lokasi',
                        name: 'lokasi',
                    },
                    {
                        data: 'stok',
                        name: 'stok',
                    },
                    {
                        data: 'satuan',
                        name: 'satuan',
                    },
                    {
                        data: 'id',
                        render: renderAction,
                    },
                ]
            });

            function renderAction(data, type, row, meta) {
                let url = "<?php echo e(route('barang.destroy', ':id')); ?>"
                url = url.replace(':id', data)
                console.log(url)
                let btn =
                    `<button class="delete btn btn-danger btnDeleteDt btn-sm" data-url="${url}"><i class="fa fa-trash"></i></button>`
                return btn
            }
        });

        function handleCreateData() {
            $('button').prop('disabled', true)
            let btnText = $('#btnSubmit').html()
            $('#btnSubmit').html('<i class="fa fa-spinner fa-spin" ></i> Loading')

            let formData = new FormData($('#barang-form')[0])
            $.ajax({
                type: "POST",
                url: "<?php echo e(route('barang.store')); ?>",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(res) {
                    $('#barangModal').modal('hide')
                    $('#btnSubmit').html(btnText)
                    $('#barang-form')[0].reset()
                    $('#barang-datatable').DataTable().ajax.reload()
                    $('button').prop('disabled', false)
                },
                error: function(err) {
                    $('#btnSubmit').html(btnText)
                    $('button').prop('disabled', false)
                }
            });
        }
        $('#barang-form').submit(function(e) {
            console.log('here');
            e.preventDefault()
            handleCreateData()
        })
        // var vue = new Vue({
        //     el: '#vue'
        // })
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\TechnicalTest-SMM\resources\views/admin/pages/barang/index.blade.php ENDPATH**/ ?>