<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thongbao extends Model
{
    use HasFactory;

    public const TYPE_GENERAL = 'general';
    public const TYPE_EMERGENCY = 'emergency';
    public const TYPE_MAINTENANCE = 'maintenance';
    public const TYPE_FINANCE = 'finance';
    public const TYPE_DISCIPLINE = 'discipline';
    public const TYPE_SYSTEM = 'system';

    public const TARGET_ALL = 'all';
    public const TARGET_GUEST = 'guest';
    public const TARGET_STUDENT = 'sinhvien';
    public const TARGET_ADMIN = 'admin';

    public const ALLOWED_TYPES = [
        self::TYPE_GENERAL,
        self::TYPE_EMERGENCY,
        self::TYPE_MAINTENANCE,
        self::TYPE_FINANCE,
        self::TYPE_DISCIPLINE,
        self::TYPE_SYSTEM,
    ];

    public const ALLOWED_TARGETS = [
        self::TARGET_ALL,
        self::TARGET_GUEST,
        self::TARGET_STUDENT,
        self::TARGET_ADMIN,
    ];

    protected $table = 'thongbao';

    protected $fillable = [
        'tieu_de',
        'noi_dung',
        'loai_thong_bao',
        'doi_tuong_nhan',
    ];

    protected $casts = [
        'doi_tuong_nhan' => 'string',
    ];
}
