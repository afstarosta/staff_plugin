<?php

function staff_plugin_admin_page_html() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	?>

	<head>
		<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
	</head>
	<style>
		table {
			border: 1px solid black;
			width: 100%;
			border-collapse: collapse;
		}
	</style>
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

		<table id='members_table' border=1>
			<tr>
				<td><b>Name </b></td>
				<td><b>Position </b></td>
				<td><b>Hire Date </b></td>
				<td><b>Birth Date </b></td>
				<td></td>
			</tr>
		</table>
		<br />
		<h1>Register new member </h1>
		<table id='input_table'>
			<tr>
				<td>
					<label for="first_name">First name:</label>
					<input type="text" id="first_name" name="first_name"><br><br>
				</td>
				<td>
					<label for="last_name">Last name:</label>
					<input type="text" id="last_name" name="last_name"><br><br>
				</td>
				<td>
					<label for="position">Position:</label>
					<input type="text" id="position" name="position"><br><br>
				</td>
				<td>
					<label for="birth_date">Birth Date</label>
					<input type="date" id="birth_date" name="birth_date"><br><br>
				</td>
				<td>
					<label for="hire_date">Hire Date:</label>
					<input type="date" id="hire_date" name="hire_date"><br><br>
				</td>
				<td>
					<a onclick="register_member()">Register</a>
				</td>
			</tr>
		</table>

		<script>
			$.ajax({
				url: '<?php echo esc_url_raw( rest_url() ); ?>' + 'staff_plugin/staff_member',
				method: 'GET',
				beforeSend: function(xhr) {
					xhr.setRequestHeader('X-WP-Nonce', '<?php echo wp_create_nonce( 'wp_rest' ); ?>');
				},
				success: function(response) {
					render_member_list(response.result);
				}
			});

			function render_member_list(member_list) {
				member_list.forEach(
					(member) => {
						render_member(member)
					}
				);
			}

			function render_member(member) {
				let rowHTML = `
					<tr>
						<td> ${member.first_name + ' ' + member.last_name} </td>
						<td> ${member.position} </td>
						<td> ${member.birth_date} </td>
						<td> ${member.hire_date} </td>
						<td> <a onclick="delete_member(${member.id})" > Delete </a> </td>
					</tr>
				`;
				$("#members_table tbody").append(rowHTML)
			}

			function delete_member(member_id) {
				let payload = {
					staff_member_id: member_id
				};

				$.ajax({
					url: '<?php echo esc_url_raw( rest_url() ); ?>' + 'staff_plugin/staff_member',
					method: 'DELETE',
					beforeSend: function(xhr) {
						xhr.setRequestHeader('X-WP-Nonce', '<?php echo wp_create_nonce( 'wp_rest' ); ?>');
					},
					dataType: "json",
					contentType: "application/json",
					data: JSON.stringify(payload),
					success: function(response) {
						location.reload();
					},
					error: function(response) {
						alert('Error deleting Member');
					}
				});
			}

			function register_member() {
				let payload = {
					first_name: $("#first_name").val(),
					last_name: $("#last_name").val(),
					position: $("#position").val(),
					birth_date: $("#birth_date").val(),
					hire_date: $("#hire_date").val(),
				};

				$.ajax({
					url: '<?php echo esc_url_raw( rest_url() ); ?>' + 'staff_plugin/staff_member',
					method: 'POST',
					beforeSend: function(xhr) {
						xhr.setRequestHeader('X-WP-Nonce', '<?php echo wp_create_nonce( 'wp_rest' ); ?>');
					},
					dataType: "json",
					contentType: "application/json",
					data: JSON.stringify(payload),
					success: function(response) {
						location.reload();
					},
					error: function(response) {
						alert('Error registering Member');
					}
				});
			}
		</script>

	<?php
}
