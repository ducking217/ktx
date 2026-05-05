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
        Route::controller('PhongController')->group(function () {
            Route::get('/quanlyphong', 'index')->name('phong.index');
            Route::get('/sodophong', 'soDo')->name('phong.map');
            Route::post('/themphong', 'luu')->name('phong.luu');
            Route::post('/capnhatphong/{id}', 'capNhat')->name('phong.capnhat');
            Route::match(['post', 'delete'], '/xoaphong/{id}', 'xoa')->name('phong.xoa');
            Route::get('/quanlyphong/{id}', 'chiTiet')->name('phong.chitiet');
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
        Route::controller('SinhvienController')->group(function () {
            Route::get('/quanlysinhvien', 'lietKeSinhVien')->name('quanlysinhvien');
            Route::get('/quanlysinhvien/{id}', 'chiTiet')->name('sinhvien.chitiet');
            Route::post('/chuyenphong/{id}', 'chuyenPhong')->name('chuyenphong');
            Route::post('/choroiophong/{id}', 'choRoiOPhong')->name('choroiophong');
            Route::post('/capnhatsinhvien/{id}', 'capNhatSinhVien')->name('capnhatsinhvien');
        });

        // Quản lý Đăng ký (Registrations)
        Route::controller('DangkyController')->middleware('can:dangky.review')->group(function () {
            Route::get('/duyetdangky', 'lietKeDangKyAdmin')->name('duyetdangky');
            Route::post('/duyetdangky/{id}', 'duyetDangKy')->name('xulyduyetdangky');
            Route::post('/duyethoso/{id}', 'duyetHoSo')->name('duyethoso');
            Route::post('/xacnhanthanhtoan-dangky/{id}', 'xacNhanThanhToan')->name('dangky.xacnhanthanhtoan');
            Route::post('/tuchoidangky/{id}', 'tuChoiDangKy')->name('xulytuchoidangky');
            Route::post('/duyetdangky/{id}/traphong', 'xuLyTraPhong')->middleware('can:hopdong.manage')->name('dangky.traphong.xuly');
            Route::post('/duyetdangky/{id}/traphong/tuchoi', 'tuChoiTraPhong')->middleware('can:hopdong.manage')->name('dangky.traphong.tuchoi');
        });

        // Nhật ký hoạt động (Chỉ Super Admin)
        Route::get('/activity-log', [\App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('activity-log');

        // Quản lý Hóa đơn & Công nợ
        Route::controller('HoadonController')->middleware('can:hoadon.manage')->group(function () {
            Route::get('/quanlyhoadon', 'lietKeHoaDonAdmin')->name('quanlyhoadon');
            Route::post('/xulyhoadon', 'xuLyHoaDon')->name('xulyhoadon');
            Route::get('/dien-nuoc/nhap-hang-loat', 'giaoDienNhapHangLoat')->name('hoadon.nhap_hang_loat');
            Route::post('/dien-nuoc/luu-hang-loat', 'luuHangLoat')->name('hoadon.luu_hang_loat');
            Route::post('/nhap-hoadon-hang-loat', 'nhapHangLoat')->name('hoadon.bulk');
            Route::post('/hoadon/{id}/nhac-no', 'nhacNoHoaDon')->whereNumber('id')->name('hoadon.nhacno');
            Route::post('/xacnhanthanhtoan/{id}', 'xacNhanThanhToan')->name('xacnhanthanhtoan');
            Route::get('/hoadon/{id}/pdf', 'downloadInvoicePDF')->name('hoadon.pdf');
        });
        Route::get('/baocaocongno', function () {
            return redirect()->route('admin.quanlyhoadon', ['tab' => 'cong-no'], 301);
        })->name('baocaocongno');

        // Quản lý Bảo hỏng & Bảo trì
        Route::get('/quanlybaohong', 'BaohongController@lietKeBaoHongAdmin')->name('quanlybaohong');
        Route::post('/capnhatbaohong/{id}', 'BaohongController@capNhatBaoHong')->name('capnhatbaohong');
        Route::controller('LichsubaotriController')->group(function () {
            Route::get('/quanlybaotri', 'index')->name('quanlybaotri');
            Route::post('/thembaotri', 'store')->name('thembaotri');
            Route::post('/suabaotri/{id}', 'update')->name('suabaotri');
            Route::post('/xoabaotri/{id}', 'destroy')->name('xoabaotri');
            Route::post('/hoanthanhbaotri/{id}', 'hoanThanh')->name('hoanthanhbaotri');
        });
        Route::post('/vattu/{id}/baotri', 'LichsubaotriController@store')->name('vattu.baotri');

        // Quản lý Kỷ luật
        Route::controller('KyluatController')->middleware('can:kyluat.manage')->group(function () {
            Route::get('/quanlykyluat', 'lietKeKyLuatAdmin')->name('quanlykyluat');
            Route::post('/them/kyluat', 'storeDiscipline')->name('themkyluat');
            Route::post('/capnhat/kyluat/{id}', 'updateDiscipline')->name('capnhatkyluat');
            Route::delete('/xoa/kyluat/{id}', 'destroyDiscipline')->whereNumber('id')->name('xoakyluat');
        });

        // Đánh giá & Phản hồi (Disabled)

        // Cấu hình & Thông báo
        Route::get('/quanlycauhinh', 'CauhinhController@index')->middleware('can:cauhinh.manage')->name('quanlycauhinh');
        Route::post('/quanlycauhinh', 'CauhinhController@update')->middleware('can:cauhinh.manage')->name('capnhatcauhinh');
        
        Route::controller('ThongbaoController')->group(function () {
            Route::get('/quanlythongbao', 'index')->name('quanlythongbao');
            Route::post('/quanlythongbao', 'store')->name('themthongbao');
            Route::post('/quanlythongbao/xoa/{id}', 'destroy')->whereNumber('id')->name('xoathongbao');
            Route::post('/quanlythongbao/{id}', 'update')->whereNumber('id')->name('capnhatthongbao');
        });

        Route::get('/quanlylienhe', 'LienheController@index')->name('quanlylienhe');
        Route::post('/quanlylienhe/{id}/trangthai', 'LienheController@update')->whereNumber('id')->name('capnhattrangthailienhe');

        // Quản lý Hợp đồng
        Route::controller('HopdongController')->middleware('can:hopdong.manage')->group(function () {
            Route::get('/quanlyhopdong', 'index')->name('quanlyhopdong');
            Route::post('/taohopdong', 'store')->name('taohopdong');
            Route::post('/hopdong/{id}/giahan', 'extend')->name('hopdong.giahan');
            Route::post('/hopdong/{id}/thanhly', 'destroy')->name('hopdong.thanhly');
            Route::get('/hopdong/{id}/pdf', 'downloadPDF')->name('hopdong.pdf');
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
            Route::get('/hoadoncuaem', 'layHoaDonSinhVien')->name('hoadoncuaem');
            Route::get('/phongcuatoi/hoadon', 'layHoaDonSinhVien')->name('phongcuatoi.hoadon');
            Route::get('/phongcuatoi/hoadon/{id}', 'layChiTietHoaDonSinhVien')->name('phongcuatoi.hoadon.chitiet');
            Route::post('/phongcuatoi/hoadon/{id}/yeu-cau-xac-nhan', 'yeuCauXacNhanThanhToan')->name('phongcuatoi.hoadon.yeu_cau_xac_nhan');
            Route::post('/hoadon/{id}/xac-nhan-loi', 'xacNhanViPham')->name('hoadon.confirm_penalty');
        });

        // Đăng ký & Chuyển phòng
        Route::get('/danhsachphong', 'PhongController@index')->name('danhsachphong');
        Route::controller('DangkyController')->group(function () {
            Route::post('/dangkyphong', 'luuDangKySinhVien')->name('dangkyphong');
            Route::post('/yeucautraphong', 'yeuCauTraPhong')->name('yeucautraphong');
        });

        // Hợp đồng
        Route::get('/hopdongcuatoi', 'HopdongController@index')->name('hopdongcuatoi');

        // Gia hạn hợp đồng
        Route::controller('GiaHanController')->group(function () {
            Route::get('/gia-han', 'index')->name('giahan.index');
            Route::get('/gia-han/tao', 'create')->name('giahan.tao');
            Route::post('/gia-han', 'store')->name('giahan.store');
        });

        // Bảo hỏng & Tài sản
        Route::get('/baohong', 'BaohongController@lietKeBaoHongSinhVien')->name('danhsachbaohong');
        Route::post('/baohong', 'BaohongController@luuBaoHong')->name('thembaohong');
        Route::redirect('/taisanphong', '/student/phongcuatoi')->name('taisanphong');

        // Kỷ luật & Đánh giá
        Route::get('/kyluatcuaem', 'KyluatController@lietKeKyLuatSinhVien')->name('kyluatcuaem');
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

Route::get('/private-files/{path}', [FileController::class, 'showPrivateFile'])
    ->where('path', '.*')
    ->middleware(['auth'])
    ->name('private.file');

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
