<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TblLog extends Model
{
    protected $table = 'tbl_logs';

    protected $fillable = [
        'user_id',
        'hanh_dong',
        'ten_model',
        'id_ban_ghi',
        'du_lieu_cu',
        'du_lieu_moi',
    ];

    protected $casts = [
        'du_lieu_cu' => 'array',
        'du_lieu_moi' => 'array',
    ];

    /**
     * Lấy thông tin người dùng thực hiện hành động.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
