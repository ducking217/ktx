<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $sinhvien_id
 * @property string $noidung
 * @property \Illuminate\Support\Carbon|string $ngayvipham
 * @property \App\Enums\DisciplineLevel $mucdo
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Sinhvien $sinhvien
 */
class Kyluat extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kyluat';

    protected $fillable = [
        'sinhvien_id',
        'noidung',
        'ngayvipham',
        'mucdo',
    ];

    protected $casts = [
        'ngayvipham' => 'date',
        'mucdo' => \App\Enums\DisciplineLevel::class,
    ];

    public function sinhvien(): BelongsTo
    {
        return $this->belongsTo(Sinhvien::class, 'sinhvien_id');
    }
}
