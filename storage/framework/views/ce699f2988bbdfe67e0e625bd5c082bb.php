<?php if (isset($component)) { $__componentOriginal91fdd17964e43374ae18c674f95cdaa3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal91fdd17964e43374ae18c674f95cdaa3 = $attributes; } ?>
<?php $component = App\View\Components\AdminLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\AdminLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('title', null, []); ?> Kiến trúc Nhập Chỉ số Hạ tầng Định kỳ <?php $__env->endSlot(); ?>

    <div class="space-y-10 pb-20">
        <?php if (isset($component)) { $__componentOriginalcb19cb35a534439097b02b8af91726ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcb19cb35a534439097b02b8af91726ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.page-header','data' => ['title' => 'Nhập chỉ số điện nước (hàng loạt)','subtitle' => 'Hệ thống kê khai chỉ số hạ tầng tập trung, tối ưu hóa quy trình kết xuất hóa đơn đa điểm cho toàn thể đơn vị cư trú.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Nhập chỉ số điện nước (hàng loạt)','subtitle' => 'Hệ thống kê khai chỉ số hạ tầng tập trung, tối ưu hóa quy trình kết xuất hóa đơn đa điểm cho toàn thể đơn vị cư trú.']); ?>
            <a href="<?php echo e(route('admin.hoadon.index')); ?>" class="saas-btn-secondary h-12 px-6 text-[10px] font-black uppercase tracking-[0.15em] border-slate-200">
                <svg class="h-4 w-4 mr-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Quay lại
            </a>
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

        <div x-data="{ 
            thang: <?php echo e($thangHienTai); ?>, 
            nam: <?php echo e($namHienTai); ?>,
            rooms: <?php echo e($danhsachphong->toJson()); ?>,
            isValid(room) {
                return room.chisodienmoi >= room.chisodien_cuoi && room.chisonuocmoi >= room.chisonuoc_cuoi;
            }
        }">
            <form action="<?php echo e(route('admin.hoadon.luu_hang_loat')); ?>" method="POST" class="space-y-10">
                <?php echo csrf_field(); ?>

                <div class="saas-card overflow-hidden shadow-2xl shadow-slate-200/40 border-slate-200/60 max-w-4xl">
                    <div class="bg-slate-50/50 border-b border-slate-200/60 px-10 py-5">
                        <h3 class="text-[11px] font-black uppercase tracking-[0.25em] text-slate-900 flex items-center gap-2.5">
                            <span class="h-1.5 w-1.5 rounded-full bg-brand-emerald"></span>
                            Tháng nhập chỉ số
                        </h3>
                    </div>
                    <div class="p-10 grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-3 ml-1">Tháng</label>
                            <select name="thang" x-model="thang" class="saas-input h-12 font-black tabular-nums bg-slate-50/30 border-slate-200/80 focus:bg-white transition-all">
                                <?php for($i = 1; $i <= 12; $i++): ?>
                                    <option value="<?php echo e($i); ?>">Tháng <?php echo e(str_pad($i, 2, '0', STR_PAD_LEFT)); ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-3 ml-1">Năm</label>
                            <select name="nam" x-model="nam" class="saas-input h-12 font-black tabular-nums bg-slate-50/30 border-slate-200/80 focus:bg-white transition-all">
                                <?php for($i = now()->year - 1; $i <= now()->year + 1; $i++): ?>
                                    <option value="<?php echo e($i); ?>">Năm <?php echo e($i); ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <?php if (isset($component)) { $__componentOriginaldf54224cf245156c316d9d3b07da8b50 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldf54224cf245156c316d9d3b07da8b50 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.table-card','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.table-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                    <thead>
                        <tr>
                            <th>Phòng</th>
                            <th class="text-center">Chỉ số điện (cũ → mới)</th>
                            <th class="text-center">Chỉ số nước (cũ → mới)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="room in rooms" :key="room.id">
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <td class="py-6">
                                    <div class="flex items-center gap-3">
                                        <div class="h-9 w-9 flex items-center justify-center rounded-xl bg-slate-50 text-slate-400 border border-slate-200/60 group-hover:bg-brand-emerald group-hover:text-white group-hover:border-brand-emerald transition-all">
                                            <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                        </div>
                                        <div class="text-[13px] font-black text-slate-900" x-text="room.ten_phong"></div>
                                    </div>
                                    <input type="hidden" :name="`hoa_don[${room.id}][phong_id]`" :value="room.id">
                                </td>
                                <td class="py-6">
                                    <div class="flex items-center justify-center gap-4 bg-white p-2 rounded-2xl border border-slate-200/60 shadow-sm max-w-[300px] mx-auto">
                                        <input type="number" :name="`hoa_don[${room.id}][chisodiencu]`" x-model.number="room.chisodien_cuoi" readonly class="w-20 bg-transparent border-none text-center text-[12px] font-black text-slate-300 tabular-nums focus:ring-0">
                                        <div class="h-6 w-px bg-slate-100"></div>
                                        <svg class="h-4 w-4 text-slate-200 group-hover:text-brand-emerald transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                                        <input type="number" :name="`hoa_don[${room.id}][chisodienmoi]`" x-model.number="room.chisodienmoi" required min="0"
                                            :class="room.chisodienmoi < room.chisodien_cuoi ? 'bg-rose-50 text-rose-600 border-rose-200' : 'bg-emerald-50/30 text-emerald-700 border-emerald-200/60'"
                                            class="w-24 h-10 rounded-xl border text-center text-[14px] font-black transition-all tabular-nums outline-none focus:ring-4 focus:ring-emerald-500/10">
                                    </div>
                                </td>
                                <td class="py-6">
                                    <div class="flex items-center justify-center gap-4 bg-white p-2 rounded-2xl border border-slate-200/60 shadow-sm max-w-[300px] mx-auto">
                                        <input type="number" :name="`hoa_don[${room.id}][chisonuoccu]`" x-model.number="room.chisonuoc_cuoi" readonly class="w-20 bg-transparent border-none text-center text-[12px] font-black text-slate-300 tabular-nums focus:ring-0">
                                        <div class="h-6 w-px bg-slate-100"></div>
                                        <svg class="h-4 w-4 text-slate-200 group-hover:text-cyan-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                                        <input type="number" :name="`hoa_don[${room.id}][chisonuocmoi]`" x-model.number="room.chisonuocmoi" required min="0"
                                            :class="room.chisonuocmoi < room.chisonuoc_cuoi ? 'bg-rose-50 text-rose-600 border-rose-200' : 'bg-cyan-50/30 text-cyan-600 border-cyan-200/60'"
                                            class="w-24 h-10 rounded-xl border text-center text-[14px] font-black transition-all tabular-nums outline-none focus:ring-4 focus:ring-cyan-500/10">
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldf54224cf245156c316d9d3b07da8b50)): ?>
<?php $attributes = $__attributesOriginaldf54224cf245156c316d9d3b07da8b50; ?>
<?php unset($__attributesOriginaldf54224cf245156c316d9d3b07da8b50); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldf54224cf245156c316d9d3b07da8b50)): ?>
<?php $component = $__componentOriginaldf54224cf245156c316d9d3b07da8b50; ?>
<?php unset($__componentOriginaldf54224cf245156c316d9d3b07da8b50); ?>
<?php endif; ?>

                <div class="flex items-center justify-between pt-10 border-t border-slate-100">
                    <div class="flex items-center gap-3 text-slate-400">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-[11px] font-bold uppercase tracking-tight italic">
                            Xác thực dữ liệu: Đảm bảo chỉ số cuối tháng ≥ chỉ số đầu tháng để hệ thống tính toán giá trị thực thi.
                        </p>
                    </div>
                    <div class="flex items-center gap-4">
                        <a href="<?php echo e(route('admin.hoadon.index')); ?>" class="saas-btn-secondary h-12 px-8 text-[10px] font-black uppercase tracking-widest border-slate-200">Hủy bỏ</a>
                        <button type="submit"
                            class="saas-btn-primary h-12 px-10 text-[10px] font-black uppercase tracking-widest shadow-xl shadow-emerald-500/20 disabled:opacity-40 disabled:cursor-not-allowed group"
                            :disabled="!rooms.every(r => isValid(r))">
                            <svg class="h-4 w-4 mr-2.5 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            Lưu <?php echo e(count($danhsachphong)); ?> chỉ số
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $attributes = $__attributesOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $component = $__componentOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?>
<?php /**PATH D:\laragon\www\hethongquanlyktxv1\resources\views/admin/hoadon/nhap-hang-loat.blade.php ENDPATH**/ ?>