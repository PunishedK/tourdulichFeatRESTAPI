<!DOCTYPE html>
<html lang="vi">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>GoTravel | Hồ sơ của tôi</title>
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/style.css">
</head>
<body>
<?php include ROOT . "/includes/header.php"; ?>
<main class="page">
	<div class="container">
		<section class="page-head">
			<h1>Thông tin tài khoản</h1>
			<p>Cập nhật họ tên, số điện thoại và xem email đang sử dụng.</p>
		</section>
		<?php if (
      $data["error"]
  ) { ?><div class="alert error"><strong>Lỗi:</strong> <?php echo htmlentities(
    $data["error"],
); ?></div><?php } elseif (
      $data["msg"]
  ) { ?><div class="alert success"><strong>Thành công:</strong> <?php echo htmlentities(
    $data["msg"],
); ?></div><?php } ?>
		<section class="card">
		<?php if ($data["user"]): ?>
			<form name="profile" method="post" class="form-stack" action="<?php echo BASE_URL; ?>user/updateProfile">
				<div class="form-group">
					<label for="name">Họ và tên</label>
					<input type="text" name="name" id="name" value="<?php echo htmlentities(
         $data["user"]->FullName,
     ); ?>" required>
				</div>
				<div class="form-group">
					<label for="mobileno">Số điện thoại</label>
					<input type="text" name="mobileno" id="mobileno" maxlength="10" value="<?php echo htmlentities(
         $data["user"]->MobileNumber,
     ); ?>" required>
				</div>
				<div class="form-group">
					<label>Email</label>
					<input type="email" value="<?php echo htmlentities(
         $data["user"]->EmailId,
     ); ?>" disabled>
				</div>
				<div class="form-group">
					<label>Ngày đăng ký</label>
					<input type="text" value="<?php echo htmlentities(
         $data["user"]->RegDate,
     ); ?>" disabled>
				</div>
				<?php if ($data["user"]->UpdationDate) { ?>
				<div class="form-group">
					<label>Ngày cập nhật</label>
					<input type="text" value="<?php echo htmlentities(
         $data["user"]->UpdationDate,
     ); ?>" disabled>
				</div>
				<?php } ?>
				<button type="submit" name="submit" class="btn">Lưu thay đổi</button>
			</form>
		<?php endif; ?>
		</section>
	</div>
</main>
<?php include ROOT . "/includes/footer.php"; ?>
<?php include ROOT . "/includes/signup.php"; ?>
<?php include ROOT . "/includes/signin.php"; ?>
<?php include ROOT . "/includes/write-us.php"; ?>
</body>
</html>
