<!DOCTYPE html>
<html lang="vi">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>GoTravel | Thông báo</title>
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/style.css">
</head>
<body>
<?php include ROOT . "/includes/header.php"; ?>
<main class="page">
	<div class="container">
		<section class="card" style="text-align:center;">
			<h2>Cảm ơn bạn!</h2>
			<p><?php echo htmlentities($data["msg"]); ?></p>
			<div style="margin-top:1.5rem;">
				<a class="btn" href="<?php echo BASE_URL; ?>">Quay lại trang chủ</a>
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
