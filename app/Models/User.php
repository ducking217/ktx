<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Gender;
use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'vaitro',
        'is_active',
        'toa_nha_id',
        'phone',
        'phone_blind_index',
        'id_card',
        'id_card_blind_index',
        'gender',
        'dob',
        'address',
        'ethnicity',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'phone',
        'id_card',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
        'vaitro' => UserRole::class,
        'gender' => Gender::class,
        'dob' => 'date',
        'toa_nha_id' => 'integer',
    ];

    public function toanha()
    {
        return $this->belongsTo(ToaNha::class, 'toa_nha_id');
    }

    public function sinhvien()
    {
        return $this->hasOne(Sinhvien::class, 'user_id');
    }

    public function admin_profile()
    {
        return $this->hasOne(Admin::class, 'user_id');
    }

    public function isAdmin(): bool
    {
        return $this->vaitro === UserRole::Admin;
    }

    /**
     * Kiểm tra xem user có thuộc nhóm quản trị (để quyết định Layout hiển thị)
     */
    public function isAdminGroup(): bool
    {
        return $this->vaitro?->isAdminGroup() ?? false;
    }

    /**
     * Kiểm tra xem user có là sinh viên
     */
    public function isStudent(): bool
    {
        return $this->vaitro === UserRole::SinhVien;
    }

    /**
     * Kiểm tra xem user có là sinh viên (alias cho isStudent)
     */
    public function isSinhVien(): bool
    {
        return $this->isStudent();
    }

    /**
     * Kiểm tra xem user có là khách
     */
    public function isGuest(): bool
    {
        return $this->vaitro === UserRole::Guest;
    }

    /**
     * Lấy label của vai trò hiện tại
     */
    public function getRoleLabel(): string
    {
        return $this->vaitro?->label() ?? 'Không xác định';
    }

    /**
     * Kiểm tra xem user có bất kỳ vai trò nào trong danh sách
     */
    public function hasAnyRole(array $roles): bool
    {
        $vaitroValue = $this->vaitro instanceof UserRole ? $this->vaitro->value : $this->vaitro;
        
        return collect($roles)->map(fn($r) => $r instanceof UserRole ? $r->value : $r)
            ->contains($vaitroValue);
    }
}
