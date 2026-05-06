<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Giao thức Shared Controllers
use App\Http\Controllers\Shared\FileController;
use App\Http\Controllers\Shared\ProfileController;

// --------------------------------------------------------------------------
// 1. GUEST / PUBLIC ROUTES
// --------------------------------------------------------------------------
Route::namespace('App\Http\Controllers\Guest')->group(function () {
    Route::get('/', 'LandingController@index')->name('home');
    Route::post('/lien-he', 'LandingController@guiLienHe')->middleware('throttle:guest_submit')->name('landing.lienhe');

    // Guest Registration & Lookup
    Route::prefix('dang-ky-ktx')->name('guest.dangky.')->group(function () {
        Route::get('/', 'DangkyController@create')->name('create');
        Route::post('/', 'DangkyController@store')->middleware('throttle:guest_submit')->name('store');
    });
    Route::get('/tra-cuu-don/{token?}', 'DangkyController@lookup')->middleware('throttle:guest_lookup')->name('guest.lookup');

    // Magic Link Login
    Route::get('/magic-link-login/{user_id}', [\App\Http\Controllers\Auth\MagicLinkController::class, 'login'])
        ->name('magic-link.login')
        ->middleware('signed');

    // Public Room Info
    Route::prefix('phong')->name('public.')->group(function () {
        Route::get('/', 'PhongController@index')->name('danhsachphong');
        Route::get('/{id}/vattu', 'PhongController@assets')->name('chitietvattu');
    });
});

