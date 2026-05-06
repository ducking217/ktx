# Design System: KTX Phương Đông (Product + Brand)

## Register
Primary: product (Student portal + Admin dashboard)
Secondary: brand (Landing)

## Visual Theme
- Default theme: light, sáng rõ, dễ đọc ở môi trường vận hành ban ngày.
- Neutrals: Slate/Zinc tint nhẹ, tránh #000/#fff.
- Accent: Emerald/Jade theo OKLCH tokens sẵn có trong dự án.

## Typography
- Headings / brand moments: Quicksand.
- Body / UI dense: Geist Sans.
- Số liệu: dùng tabular-nums để canh hàng cột ổn định.

## Layout & Density
- Whitespace theo nhịp 4/8/16/24/32/48/64px, ưu tiên “thoáng nhưng không loãng”.
- Tránh card lồng card. Nếu cần phân tách, ưu tiên table-card hoặc section divider mảnh.
- Progressive disclosure: thông tin phụ đưa vào hàng mở rộng, tooltip, hoặc trang chi tiết.

## Color & Semantics
- Brand: emerald/jade (dùng sparingly, ưu tiên cho CTA chính và trạng thái thành công).
- Status: success/warning/error/info luôn đi kèm nhãn, không phụ thuộc màu.
- Bảng dữ liệu: dùng micro-borders mờ và hover state nhẹ để tăng khả năng quét mắt.

## Components Baseline
- Buttons: 1 primary action mỗi màn hình; secondary/ghost cho hành động phụ.
- Forms: label rõ nghĩa, helper text ngắn; lỗi hiển thị theo field + tổng quan.
- Tables: header rõ, spacing đủ chạm; mobile dùng card-list có nhãn từng trường.
- Badges: compact, nhất quán label/màu trên Admin và Student.
- Empty states: 1 câu mô tả, 1 CTA (nếu có), không dùng copy marketing dài.

## Motion
- Reduced motion: tôn trọng prefers-reduced-motion.
- Không bounce/elastic.
- Chỉ animate opacity/transform, easing ease-out (quart/quint).

## Hard Avoids
- Inter font, purple gradients, gradient text.
- Side-stripe border accent (border-left/border-right dày để nhấn).
- Identical card grids và hero-metric template.
