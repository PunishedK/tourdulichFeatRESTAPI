<!DOCTYPE html>
<html lang="vi">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>GoTravel | Đổi mật khẩu</title>
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/style.css">
	<script>
	function valid(){
		const newPass = document.chngpwd.newpassword.value;
		const confirmPass = document.chngpwd.confirmpassword.value;
		if(newPass !== confirmPass){
			alert("Mật khẩu mới và xác nhận mật khẩu không trùng khớp!");
			document.chngpwd.confirmpassword.focus();
			return false;
		}
		return true;
	}
	</script>
</head>
<body>
<?php include ROOT . "/includes/header.php"; ?>
<main class="page">
	<div class="container">
		<section class="page-head">
			<h1>Đổi mật khẩu</h1>
			<p>Giữ an toàn tài khoản bằng cách thay đổi mật khẩu định kỳ.</p>
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
			<form name="chngpwd" method="post" onSubmit="return valid();" class="form-stack" action="<?php echo BASE_URL; ?>user/updatePassword">
				<div class="form-group">
					<label for="current-password">Mật khẩu hiện tại</label>
					<input type="password" name="password" id="current-password" required>
				</div>
				<div class="form-grid">
					<div class="form-group">
						<label for="newpassword">Mật khẩu mới</label>
						<input type="password" name="newpassword" id="newpassword" required>
					</div>
					<div class="form-group">
						<label for="confirmpassword">Xác nhận mật khẩu</label>
						<input type="password" name="confirmpassword" id="confirmpassword" required>
					</div>
				</div>
				<button type="submit" name="submit5" class="btn">Cập nhật</button>
			</form>
		</section>
	</div>
</main>
<?php include ROOT . "/includes/footer.php"; ?>
<?php include ROOT . "/includes/signup.php"; ?>
<?php include ROOT . "/includes/signin.php"; ?>
<?php include ROOT . "/includes/write-us.php"; ?>
</body>
</html>