// --------------------------------------------------------------------------
// 2. ADMIN ROUTES
// --------------------------------------------------------------------------
Route::prefix('admin')
    ->middleware(['auth', 'kiemtravaitro:admin'])
    ->namespace('App\Http\Controllers\Admin')
    ->name('admin.')
    ->group(function () {
        
        Route::get('/trangchu', 'TrangchuController@index')->name('trangchu');

        // Quản lý tòa nhà
        Route::prefix('toa-nha')->controller('ToaNhaController')->group(function () {
            Route::get('/', 'index')->name('toanha.index');
            Route::get('/them', 'taoMoi')->name('toanha.tao');
            Route::post('/them', 'luu')->name('toanha.luu');
            Route::get('/{id}', 'chiTiet')->name('toanha.chitiet');
            Route::put('/{id}', 'capNhat')->name('toanha.capnhat');
            Route::delete('/{id}', 'xoa')->name('toanha.xoa');
        });

        // Quản lý Phòng & Sơ đồ
        Route::prefix('phong')->name('phong.')->controller('PhongController')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/so-do', 'soDo')->name('map');
            Route::post('/', 'luu')->name('store');
            Route::put('/{id}', 'capNhat')->name('update');
            Route::delete('/{id}', 'xoa')->name('destroy');
            Route::get('/{id}', 'chiTiet')->name('chitiet');
        });

        // Quản lý Tài sản
        Route::prefix('taisan')->controller('TaiSanController')->group(function () {
            Route::post('/them/{id}', 'luu')->name('taisan.them');
            Route::post('/them-hang-loat/{id}', 'luuHangLoat')->name('taisan.them_hang_loat');
            Route::post('/gan-hang-loat', 'ganHangLoat')->name('taisan.gan_hang_loat');
            Route::post('/cap-nhat/{id}/{taisanId}', 'capNhat')->name('taisan.capnhat');
            Route::post('/cap-nhat-hang-loat/{id}', 'capNhatHangLoat')->name('taisan.capnhat_hang_loat');
            Route::post('/xoa/{id}/{taisanId}', 'xoa')->name('taisan.xoa');
        });

        // Quản lý Vật tư
        Route::prefix('vattu')->controller('VatTuController')->group(function () {
            Route::post('/them/{id}', 'luu')->name('vattu.them');
            Route::post('/cap-nhat/{id}/{vattuId}', 'capNhat')->name('vattu.capnhat');
            Route::post('/xoa/{id}/{vattuId}', 'xoa')->name('vattu.xoa');
        });

        // Quản lý Sinh viên
        Route::prefix('sinh-vien')->name('sinhvien.')->controller('SinhvienController')->group(function () {
            Route::get('/', 'lietKeSinhVien')->name('index');
            Route::get('/{id}', 'chiTiet')->name('chitiet');
            Route::post('/{id}/chuyen-phong', 'chuyenPhong')->name('chuyenphong');
            Route::post('/{id}/cho-roi-o-phong', 'choRoiOPhong')->name('choroiophong');
            Route::post('/{id}', 'capNhatSinhVien')->name('capnhat');
        });

        // Quản lý Đăng ký (Registrations)
        Route::prefix('dang-ky')->name('dangky.')->controller('DangkyController')->middleware('can:dangky.review')->group(function () {
            Route::get('/', 'lietKeDangKyAdmin')->name('index');
            Route::post('/{id}/duyet', 'duyetDangKy')->name('duyet');
            Route::post('/{id}/duyet-ho-so', 'duyetHoSo')->name('duyethoso');
            Route::post('/{id}/xac-nhan-thanh-toan', 'xacNhanThanhToan')->name('xacnhanthanhtoan');
            Route::post('/{id}/tu-choi', 'tuChoiDangKy')->name('tuchoi');
            Route::post('/{id}/tra-phong', 'xuLyTraPhong')->middleware('can:hopdong.manage')->name('traphong.xuly');
            Route::post('/{id}/tra-phong/tu-choi', 'tuChoiTraPhong')->middleware('can:hopdong.manage')->name('traphong.tuchoi');
        });

        // Nhật ký hoạt động (Chỉ Super Admin)
        Route::get('/activity-log', [\App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('activity-log');

        // Quản lý Hóa đơn & Công nợ
        Route::prefix('hoa-don')->name('hoadon.')->controller('HoadonController')->middleware('can:hoadon.manage')->group(function () {
            Route::get('/', 'lietKeHoaDonAdmin')->name('index');
            Route::post('/', 'xuLyHoaDon')->name('tao_thang');
            Route::get('/dien-nuoc/nhap-hang-loat', 'giaoDienNhapHangLoat')->name('nhap_hang_loat');
            Route::post('/dien-nuoc/luu-hang-loat', 'luuHangLoat')->name('luu_hang_loat');
            Route::post('/{id}/nhac-no', 'nhacNoHoaDon')->whereNumber('id')->name('nhacno');
            Route::post('/{id}/xac-nhan', 'xacNhanThanhToan')->whereNumber('id')->name('xacnhan');
            Route::get('/{id}/pdf', 'downloadInvoicePDF')->whereNumber('id')->name('pdf');
        });

        // Quản lý Bảo hỏng & Bảo trì
        Route::prefix('bao-hong')->name('baohong.')->controller('BaohongController')->group(function () {
            Route::get('/', 'lietKeBaoHongAdmin')->name('index');
            Route::post('/{id}', 'capNhatBaoHong')->name('capnhat');
        });
        Route::prefix('bao-tri')->name('baotri.')->controller('LichsubaotriController')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/xuat-excel', 'xuatExcel')->name('xuat_excel');
            Route::post('/', 'store')->name('store');
            Route::post('/{id}', 'update')->name('capnhat');
            Route::post('/{id}/xoa', 'destroy')->name('xoa');
            Route::post('/{id}/hoan-thanh', 'hoanThanh')->name('hoanthanh');
        });
        Route::post('/vattu/{id}/baotri', 'LichsubaotriController@store')->name('vattu.baotri');

        // Quản lý Kỷ luật
        Route::prefix('ky-luat')->name('kyluat.')->controller('KyluatController')->middleware('can:kyluat.manage')->group(function () {
            Route::get('/', 'lietKeKyLuatAdmin')->name('index');
            Route::post('/', 'storeDiscipline')->name('store');
            Route::post('/{id}', 'updateDiscipline')->whereNumber('id')->name('capnhat');
            Route::delete('/{id}', 'destroyDiscipline')->whereNumber('id')->name('xoa');
        });

        // Đánh giá & Phản hồi (Disabled)

        // Cấu hình & Thông báo
        Route::prefix('cau-hinh')->name('cauhinh.')->controller('CauhinhController')->middleware('can:cauhinh.manage')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'update')->name('capnhat');
        });
        
        Route::prefix('thong-bao')->name('thongbao.')->controller('ThongbaoController')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::post('/{id}', 'update')->whereNumber('id')->name('capnhat');
            Route::delete('/{id}', 'destroy')->whereNumber('id')->name('xoa');
        });

        Route::prefix('lien-he')->name('lienhe.')->controller('LienheController')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/{id}/trangthai', 'update')->whereNumber('id')->name('capnhattrangthai');
        });

        // Quản lý Hợp đồng
        Route::prefix('hop-dong')->name('hopdong.')->controller('HopdongController')->middleware('can:hopdong.manage')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::get('/{id}', 'show')->whereNumber('id')->name('show');
            Route::post('/{id}/gia-han', 'extend')->whereNumber('id')->name('giahan');
            Route::post('/{id}/thanh-ly', 'destroy')->whereNumber('id')->name('thanhly');
            Route::get('/{id}/pdf', 'downloadPDF')->whereNumber('id')->name('pdf');
        });

        // Yêu cầu gia hạn hợp đồng
        Route::controller('GiaHanController')->middleware('can:hopdong.manage')->group(function () {
            Route::get('/gia-han', 'index')->name('giahan.index');
            Route::post('/gia-han/{id}/duyet', 'duyet')->name('giahan.duyet');
            Route::post('/gia-han/{id}/tu-choi', 'tuChoi')->name('giahan.tuchoi');
        });

        // Báo cáo & Thống kê
        Route::prefix('bao-cao')->name('baocao.')->group(function () {
            Route::get('/tai-chinh', [App\Http\Controllers\Admin\BaoCaoController::class, 'taiChinh'])->name('taichinh');
            Route::get('/xuat-excel', [App\Http\Controllers\Admin\BaoCaoController::class, 'xuatExcel'])->name('xuat_excel');
        });

        // Quản lý tài khoản (Super Admin only)
        Route::prefix('accounts')->name('accounts.')->middleware('can:accounts.manage')->controller(App\Http\Controllers\Admin\AccountController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/tao', 'taoMoi')->name('tao');
            Route::post('/', 'luu')->name('luu');
            Route::get('/{id}/sua', 'sua')->name('sua');
            Route::put('/{id}', 'capNhat')->name('capnhat');
            Route::delete('/{id}', 'xoa')->name('xoa');
            Route::post('/{id}/restore', 'khoiPhuc')->name('restore');
        });
    });

