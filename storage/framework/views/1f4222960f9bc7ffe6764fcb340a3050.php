<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu"><?php echo app('translator')->get('translation.Menu'); ?></li>

                <li>
                    <a href="/" class="waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span key="t-dashboards"><?php echo app('translator')->get('translation.Dashboards'); ?></span>
                    </a>
                </li>

                

                

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-data"></i>
                        <span>Data Master</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?php echo e(route('department.index')); ?>" class="waves-effect">
                                <i class='bx bxs-landmark'></i>
                                <span>Departement</span>
                            </a></li>
                        <li>
                            <a href="<?php echo e(route('barang.index')); ?>" class="waves-effect">
                                <i class="bx bx bx-box"></i>
                                <span>Barang</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="<?php echo e(route('permintaan.index')); ?>" class="waves-effect">
                        <i class='bx bx-git-pull-request'></i>
                        <span>Permintaan Barang</span>
                    </a>
                </li>


                
                

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
<?php /**PATH C:\laragon\www\TechnicalTest-SMM\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>