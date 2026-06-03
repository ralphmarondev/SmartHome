<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Smart Home</title>
	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
	<div class="container mt-5">
		<h1 id="title">Smart Home Dashboard</h1>
		<button id="btnTest" class="btn btn-primary">
			Click Me
		</button>
	</div>

	<!-- jQuery -->
	<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

	<!-- Bootstrap JS Bundle -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

	<!-- Your Script -->
	<script>
		$(document).ready(function() {
			$("#btnTest").click(function() {
				$.ajax({
					url: "api/create.php",
					type: "POST",
					success: function(response) {
						$("#title").text("Saved to database!");
						console.log(response);
					},
					error: function() {
						$("#title").text("Error saving data!");
					}
				})
			});
		});
	</script>

</body>

</html>