// --------------------------------------------------------------------------
// 3. STUDENT ROUTES
// --------------------------------------------------------------------------
Route::prefix('student')
    ->middleware(['auth', 'kiemtravaitro:sinhvien'])
    ->namespace('App\Http\Controllers\Student')
    ->name('student.')
    ->group(function () {
        
        Route::get('/trangchu', 'TrangchuController@index')->name('trangchu');

        // Phòng của tôi & Hóa đơn
        Route::get('/phongcuatoi', 'PhongCuaToiController@index')->name('phongcuatoi');
        Route::controller('HoadonController')->group(function () {
            Route::get('/hoadon', 'layHoaDonSinhVien')->name('hoadon.index');
            Route::get('/hoadon/{id}', 'layChiTietHoaDonSinhVien')->whereNumber('id')->name('hoadon.chitiet');
            Route::post('/hoadon/{id}/yeu-cau-xac-nhan', 'yeuCauXacNhanThanhToan')->whereNumber('id')->name('hoadon.yeu_cau_xac_nhan');
            Route::post('/hoadon/{id}/xac-nhan-loi', 'xacNhanViPham')->name('hoadon.confirm_penalty');
        });

        // Đăng ký & Chuyển phòng
        Route::get('/phong', 'PhongController@index')->name('phong.index');
        Route::controller('DangkyController')->group(function () {
            Route::post('/dangkyphong', 'luuDangKySinhVien')->name('dangkyphong');
            Route::post('/yeucautraphong', 'yeuCauTraPhong')->name('yeucautraphong');
        });

        // Hợp đồng
        Route::get('/hopdong', 'HopdongController@index')->name('hopdong.index');

        // Gia hạn hợp đồng
        Route::controller('GiaHanController')->group(function () {
            Route::post('/gia-han', 'store')->name('giahan.store');
        });

        // Bảo hỏng & Tài sản
        Route::get('/baohong', 'BaohongController@lietKeBaoHongSinhVien')->name('danhsachbaohong');
        Route::post('/baohong', 'BaohongController@luuBaoHong')->name('thembaohong');
        Route::patch('/baohong/{id}', 'BaohongController@capNhatBaoHong')->whereNumber('id')->name('baohong.update');
        Route::redirect('/taisanphong', '/student/phongcuatoi')->name('taisanphong');

        // Kỷ luật & Đánh giá
        Route::get('/kyluat', 'KyluatController@lietKeKyLuatSinhVien')->name('kyluat.index');
        Route::match(['get', 'post'], '/danhgia', function () {
            return redirect()->route('student.phongcuatoi');
        })->name('danhgia');

        // Thông báo
        Route::controller('ThongbaoController')->group(function () {
            Route::get('/thongbao', 'index')->name('thongbao');
            Route::get('/thongbao/{id}', 'show')->name('chitietthongbao');
            Route::patch('/thongbao', function () {
                auth()->user()->unreadNotifications->markAsRead();
                return back()->with('success', 'Đã đánh dấu tất cả là đã đọc.');
            })->name('thongbao.markAllRead');
        });
    });

Route::prefix('sinhvien')
    ->middleware(['auth', 'kiemtravaitro:sinhvien'])
    ->group(function () {
        Route::any('{path?}', function (Request $request, ?string $path = null) {
            $targetPath = '/student'.($path ? '/'.ltrim($path, '/') : '');
            $targetUrl = $targetPath.($request->getQueryString() ? '?'.$request->getQueryString() : '');

            $status = $request->isMethod('get') || $request->isMethod('head') ? 301 : 308;

            return redirect()->to($targetUrl, $status);
        })->where('path', '.*');
    });

// --------------------------------------------------------------------------
// 4. SHARED & AUTH ROUTES
// --------------------------------------------------------------------------
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/private-files', [FileController::class, 'showPrivateFile'])
    ->middleware(['auth'])
    ->name('private.file');

Route::get('/private-files/{path}', [FileController::class, 'showPrivateFile'])
    ->where('path', '.*')
    ->middleware(['auth']);

// Trạm điều hướng trung gian
Route::get('/dieuhuong', function () {
    /** @var \App\Models\User $user */
    $user = Auth::user();
    if ($user && $user->isAdminGroup()) {
        return redirect()->route('admin.trangchu');
    }
    return redirect()->route('student.trangchu');
})->middleware(['auth'])->name('dieuhuong');

Route::get('/dashboard', function () {
    return redirect()->route('dieuhuong');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
