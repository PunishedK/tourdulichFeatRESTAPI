<!DOCTYPE html>
<html lang="vi">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>GoTravel | Yêu cầu hỗ trợ</title>
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/style.css">
</head>
<body>
<?php include ROOT . "/includes/header.php"; ?>
<main class="page">
	<div class="container">
		<section class="page-head">
			<h1>Yêu cầu đã gửi</h1>
			<p>Theo dõi trạng thái phản hồi từ đội GoTravel.</p>
		</section>
		<?php if ($data["error"]) { ?><div class="alert error"><?php echo htmlentities(
    $data["error"],
); ?></div><?php } ?>
		<?php if ($data["msg"]) { ?><div class="alert success"><?php echo htmlentities(
    $data["msg"],
); ?></div><?php } ?>
		<section class="card">
			<div class="table-responsive">
				<table class="table">
					<thead>
						<tr>
							<th>#</th>
							<th>Mã vé</th>
							<th>Vấn đề</th>
							<th>Mô tả</th>
							<th>Ghi chú quản trị</th>
							<th>Ngày tạo</th>
							<th>Ngày cập nhật</th>
						</tr>
					</thead>
					<tbody>
					<?php
     $cnt = 1;
     if (count($data["issues"]) > 0):
         foreach ($data["issues"] as $result): ?>
						<tr>
							<td><?php echo htmlentities($cnt); ?></td>
							<td>#TKT-<?php echo htmlentities($result->id); ?></td>
							<td><?php echo htmlentities($result->Issue); ?></td>
							<td><?php echo htmlentities($result->Description); ?></td>
							<td><?php echo $result->AdminRemark
           ? htmlentities($result->AdminRemark)
           : "Chưa có phản hồi"; ?></td>
							<td><?php echo htmlentities($result->PostingDate); ?></td>
							<td><?php echo htmlentities($result->AdminremarkDate); ?></td>
						</tr>
						<?php $cnt++;endforeach;
     else:
          ?>
						<tr><td colspan="7"><div class="empty-state">Bạn chưa gửi yêu cầu nào.</div></td></tr>
					<?php
     endif;
     ?>
					</tbody>
				</table>
			</div>
		</section>
	</div>
</main>
<?php include ROOT . "/includes/footer.php"; ?>
<?php include ROOT . "/includes/signup.php"; ?>
<?php include ROOT . "/includes/signin.php"; ?>
<?php include ROOT . "/includes/write-us.php"; ?>
</body>
</html>
