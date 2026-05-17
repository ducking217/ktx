# [OPEN] Debug Session: admin-navigation-lag

## Symptom
- Khi nhấn chuyển trang / thao tác trong Admin: load chậm, đôi lúc phải nhấn 2 lần mới chuyển được.

## Expected
- Click 1 lần là phản hồi ngay (điều hướng hoặc submit), có loading state rõ ràng, không bị “nuốt” click.

## Hypotheses (falsifiable)
1) Click bị chặn bởi lớp overlay/loader (pointer-events) hoặc element phủ lên link, khiến lần click đầu không tới target.
2) Có JS handler (Alpine/vanilla) gọi `preventDefault()` rồi không điều hướng do race-condition, cần click lần 2.
3) Có double-binding listeners (gắn nhiều lần khi re-render), lần 1 set disabled/loading nhưng request không gửi; lần 2 mới gửi.
4) Request backend phản hồi chậm (N+1/slow query/IO), UI không có feedback nên người dùng bấm lại.
5) Có lỗi JS runtime (exception) xảy ra khi click, khiến handler dừng giữa chừng.

## Evidence to collect
- Client: event click/submit captured, target, defaultPrevented, disabled state, overlay hit-test, navigation timing.
- Server: request route, method, status, duration, slow threshold.

## Plan
1) Instrument client-side click/submit + navigation timing, gửi log về debug server.
2) Reproduce: bấm chuyển trang 5–10 lần + 1 thao tác submit chậm, thu log.
3) Phân tích log để chốt nguyên nhân.
4) Fix tối thiểu theo evidence, rồi so sánh pre-fix/post-fix.

