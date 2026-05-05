# Laravel Project Rules
- Framework: Laravel 11 (Artisan)
- Tools: @openspace (System), @impeccable (UI)
- Memory: Luôn đọc `memory-bank/` trước khi làm và cập nhật `progress.md` sau khi xong.
- Style: đọc STANDARDS.md trước khi làm.
1. Hãy suy nghĩ kỹ trước khi lập trình
Đừng vội phán đoán. Đừng che giấu sự bối rối. Hãy công khai những sự đánh đổi.

Trước khi thực hiện:

Hãy nêu rõ các giả định của bạn. Nếu không chắc chắn, hãy hỏi.
Nếu có nhiều cách hiểu khác nhau, hãy trình bày chúng - đừng im lặng lựa chọn.
Nếu có cách tiếp cận đơn giản hơn, hãy nói ra. Hãy phản đối khi cần thiết.
Nếu có điều gì không rõ ràng, hãy dừng lại. Nêu rõ điều gì gây khó hiểu. Hỏi.
2. Ưu tiên sự đơn giản
Đoạn mã tối thiểu giải quyết được vấn đề. Không mang tính suy đoán.

Không có tính năng nào khác ngoài những gì đã được yêu cầu.
Không có sự trừu tượng nào cho mã chỉ sử dụng một lần.
Không có sự "linh hoạt" hay "khả năng cấu hình" nào mà không được yêu cầu.
Không có cơ chế xử lý lỗi cho các tình huống bất khả thi.
Nếu bạn viết 200 dòng mà có thể rút gọn xuống 50 dòng, hãy viết lại.
Hãy tự hỏi: "Một kỹ sư cấp cao có cho rằng điều này quá phức tạp không?" Nếu có, hãy đơn giản hóa.

3. Những thay đổi do phẫu thuật
Chỉ chạm vào những thứ cần thiết. Chỉ dọn dẹp mớ hỗn độn do chính mình gây ra.

Khi chỉnh sửa mã hiện có:

Không nên "cải thiện" mã, chú thích hoặc định dạng liền kề.
Đừng chỉnh sửa lại những thứ vốn dĩ không bị lỗi.
Hãy tuân theo phong cách hiện có, ngay cả khi bạn muốn làm theo cách khác.
Nếu bạn phát hiện thấy đoạn mã chết không liên quan, hãy đề cập đến nó - đừng xóa nó.
Khi các thay đổi của bạn tạo ra các đối tượng mồ côi:

Xóa bỏ các phần nhập khẩu/biến/hàm mà những thay đổi CỦA BẠN đã khiến chúng không được sử dụng.
Không nên xóa mã nguồn cũ đã lỗi thời trừ khi được yêu cầu.
Bài kiểm tra: Mỗi dòng mã được thay đổi phải liên kết trực tiếp với yêu cầu của người dùng.

Follow the "Minimalist Tech Sophistication" style in DESIGN.md.
- Default to HIGH whitespace.
- Use soft shadows instead of harsh borders.
- Use Slate/Zinc color palettes.
- Ensure all tables and forms look like a "Modern SaaS Tool" (e.g., Linear, Vercel).
- If a UI looks too "busy", run internal /impeccable distill logic automatically.
<!-- 4. Thực thi theo định hướng mục tiêu
Xác định tiêu chí thành công. Lặp lại cho đến khi được xác minh.

Chuyển đổi nhiệm vụ thành mục tiêu có thể kiểm chứng:

"Thêm kiểm tra hợp lệ" → "Viết các bài kiểm tra cho các đầu vào không hợp lệ, sau đó làm cho chúng vượt qua"
"Sửa lỗi" → "Viết một bài kiểm tra để tái hiện lỗi đó, sau đó làm cho bài kiểm tra đó vượt qua"
"Tái cấu trúc X" → "Đảm bảo các bài kiểm tra đều đạt trước và sau khi tái cấu trúc"
Đối với các nhiệm vụ nhiều bước, hãy nêu kế hoạch ngắn gọn:

1. [Step] → verify: [check]
2. [Step] → verify: [check]
3. [Step] → verify: [check]
Tiêu chí thành công rõ ràng cho phép bạn thực hiện vòng lặp một cách độc lập. Tiêu chí yếu ("cứ làm cho nó hoạt động") đòi hỏi phải liên tục làm rõ. -->

