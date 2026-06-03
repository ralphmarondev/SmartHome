<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Smart Home Dashboard</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
	<div class="container py-4">
		<div class="mb-4">
			<h1 class="fw-bold">🏠 Smart Home Dashboard</h1>
			<p class="text-muted">Monitor and control your smart home devices.</p>
		</div>

		<div class="row g-3 mb-4">
			<div class="col-md-4">
				<div class="card shadow-sm border-0 h-100">
					<div class="card-body text-center">
						<div style="font-size: 4rem;">💡</div>
						<h4>Light</h4>
						<span id="lightStatus" class="badge bg-secondary fs-6">
							OFF
						</span>
						<div class="mt-3">
							<button id="btnLight" class="btn btn-warning">
								Toggle Light
							</button>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-4">
				<div class="card shadow-sm border-0 h-100">
					<div class="card-body text-center">
						<div style="font-size: 4rem;">🌀</div>
						<h4>Fan</h4>
						<span id="fanStatus" class="badge bg-secondary fs-6">
							OFF
						</span>
						<div class="mt-3">
							<button id="btnFan" class="btn btn-info">
								Toggle Fan
							</button>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-4">
				<div class="card shadow-sm border-0 h-100">
					<div class="card-body text-center">
						<div style="font-size: 4rem;">🚪</div>
						<h4>Door</h4>
						<span id="doorStatus" class="badge bg-secondary fs-6">
							CLOSED
						</span>
						<div class="mt-3">
							<button id="btnDoor" class="btn btn-success">
								Toggle Door
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="mb-3">
			<span id="statusMessage"></span>
		</div>

		<div class="card shadow-sm border-0">
			<div class="card-body">
				<h4 class="mb-3">📋 Activity Logs</h4>
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<thead class="table-dark">
							<tr>
								<th width="200">Timestamp</th>
								<th>Message</th>
							</tr>
						</thead>
						<tbody id="logsTable">
							<tr>
								<td colspan="2" class="text-center">
									No logs found
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
	<script>
	let lightOn = false;
	let fanOn = false;
	let doorOpen = false;

	function saveLog(message) {
		$.ajax({
			url: "api/create.php",
			type: "POST",
			data: {
				message: message
			},
			success: function() {
				$("#statusMessage")
					.html('<span class="text-success">Action saved successfully.</span>');
				loadLogs();
			},
			error: function() {
				$("#statusMessage")
					.html('<span class="text-danger">Failed to save action.</span>');
			}
		});
	}

	function loadLogs() {
		$.ajax({
			url: "api/read_list.php",
			type: "GET",
			dataType: "json",
			success: function(data) {
				let rows = "";
				if (data.length === 0) {
					rows = `<tr>
											<td colspan="2" class="text-center">
													No logs found
											</td>
									</tr>`;
				} else {
					data.forEach(function(log) {
						rows += `
										<tr>
												<td>${log.created_at}</td>
												<td>${log.message}</td>
										</tr>
								`;
					});
				}
				$("#logsTable").html(rows);
			}
		});
	}

	$(document).ready(function() {
		loadLogs();
		$("#btnLight").click(function() {
			lightOn = !lightOn;

			if (lightOn) {
				$("#lightStatus")
					.removeClass("bg-secondary")
					.addClass("bg-warning text-dark")
					.text("ON");
				saveLog("Light turned ON");
			} else {
				$("#lightStatus")
					.removeClass("bg-warning text-dark")
					.addClass("bg-secondary")
					.text("OFF");
				saveLog("Light turned OFF");
			}
		});

		$("#btnFan").click(function() {
			fanOn = !fanOn;

			if (fanOn) {
				$("#fanStatus")
					.removeClass("bg-secondary")
					.addClass("bg-info")
					.text("ON");
				saveLog("Fan turned ON");
			} else {
				$("#fanStatus")
					.removeClass("bg-info")
					.addClass("bg-secondary")
					.text("OFF");
				saveLog("Fan turned OFF");
			}
		});

		$("#btnDoor").click(function() {
			doorOpen = !doorOpen;

			if (doorOpen) {
				$("#doorStatus")
					.removeClass("bg-secondary")
					.addClass("bg-success")
					.text("OPEN");
				saveLog("Door opened");
			} else {
				$("#doorStatus")
					.removeClass("bg-success")
					.addClass("bg-secondary")
					.text("CLOSED");
				saveLog("Door closed");
			}
		});
	});
	</script>
</body>

</html>