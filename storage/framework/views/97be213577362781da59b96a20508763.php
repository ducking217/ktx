<?php
    $soDonChoDuyet = isset($dangkychoxuly) ? (int) $dangkychoxuly : null;
    $soSuCoMo = isset($baohongchosua) ? (int) $baohongchosua : null;
    $soCongNo = isset($hoadonchuathanhtoan) ? (int) $hoadonchuathanhtoan : null;
    $soLienHeChoXuLy = isset($lienhechoxuly) ? (int) $lienhechoxuly : null;

    $tenNguoiDung = auth()->user()->name ?? 'Ban quản lý';
    $chuCaiDau = strtoupper(substr($tenNguoiDung, 0, 1));
?>

<aside
    id="admin-sidebar"
    class="fixed left-0 top-0 z-50 h-screen w-64 saas-sidebar--emerald border-r"
>
    <div class="flex h-full flex-col">
        <div class="px-6 py-8">
            <div class="flex items-center gap-3">
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-white/10 text-white ring-1 ring-white/10">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m4 0h1m-4 12h1m4 0h1m-4-4h1m4 0h1m-4-4h1m4 0h1"/></svg>
                </div>
                <div class="text-lg font-bold tracking-tight text-white">KTX <span class="text-brand-emerald">Quản trị</span></div>
            </div>
        </div>

        <nav class="flex-1 overflow-y-auto px-4 space-y-8 scrollbar-hide">
            <!-- Main Section -->
            <div>
                <div class="px-3 mb-2 text-[10px] font-semibold uppercase tracking-wider text-white/65">Hệ thống</div>
                <div class="space-y-1">
                    <a href="<?php echo e(route('admin.trangchu')); ?>" class="saas-sidebar-link <?php echo e(request()->routeIs('admin.trangchu') ? 'saas-sidebar-link-active' : ''); ?>">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Bảng điều khiển
                    </a>
                    <a href="<?php echo e(route('admin.activity-log')); ?>" class="saas-sidebar-link <?php echo e(request()->routeIs('admin.activity-log') ? 'saas-sidebar-link-active' : ''); ?>">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Nhật ký
                    </a>
                    <a href="<?php echo e(route('admin.cauhinh.index')); ?>" class="saas-sidebar-link <?php echo e(request()->routeIs('admin.cauhinh.*') ? 'saas-sidebar-link-active' : ''); ?>">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Cấu hình
                    </a>
                    <a href="<?php echo e(route('admin.accounts.index')); ?>" class="saas-sidebar-link <?php echo e(request()->routeIs('admin.accounts.*') ? 'saas-sidebar-link-active' : ''); ?>">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        Tài khoản
                    </a>
                </div>
            </div>

            <!-- Management Section -->
            <div>
                <div class="px-3 mb-2 text-[10px] font-semibold uppercase tracking-wider text-white/65">Vận hành</div>
                <div class="space-y-1">
                    <a href="<?php echo e(route('admin.toanha.index')); ?>" class="saas-sidebar-link <?php echo e(request()->routeIs('admin.toanha.*') ? 'saas-sidebar-link-active' : ''); ?>">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m4 0h1m-4 12h1m4 0h1m-4-4h1m4 0h1m-4-4h1m4 0h1"/></svg>
                        Tòa nhà
                    </a>
                    <a href="<?php echo e(route('admin.phong.index')); ?>" class="saas-sidebar-link <?php echo e(request()->routeIs('admin.phong.*') ? 'saas-sidebar-link-active' : ''); ?>">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m4 0h1m-4 12h1m4 0h1m-4-4h1m4 0h1m-4-4h1m4 0h1"/></svg>
                        Phòng & Tài sản
                    </a>
                    <a href="<?php echo e(route('admin.sinhvien.index')); ?>" class="saas-sidebar-link <?php echo e(request()->routeIs('admin.sinhvien.*') ? 'saas-sidebar-link-active' : ''); ?>">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        Sinh viên
                    </a>
                    <a href="<?php echo e(route('admin.dangky.index')); ?>" class="saas-sidebar-link <?php echo e(request()->routeIs('admin.dangky.*') ? 'saas-sidebar-link-active' : ''); ?>">
                        <div class="flex items-center gap-3">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <span>Đăng ký</span>
                        </div>
                        <?php if($soDonChoDuyet > 0): ?>
                            <span class="ml-auto flex h-4 w-4 items-center justify-center rounded-full bg-brand-emerald text-[10px] font-bold text-white"><?php echo e($soDonChoDuyet); ?></span>
                        <?php endif; ?>
                    </a>
                    <a href="<?php echo e(route('admin.hopdong.index')); ?>" class="saas-sidebar-link <?php echo e(request()->routeIs('admin.hopdong.*') ? 'saas-sidebar-link-active' : ''); ?>">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01m-.01 4h.01"/></svg>
                        Hợp đồng
                    </a>
                    <a href="<?php echo e(route('admin.giahan.index')); ?>" class="saas-sidebar-link <?php echo e(request()->routeIs('admin.giahan.*') ? 'saas-sidebar-link-active' : ''); ?>">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 0120 0z"/></svg>
                        Yêu cầu gia hạn
                    </a>
                    <a href="<?php echo e(route('admin.kyluat.index')); ?>" class="saas-sidebar-link <?php echo e(request()->routeIs('admin.kyluat.*') ? 'saas-sidebar-link-active' : ''); ?>">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/></svg>
                        Kỷ luật
                    </a>
                </div>
            </div>

            <!-- Finance Section -->
            <div>
                <div class="px-3 mb-2 text-[10px] font-semibold uppercase tracking-wider text-white/65">Tài chính</div>
                <div class="space-y-1">
                    <a href="<?php echo e(route('admin.hoadon.index')); ?>" class="saas-sidebar-link <?php echo e(request()->routeIs('admin.hoadon.*') ? 'saas-sidebar-link-active' : ''); ?>">
                        <div class="flex items-center gap-3">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                            <span>Hóa đơn</span>
                        </div>
                        <?php if($soCongNo > 0): ?>
                            <span class="ml-auto saas-badge saas-badge-warning"><?php echo e($soCongNo); ?></span>
                        <?php endif; ?>
                    </a>
                    <a href="<?php echo e(route('admin.baocao.taichinh')); ?>" class="saas-sidebar-link <?php echo e(request()->routeIs('admin.baocao.*') ? 'saas-sidebar-link-active' : ''); ?>">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6m4 6V7m4 10v-4M5 21h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                        Báo cáo tài chính
                    </a>
                </div>
            </div>

            <!-- Support Section -->
            <div>
                <div class="px-3 mb-2 text-[10px] font-semibold uppercase tracking-wider text-white/65">Hỗ trợ</div>
                <div class="space-y-1">
                    <a href="<?php echo e(route('admin.baohong.index')); ?>" class="saas-sidebar-link <?php echo e(request()->routeIs('admin.baohong.*') ? 'saas-sidebar-link-active' : ''); ?>">
                        <div class="flex items-center gap-3">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            <span>Báo hỏng</span>
                        </div>
                        <?php if($soSuCoMo > 0): ?>
                            <span class="ml-auto saas-badge saas-badge-error"><?php echo e($soSuCoMo); ?></span>
                        <?php endif; ?>
                    </a>
                    <a href="<?php echo e(route('admin.baotri.index')); ?>" class="saas-sidebar-link <?php echo e(request()->routeIs('admin.baotri.*') ? 'saas-sidebar-link-active' : ''); ?>">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Lịch bảo trì
                    </a>
                    <a href="<?php echo e(route('admin.lienhe.index')); ?>" class="saas-sidebar-link <?php echo e(request()->routeIs('admin.lienhe.*') ? 'saas-sidebar-link-active' : ''); ?>">
                        <div class="flex items-center gap-3">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span>Liên hệ</span>
                        </div>
                        <?php if($soLienHeChoXuLy > 0): ?>
                            <span class="ml-auto saas-badge saas-badge-warning"><?php echo e($soLienHeChoXuLy); ?></span>
                        <?php endif; ?>
                    </a>
                    <a href="<?php echo e(route('admin.thongbao.index')); ?>" class="saas-sidebar-link <?php echo e(request()->routeIs('admin.thongbao.*') ? 'saas-sidebar-link-active' : ''); ?>">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.4-1.4a2 2 0 0 1-.6-1.4V11a6 6 0 1 0-12 0v3.2a2 2 0 0 1-.6 1.4L4 17h5m6 0a3 3 0 0 1-6 0"/></svg>
                        Thông báo
                    </a>
                </div>
            </div>
        </nav>

        <div class="p-4 border-t border-white/10">
            <div class="flex items-center gap-3 p-2 rounded-lg bg-white/10 border border-white/10">
                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded bg-white/15 text-xs font-bold text-white ring-1 ring-white/10">
                    <?php echo e($chuCaiDau); ?>

                </div>
                <div class="min-w-0 flex-1">
                    <div class="truncate text-xs font-semibold text-white"><?php echo e($tenNguoiDung); ?></div>
                    <div class="text-[10px] text-white/50">Administrator</div>
                </div>
                <form action="<?php echo e(route('logout')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="text-white/60 hover:text-white">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</aside>
<?php /**PATH D:\laragon\www\hethongquanlyktxv1\resources\views/admin/partials/sidebar.blade.php ENDPATH**/ ?>