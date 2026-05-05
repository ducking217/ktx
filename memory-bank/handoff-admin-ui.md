# Handoff — Admin UI/UX (Impeccable-aligned)

## 1) Scope & Constraints
- Scope: UI layer (Blade + Tailwind + Alpine/Flowbite hiện có). Không thay đổi backend nghiệp vụ.
- Constraints hiện tại:
  - Repo chưa có Storybook/visual regression tooling.
  - Không thể xuất file Figma hoặc chạy usability test thực tế trong môi trường code. Tài liệu này cung cấp spec và template để đội thiết kế/QA thực hiện.

## 2) Style Guide (High-level)

### 2.1 Grid
- 8-pt grid cho spacing.
- Touch targets: tối thiểu 44px chiều cao cho button/input quan trọng.

### 2.2 Typography
- Sans (body/UI): Geist Sans
- Display (heading): Quicksand
- Type hierarchy:
  - Page title: 24–32px, font-black, tracking-tight, uppercase (admin)
  - Section title: 10–11px uppercase tracking-widest
  - Body: 12–14px

### 2.3 Color & Accessibility (WCAG 2.1 AA)
- Nền/card/border dùng tinted neutral (tránh #fff/#000 tuyệt đối).
- Contrast:
  - Text thường ≥ 4.5:1
  - Text lớn ≥ 3:1
- Icon-only:
  - Bắt buộc aria-label
  - Bắt buộc focus-visible ring rõ

### 2.4 Motion (60fps)
- Animate: opacity/transform, tránh layout animation.
- Duration: 200–320ms ease-out.

## 3) Design Tokens (Implementation)
- CSS variables: [app.css](file:///d:/laragon/www/hethongquanlyktxv1/resources/css/app.css#L7-L46)
- Tailwind mapping: [tailwind.config.js](file:///d:/laragon/www/hethongquanlyktxv1/tailwind.config.js#L15-L71)

## 4) Component Library (Atomic Design)

### Molecules
- PageHeader: [page-header.blade.php](file:///d:/laragon/www/hethongquanlyktxv1/resources/views/components/admin/page-header.blade.php)
- StatusTabs: [status-tabs.blade.php](file:///d:/laragon/www/hethongquanlyktxv1/resources/views/components/admin/status-tabs.blade.php)
- TableCard: [table-card.blade.php](file:///d:/laragon/www/hethongquanlyktxv1/resources/views/components/admin/table-card.blade.php)

### Naming (BEM)
- CSS lớp trừu tượng theo BEM: `adm-pageHeader__title`, `adm-tabs__item--active`…
- Định nghĩa lớp: [app.css](file:///d:/laragon/www/hethongquanlyktxv1/resources/css/app.css#L210-L249)

## 5) Redline Spec (Quy ước handoff Figma)
- Frame: Desktop 1440, Tablet 768, Mobile 375.
- Grid: 8px base, 12 columns (desktop), 4 columns (mobile).
- Spacing:
  - Page padding: 16 (mobile), 24 (tablet), 32 (desktop).
  - Card padding: 16–24 tùy mật độ dữ liệu.
- Table:
  - Header row: 10px uppercase tracking-widest.
  - Row height tối thiểu 48px.
- States:
  - Default / Hover / Active / Focus-visible / Disabled.

## 6) Usability Testing (Template)

### 6.1 Participants
- 5–7 người dùng: điều phối vận hành, kế toán, bảo trì (đại diện).

### 6.2 Tasks (đo completion rate + time)
1) Duyệt 1 hồ sơ Pending
2) Từ chối 1 hồ sơ
3) Xác nhận thanh toán 1 hồ sơ “Chờ đóng tiền”
4) Lọc báo hỏng theo trạng thái và cập nhật trạng thái 1 sự cố
5) Xuất Excel báo cáo tài chính theo năm

### 6.3 Metrics
- Completion rate ≥ 95%
- SUS ≥ 85
- Task time ≤ 80% baseline (giảm ≥ 20%)

### 6.4 SUS Form (copy-paste)
- 10 câu SUS chuẩn (1–5), tính điểm theo công thức SUS.

## 7) Accessibility Checklist
- Keyboard navigable: tab order hợp lý, không kẹt focus.
- Modal: role="dialog", aria-modal="true", Esc đóng, focus trap.
- Table: th có scope="col", caption (sr-only) khi cần.
- Icon-only button có aria-label.
- Contrast audit theo WCAG AA.

## 8) Performance Checklist (FCP < 2s mục tiêu)
- Tránh bundle nặng không cần thiết.
- Tránh inline script lặp lại cho mỗi render nếu có thể gom về app.js.
- Ưu tiên CSS utility + minimal DOM, tránh nested cards.

## 9) Impeccable Audit (QA Sign-off Template)
- Visual hierarchy rõ: 1 primary action / screen.
- Không dùng gradient text, không side-stripe border accent.
- Spacing theo 8-pt grid, không padding lộn xộn.
- Error/empty/loading states rõ ràng.
- A11y đạt baseline (mục 7).

