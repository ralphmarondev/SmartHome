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
			<p class="text-muted">
				Monitor and control your smart home devices.
			</p>
		</div>

		<!-- Devices -->
		<div id="devicesContainer" class="row g-3 mb-4">
		</div>

		<!-- Status Message -->
		<div class="mb-3">
			<span id="statusMessage"></span>
		</div>

		<!-- Logs -->
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
	function getDeviceIcon(type) {
		switch (type) {
			case "LIGHT":
				return "💡";
			case "FAN":
				return "🌀";
			case "DOOR":
				return "🚪";
			default:
				return "🔌";
		}
	}

	function loadDevices() {
		$.ajax({
			url: "api/device_get_list.php",
			type: "GET",
			dataType: "json",
			success: function(devices) {
				let html = "";
				devices.forEach(function(device) {
					let statusText =
						device.type === "DOOR" ?
						(device.status == 1 ? "OPEN" : "CLOSED") :
						(device.status == 1 ? "ON" : "OFF");
					let badgeClass =
						device.status == 1 ?
						"bg-success" :
						"bg-secondary";
					html += `
										<div class="col-md-4">
												<div class="card shadow-sm border-0 h-100">
														<div class="card-body text-center">
																<div style="font-size:4rem">
																		${getDeviceIcon(device.type)}
																</div>
																<h4>${device.name}</h4>
																<span class="badge ${badgeClass} fs-6">
																		${statusText}
																</span>
																<div class="mt-3">
																		<button
																				class="btn btn-primary btn-device-toggle"
																				data-id="${device.id}"
																				data-status="${device.status}">
																				Toggle
																		</button>
																</div>
														</div>
												</div>
										</div>
								`;
				});
				$("#devicesContainer").html(html);
			},
			error: function() {
				$("#statusMessage").html(
					'<span class="text-danger">Failed to load devices.</span>'
				);
			}
		});
	}

	function loadLogs() {
		$.ajax({
			url: "api/log_read_list.php",
			type: "GET",
			dataType: "json",
			success: function(data) {
				let rows = "";
				if (data.length === 0) {
					rows = `
									<tr>
											<td colspan="2" class="text-center">
													No logs found
											</td>
									</tr>
							`;
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

	$(document).on(
		"click",
		".btn-device-toggle",
		function() {
			let deviceId = $(this).data("id");
			let currentStatus = $(this).data("status");
			let newStatus = currentStatus == 1 ? 0 : 1;

			$.ajax({
				url: "api/device_update.php",
				type: "POST",
				data: {
					device_id: deviceId,
					status: newStatus
				},
				success: function() {
					$("#statusMessage").html(
						'<span class="text-success">Device updated successfully.</span>'
					);
					loadDevices();
					loadLogs();
				},
				error: function() {
					$("#statusMessage").html(
						'<span class="text-danger">Failed to update device.</span>'
					);
				}
			});
		}
	);

	$(document).ready(function() {
		loadDevices();
		loadLogs();
	});
	</script>
</body>

</html>