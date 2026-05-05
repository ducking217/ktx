---
register: product
product: "Hệ Thống Quản Lý KTX (Admin)"
version: 1
---

# Product

## Register

product

## Users

Hệ thống phục vụ nhóm người dùng nội bộ KTX trong bối cảnh vận hành hàng ngày, ưu tiên tốc độ thao tác, đọc bảng số liệu, và tính truy vết.

- Điều phối vận hành: duyệt hồ sơ, điều phối phòng/giường, theo dõi trạng thái theo thời gian thực.
- Kế toán nội bộ: phát hành hóa đơn, xác nhận thanh toán, theo dõi công nợ, xuất báo cáo.
- Kỹ thuật/Bảo trì: tiếp nhận báo hỏng, cập nhật trạng thái xử lý, quản lý lịch bảo trì.
- Quản trị hệ thống: quản lý tài khoản/role, cấu hình hệ thống, kiểm toán hoạt động.

## Product Purpose

Số hóa vận hành ký túc xá với trọng tâm:

- Chuẩn hóa quy trình (đăng ký, hợp đồng, hóa đơn, công nợ, bảo trì, kỷ luật, thông báo).
- Giảm thời gian xử lý tác vụ lặp lại bằng bảng lọc rõ, thao tác hàng loạt, và luồng phê duyệt ít bước.
- Tăng độ tin cậy thông tin bằng trạng thái nhất quán và lịch sử thao tác (audit trail).

## Brand Personality

- 3 từ khóa: Ngăn nắp, đáng tin cậy, chuyên nghiệp.
- Giọng điệu: rõ ràng, trực diện, hành chính chuẩn mực; tránh “startup” hoặc ngôn ngữ phóng đại.

## Anti-references

- Thẩm mỹ “startup”: màu quá rực, gradient phô, hiệu ứng bay bổng, copy marketing.
- Bóng đổ nặng và card quá mềm; ưu tiên đường viền mảnh + nhịp spacing ổn định.
- Bo góc lớn (trên 8px) làm giao diện “đồ chơi”.
- Trang bị lạm dụng modal; ưu tiên inline/progressive disclosure.
- Side-stripe border accent (border-left/border-right dày để nhấn).

## Design Principles

- Auditability over ornament: thao tác phải truy vết, trạng thái phải nhất quán.
- Dense but scannable: dày thông tin nhưng dễ quét mắt; tiêu đề, cột, nhãn phải phân cấp rõ.
- Table-first workflows: bảng + filter/sort là hạ tầng cốt lõi, không phải “phụ kiện”.
- One primary action per screen: mỗi màn hình chỉ có 1 hành động chính nổi bật, còn lại ở mức phụ trợ.
- Confirm with context: xác nhận nêu rõ hậu quả và dữ liệu liên quan; hạn chế thao tác không đảo ngược.

## Accessibility & Inclusion

- Mục tiêu: WCAG 2.1 AA.
- Keyboard-first baseline: tab order hợp lý, focus-visible rõ, modal có focus trap và Esc đóng.
- Reduced motion: tôn trọng reduced-motion, chỉ animate opacity/transform.
- Color-blind safe semantics: trạng thái không dựa vào màu đơn độc; luôn có nhãn/badge.
