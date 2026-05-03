<?php

declare(strict_types=1);

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Collection;

class BaoCaoTaiChinhExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    public function __construct(
        private readonly array $data
    ) {}

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return new Collection($this->data);
    }

    public function headings(): array
    {
        return [
            'Tháng',
            'Năm',
            'Số hóa đơn',
            'Tổng doanh thu',
            'Trung bình/HĐ'
        ];
    }

    public function map($row): array
    {
        return [
            $row['thang'],
            $row['nam'],
            $row['so_luong'],
            number_format((float)$row['tong'], 0, ',', '.') . 'đ',
            number_format((float)$row['trung_binh'], 0, ',', '.') . 'đ',
        ];
    }
}
