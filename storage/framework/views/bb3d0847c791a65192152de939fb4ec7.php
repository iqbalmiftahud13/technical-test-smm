<!-- deleteDepartment -->
<div class="modal fade" id="modalDelete" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <form method="POST" action="#" id="formModalDelete">
                <?php echo csrf_field(); ?>
                <?php echo method_field('delete'); ?>
                <div class="modal-body px-4 py-5 text-center">
                    <button type="button" class="btn-close position-absolute end-0 top-0 m-3" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                    <div class="avatar-sm mb-4 mx-auto">
                        <div class="avatar-title bg-primary text-primary bg-opacity-10 font-size-20 rounded-3">
                            <i class="mdi mdi-trash-can-outline"></i>
                        </div>
                    </div>
                    <p class="text-muted font-size-16 mb-4">Apakah Anda yakin menghapus data ?</p>

                    <div class="hstack gap-2 justify-content-center mb-0">
                        <button type="submit" class="btn text-danger fw-bolder" id="remove-item">Ya, Hapus !</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\TechnicalTest-SMM\resources\views/components/modal-delete.blade.php ENDPATH**/ ?>