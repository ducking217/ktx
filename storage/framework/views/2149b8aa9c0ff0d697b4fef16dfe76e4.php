<?php
    $vaitro = auth()->user()->vaitro;
    $isAdmin = auth()->user()->isAdminGroup();
    $layout = $isAdmin ? 'admin-layout' : 'student-layout';
?>

<?php if (isset($component)) { $__componentOriginal511d4862ff04963c3c16115c05a86a9d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal511d4862ff04963c3c16115c05a86a9d = $attributes; } ?>
<?php $component = Illuminate\View\DynamicComponent::resolve(['component' => $layout] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('dynamic-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\DynamicComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('title', null, []); ?> Hồ sơ cá nhân <?php $__env->endSlot(); ?>

    <div class="space-y-8">
        <?php if(!$isAdmin): ?>
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Hồ sơ cá nhân</h1>
                <p class="text-sm font-medium text-slate-500 mt-1">Quản lý thông tin định danh, bảo mật và lịch sử lưu trú.</p>
            </div>
        <?php else: ?>
            <?php if (isset($component)) { $__componentOriginalcb19cb35a534439097b02b8af91726ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcb19cb35a534439097b02b8af91726ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.page-header','data' => ['title' => 'Hồ sơ cá nhân','subtitle' => 'Quản lý thông tin định danh, bảo mật và lịch sử lưu trú.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Hồ sơ cá nhân','subtitle' => 'Quản lý thông tin định danh, bảo mật và lịch sử lưu trú.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcb19cb35a534439097b02b8af91726ee)): ?>
<?php $attributes = $__attributesOriginalcb19cb35a534439097b02b8af91726ee; ?>
<?php unset($__attributesOriginalcb19cb35a534439097b02b8af91726ee); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcb19cb35a534439097b02b8af91726ee)): ?>
<?php $component = $__componentOriginalcb19cb35a534439097b02b8af91726ee; ?>
<?php unset($__componentOriginalcb19cb35a534439097b02b8af91726ee); ?>
<?php endif; ?>
        <?php endif; ?>

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-12">
            
            <div class="lg:col-span-8 space-y-8">
                
                <div class="saas-card p-6">
                    <?php echo $__env->make('profile.partials.update-profile-information-form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>

                <?php if(($user->vaitro === 'sinhvien' || $user->vaitro === \App\Enums\UserRole::SinhVien) && $sinhvien): ?>
                    
                    <div class="saas-card p-6 space-y-6">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                            <h2 class="text-lg font-bold text-slate-900 tracking-tight">Hồ sơ lưu trú</h2>
                        </div>

                        <div x-data="{ activeTab: 'contracts' }" class="space-y-4">
                            <div class="flex items-center gap-1.5 bg-slate-50 p-1.5 rounded-xl border border-slate-200 w-fit">
                                <button @click="activeTab = 'contracts'" :class="activeTab === 'contracts' ? 'bg-white text-slate-900 shadow-sm border border-slate-200' : 'text-slate-500 hover:text-slate-700'" class="px-5 py-2 rounded-lg text-[10px] font-bold uppercase tracking-widest transition-all">Hợp đồng</button>
                                <button @click="activeTab = 'discipline'" :class="activeTab === 'discipline' ? 'bg-white text-rose-600 shadow-sm border border-slate-200' : 'text-slate-500 hover:text-slate-700'" class="px-5 py-2 rounded-lg text-[10px] font-bold uppercase tracking-widest transition-all">Kỷ luật</button>
                                <button @click="activeTab = 'evaluations'" :class="activeTab === 'evaluations' ? 'bg-white text-emerald-600 shadow-sm border border-slate-200' : 'text-slate-500 hover:text-slate-700'" class="px-5 py-2 rounded-lg text-[10px] font-bold uppercase tracking-widest transition-all">Đánh giá</button>
                                <button @click="activeTab = 'bills'" :class="activeTab === 'bills' ? 'bg-white text-blue-600 shadow-sm border border-slate-200' : 'text-slate-500 hover:text-slate-700'" class="px-5 py-2 rounded-lg text-[10px] font-bold uppercase tracking-widest transition-all">Hóa đơn</button>
                            </div>

                            <div class="bg-white border border-slate-200 rounded-xl overflow-hidden min-h-[300px]">
                                
                                <div x-show="activeTab === 'contracts'">
                                    <table class="w-full text-left">
                                        <thead class="bg-slate-50 border-b border-slate-200">
                                            <tr>
                                                <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Mã HD</th>
                                                <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Phòng</th>
                                                <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Thời hạn</th>
                                                <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Trạng thái</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-100">
                                            <?php $__empty_1 = true; $__currentLoopData = $sinhvien->hopdongs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hopdong): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <tr class="hover:bg-slate-50/50 transition-colors">
                                                    <td class="px-6 py-4 text-xs font-bold text-slate-900 tabular-nums tracking-tight">#<?php echo e($hopdong->id); ?></td>
                                                    <td class="px-6 py-4 text-xs font-bold text-slate-900"><?php echo e($hopdong->phong?->ten_phong); ?></td>
                                                    <td class="px-6 py-4">
                                                        <div class="flex items-center gap-2 text-[10px] font-bold tabular-nums tracking-tight">
                                                            <span class="text-slate-500"><?php echo e($hopdong->ngay_bat_dau); ?></span>
                                                            <span class="text-blue-600"><?php echo e($hopdong->ngay_ket_thuc); ?></span>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <?php
                                                            $badgeClass = match($hopdong->trang_thai) {
                                                                \App\Enums\ContractStatus::Active => 'saas-badge-success',
                                                                \App\Enums\ContractStatus::Expired => 'saas-badge-warning',
                                                                \App\Enums\ContractStatus::Terminated => 'saas-badge-error',
                                                                default => 'saas-badge-info',
                                                            };
                                                        ?>
                                                        <span class="saas-badge <?php echo e($badgeClass); ?>">
                                                            <?php echo e($hopdong->trang_thai->label()); ?>

                                                        </span>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                <tr>
                                                    <td colspan="4" class="px-6 py-20 text-center">
                                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Không có dữ liệu hợp đồng</p>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>

                                
                                <div x-show="activeTab === 'discipline'" style="display: none;">
                                    <table class="w-full text-left">
                                        <thead class="bg-slate-50 border-b border-slate-200">
                                            <tr>
                                                <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Ngày vi phạm</th>
                                                <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Mức độ</th>
                                                <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Nội dung</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-100">
                                            <?php $__empty_1 = true; $__currentLoopData = $sinhvien->kyluats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kyluat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <tr class="hover:bg-slate-50/50 transition-colors">
                                                    <td class="px-6 py-4 text-xs font-bold text-slate-900 tabular-nums tracking-tight"><?php echo e($kyluat->ngay_vi_pham); ?></td>
                                                    <td class="px-6 py-4">
                                                        <?php
                                                            $mucDoValue = $kyluat->muc_do?->value ?? $kyluat->muc_do;
                                                            $badgeClass = match($mucDoValue) {
                                                                \App\Enums\DisciplineLevel::High->value => 'saas-badge-error',
                                                                \App\Enums\DisciplineLevel::Medium->value => 'saas-badge-warning',
                                                                default => 'saas-badge-info',
                                                            };
                                                        ?>
                                                        <span class="saas-badge <?php echo e($badgeClass); ?>">
                                                            <?php echo e($kyluat->muc_do?->label() ?? 'Bình thường'); ?>

                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 text-sm text-slate-600">
                                                        <?php echo e($kyluat->noi_dung); ?>

                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                <tr>
                                                    <td colspan="3" class="px-6 py-20 text-center">
                                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Chưa có vi phạm nào</p>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>

                                
                                <div x-show="activeTab === 'evaluations'" style="display: none;">
                                    <table class="w-full text-left">
                                        <thead class="bg-slate-50 border-b border-slate-200">
                                            <tr>
                                                <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Ngày</th>
                                                <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Điểm</th>
                                                <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Nội dung</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-100">
                                            <?php $__empty_1 = true; $__currentLoopData = $sinhvien->danhgias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $danhgia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <tr class="hover:bg-slate-50/50 transition-colors">
                                                    <td class="px-6 py-4 text-xs font-bold text-slate-900 tabular-nums tracking-tight"><?php echo e($danhgia->ngaydanhgia); ?></td>
                                                    <td class="px-6 py-4">
                                                        <div class="flex items-center gap-0.5 text-amber-400">
                                                            <?php for($i = 1; $i <= 5; $i++): ?>
                                                                <svg class="h-4 w-4 <?php echo e($i <= $danhgia->diem ? 'fill-current' : 'text-slate-200'); ?>" viewBox="0 0 20 20" fill="currentColor">
                                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                                </svg>
                                                            <?php endfor; ?>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 text-sm text-slate-600">
                                                        <?php echo e($danhgia->noidung); ?>

                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                <tr>
                                                    <td colspan="3" class="px-6 py-20 text-center">
                                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Chưa có đánh giá nào</p>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>

                                
                                <div x-show="activeTab === 'bills'" style="display: none;">
                                    <table class="w-full text-left">
                                        <thead class="bg-slate-50 border-b border-slate-200">
                                            <tr>
                                                <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Kỳ hóa đơn</th>
                                                <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Số tiền</th>
                                                <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Trạng thái</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-100">
                                            <?php $__empty_1 = true; $__currentLoopData = $hoadons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hoadon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <tr class="hover:bg-slate-50/50 transition-colors">
                                                    <?php
                                                        $ky = null;
                                                        if (is_string($hoadon->ghi_chu) && preg_match('/Ky\s+(\d{1,2}\/\d{4})/u', $hoadon->ghi_chu, $m)) {
                                                            $ky = $m[1];
                                                        }
                                                        $kyHienThi = $ky
                                                            ?? ($hoadon->ngay_thanh_toan?->format('m/Y') ?? $hoadon->created_at?->format('m/Y'))
                                                            ?? 'Chưa có';
                                                    ?>
                                                    <td class="px-6 py-4 text-xs font-bold text-slate-900 uppercase tracking-tight">Kỳ <?php echo e($kyHienThi); ?></td>
                                                    <td class="px-6 py-4 text-xs font-bold text-slate-900 tabular-nums tracking-tight"><?php echo e(number_format((int) $hoadon->tong_tien)); ?>đ</td>
                                                    <td class="px-6 py-4">
                                                        <?php
                                                            $billBadgeClass = match($hoadon->trang_thai) {
                                                                \App\Enums\InvoiceStatus::Paid => 'saas-badge-success',
                                                                \App\Enums\InvoiceStatus::Unpaid => 'saas-badge-warning',
                                                                \App\Enums\InvoiceStatus::Overdue => 'saas-badge-error',
                                                                default => 'saas-badge-info',
                                                            };
                                                        ?>
                                                        <span class="saas-badge <?php echo e($billBadgeClass); ?>">
                                                            <?php echo e($hoadon->trang_thai->label()); ?>

                                                        </span>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                <tr>
                                                    <td colspan="3" class="px-6 py-20 text-center">
                                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Không có lịch sử hóa đơn</p>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                
                
                <div class="saas-card p-6">
                    <?php echo $__env->make('profile.partials.update-password-form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>

            
            <aside class="lg:col-span-4 space-y-8">
                
                <?php if($user->sinhvien && ($phongHienTai || $user->sinhvien->phong)): ?>
                    <div class="saas-card p-6 border-dashed">
                        <h3 class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-6">Định danh lưu trú</h3>
                        
                        <div class="flex items-center gap-4 mb-6">
                            <div class="h-14 w-14 overflow-hidden rounded-xl bg-slate-100 border border-slate-200">
                                <?php
                                    $anhTheUrl = $user->sinhvien?->anh_the_path ? \App\Http\Controllers\Shared\FileController::generateSignedUrl($user->sinhvien->anh_the_path) : null;
                                ?>
                                <?php if($anhTheUrl): ?>
                                    <img src="<?php echo e($anhTheUrl); ?>" class="h-full w-full object-cover" />
                                <?php else: ?>
                                    <img src="https://ui-avatars.com/api/?name=<?php echo e(urlencode($user->name)); ?>&background=f1f5f9&color=0f172a&bold=true" class="h-full w-full object-cover" />
                                <?php endif; ?>
                            </div>
                            <div>
                                <div class="text-sm font-bold text-slate-900 leading-none"><?php echo e($phongHienTai?->ten_phong ?? $user->sinhvien->phong?->ten_phong ?? 'Chưa có'); ?></div>
                                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mt-1.5">Giường <?php echo e($giuongHienTai?->ma_giuong ?? $hopdongHienTai?->giuong?->ma_giuong ?? 'Chưa có'); ?></div>
                            </div>
                        </div>

                        <div class="space-y-3 pt-6 border-t border-slate-100">
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">MSSV</span>
                                <span class="text-xs font-bold text-slate-900 tabular-nums"><?php echo e($user->sinhvien->masinhvien); ?></span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Hợp đồng</span>
                                <span class="saas-badge <?php echo e($user->sinhvien->hopdongs->where('trang_thai', \App\Enums\ContractStatus::Active)->first() ? 'saas-badge-success' : 'saas-badge-error'); ?>">
                                    <?php echo e($user->sinhvien->hopdongs->where('trang_thai', \App\Enums\ContractStatus::Active)->first() ? 'Còn hiệu lực' : 'Không có'); ?>

                                </span>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                
                <div class="saas-card p-6">
                    <h3 class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-6">Trạng thái bảo mật</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] font-bold text-slate-600">Xác minh danh tính</span>
                            <span class="saas-badge saas-badge-success">Đã xác minh</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] font-bold text-slate-600">Bảo mật 2 lớp</span>
                            <span class="saas-badge saas-badge-info">Chưa kích hoạt</span>
                        </div>
                    </div>
                </div>

                
                <div class="saas-card p-6 border-rose-100 bg-rose-50/50">
                    <?php echo $__env->make('profile.partials.delete-user-form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </aside>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal511d4862ff04963c3c16115c05a86a9d)): ?>
<?php $attributes = $__attributesOriginal511d4862ff04963c3c16115c05a86a9d; ?>
<?php unset($__attributesOriginal511d4862ff04963c3c16115c05a86a9d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal511d4862ff04963c3c16115c05a86a9d)): ?>
<?php $component = $__componentOriginal511d4862ff04963c3c16115c05a86a9d; ?>
<?php unset($__componentOriginal511d4862ff04963c3c16115c05a86a9d); ?>
<?php endif; ?>
<?php /**PATH D:\laragon\www\hethongquanlyktxv1\resources\views/profile/edit.blade.php ENDPATH**/ ?>