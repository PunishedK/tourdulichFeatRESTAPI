<?php
$comments = [
    'Tour rất tuyệt, hướng dẫn viên nhiệt tình.',
    'Dịch vụ ổn, khách sạn đúng mô tả.',
    'Cảnh đẹp, lịch trình hợp lý.',
    'Tôi sẽ quay lại lần nữa!',
    'Giá hợp lý so với chất lượng.',
    'Xe đưa đón đúng giờ, ăn uống ngon.',
    'Một vài điểm chưa như mong đợi nhưng nhìn chung ổn.',
    'Phù hợp gia đình, trẻ em vui lắm.',
    'Thời tiết đẹp, chụp ảnh rất đã.',
    'Hơi vội ở một số điểm nhưng vẫn đáng đi.',
    'Đặt tour qua web rất tiện.',
    'Nhóm đông nhưng vẫn được tổ chức tốt.',
    'Ẩm thực địa phương rất ngon.',
    'View đẹp, phòng sạch sẽ.',
    'Chương trình văn hóa thú vị.',
    'Biển trong xanh, tắm rất thích.',
    'Resort sang, nhân viên chuyên nghiệp.',
    'Đường đi hơi xa nhưng xứng đáng.',
    'Chợ nổi rất đặc sắc.',
    'Homestay ấm cúng, chủ nhà thân thiện.',
];
$ratings = [5, 4, 5, 3, 4, 5, 4, 3, 5, 4, 5, 4, 3, 5, 4, 5, 3, 4, 5, 4];
$lines = [];
for ($t = 0; $t < 20; $t++) {
    $pkg = 201 + $t;
    for ($s = 0; $s < 3; $s++) {
        $un = (($t * 3 + $s) % 20) + 1;
        $email = sprintf('user%02d@gmail.com', $un);
        $idx = ($t * 3 + $s) % 20;
        $rating = $ratings[$idx];
        $note = str_replace("'", "''", $comments[$idx % count($comments)]);
        $lines[] = "($pkg, '$email', $rating, '$note')";
    }
}
echo implode(",\n", $lines);
