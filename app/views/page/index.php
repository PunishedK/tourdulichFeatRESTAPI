<!DOCTYPE html>
<html lang="vi">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>GoTravel | <?php echo htmlentities($data["title"]); ?></title>
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/style.css">
</head>
<body>
<?php include ROOT . "/includes/header.php"; ?>
<main class="page">
	<div class="container">
		<section class="card">
			<h1><?php echo htmlentities($data["title"]); ?></h1>
			<?php if (!empty($data["content"])): ?>
				<div class="page-content"><?php echo $data["content"]; ?></div>
			<?php else: ?>
				<p>Chưa có nội dung cho trang này.</p>
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
