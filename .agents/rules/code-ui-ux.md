---
trigger: always_on
---

đọc .gemini trước khi làm
- khi người dùng yêu cầu code giao diện cần đảm bảo: đọc folder .gemini để tìm hiểu các quy tắc code giao diện trong đó và áp dụng các quy tắc trong đó code giao diện.
- không được đụng đến code backend khi code giao diện. đảm bảo khi code giao diện xong backend vẫn hoạt động bình thường
-làm việc như một design thực thụ
- đọc memory-bank để hiểu thêm thông tin dự án 
- 1. Hãy suy nghĩ kỹ trước khi lập trình
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