const charts = document.querySelectorAll(".chart");

charts.forEach(function (chart) {
	var ctx = chart.getContext("2d");
	var myChart = new Chart(ctx, {
		type: "bar",
		data: {
			labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
			datasets: [
				{
					label: "# of Votes",
					data: [12, 19, 3, 5, 2, 3],
					backgroundColor: [
						"rgba(255, 99, 132, 0.2)",
						"rgba(54, 162, 235, 0.2)",
						"rgba(255, 206, 86, 0.2)",
						"rgba(75, 192, 192, 0.2)",
						"rgba(153, 102, 255, 0.2)",
						"rgba(255, 159, 64, 0.2)",
					],
					borderColor: [
						"rgba(255, 99, 132, 1)",
						"rgba(54, 162, 235, 1)",
						"rgba(255, 206, 86, 1)",
						"rgba(75, 192, 192, 1)",
						"rgba(153, 102, 255, 1)",
						"rgba(255, 159, 64, 1)",
					],
					borderWidth: 1,
				},
			],
		},
		options: {
			scales: {
				y: {
					beginAtZero: true,
				},
			},
		},
	});
});

$(document).ready(function () {
	var csrf_token = $('[name=csrf-token]').attr('content');

	$('body').on('submit', '#createTaskForm', function(event) {
		event.preventDefault();
		$.ajax({
			url: '/tasks',
			type: 'POST',
			dataType: 'html',
			data: $(event.target).serialize(),
			beforeSend: function() {
				$('#createTask').click();
			}
		})
		.done(function(json) {
			$('main .container-fluid').before('<div class="col-12">\n' +
				'                                                    <div class="alert alert-success">\n' +
				'                        Задача добавлена\n' +
				'                    </div>\n' +
				'                                            </div>');
			console.log(json);
		})
		.fail(function(error) {
			alert('Неизвестная ошибка. Обратитесь к системному администратору');
			console.log(error);
		});
	});

	$('body').on('change', '#tasks_table select', function(event) {
		let iTaskId = $(this).closest('tr').data('id');
		let sValue = $(event.target).val();
		$.ajax({
			url: '/tasks/' + iTaskId,
			type: 'POST',
			dataType: 'json',
			data: {_token: csrf_token, _method: 'PUT', id: iTaskId, status: sValue},
		})
		.done(function(json) {
			console.log(json);
		})
		.fail(function(error) {
			console.log(error);
		});
	});

	// Обновление Задачи
	$('body').on('click', '.update_task', function (event) {
		let iTaskId = $(this).closest('tr').data('id');
		$.ajax({
			url: '/tasks/' + iTaskId + '/edit',
			type: 'GET',
			dataType: 'json',
		})
			.done(function(json) {
				let date = json.expiration_date.replace(/(\d+)\-(\d+)\-(\d+) (.+)/, '$1-$2-$3T$4');
				console.log(date);
				$('#updateTaskTitle').val(json.title);
				$('#updateTaskDesc').val(json.description);
				$('#updateTaskDate').val(date);
				$('#updateTaskPriority option[value="'+json.priority+'"]').attr('selected', 'selected');
				$('#updateTaskResponsible option[value="'+json.responsible+'"]').attr('selected', 'selected');
			})
			.fail(function(error) {
				console.log(error);
			});
		let form = $($(this).data('bsTarget') + ' form');
		$(form).attr('action', document.location.protocol + '//' + document.location.host +'/tasks/' + iTaskId);
	});

	$('body').on('submit', '#updateTaskForm', function(event) {
		event.preventDefault();
		$.ajax({
			url: $('#updateTaskForm').attr('action'),
			type: 'POST',
			dataType: 'html',
			data: $(event.target).serialize(),
			beforeSend: function() {
				$('#updateTask .modal-header button').click();
			}
		})
			.done(function(json) {
				let updateData = JSON.parse(json);
				$('[data-id="'+updateData.id+'"] td:nth-child(1)').html(updateData.title);
				$('[data-id='+updateData.id+'] td:nth-child(2)').html(updateData.priority);
				$('[data-id='+updateData.id+'] td:nth-child(3) option[value="'+updateData.status+'"]').attr('selected', 'selected');
				$('[data-id='+updateData.id+'] td:nth-child(4)').html(updateData.expiration_date.replace('T', ' '));
			})
			.fail(function(error) {
				console.log(error);
			});
	});

	$('body').on('click', '#expiration_date_sort, #responsible_sort', function(event) {
		$.ajax({
			url: '/dashboard',
			type: 'GET',
			dataType: 'html',
			data: {sort_name: $(this).attr('name'),sort: $(this).val()},
		})
			.done(function(html) {
				$('#tasks_table').replaceWith(html);
			})
			.fail(function(error) {
				console.log(error);
			});
	});

	$('body').on('click', '#date_sort', function(event) {
		$.ajax({
			url: '/dashboard',
			type: 'GET',
			dataType: 'html',
			data: {sort_name: $(this).attr('name'),sort: 'date_sort'},
		})
			.done(function(html) {
				$('#tasks_table').replaceWith(html);
			})
			.fail(function(error) {
				console.log(error);
			});
	});


	$('body').on('change', '[name="status"]', function(event) {
		if ($(this).val() === 'complete') {
			$(this).closest('tr').children('td:nth-child(1)').removeClass().addClass('text-success');
		}
	});

	/*Burger*/

	$('body').on('click', '.burger_menu', function (){
		$('.welcome__menu ul').slideToggle();
	});

	$('body').on('click', '#eye-password', function () {
		let oPassword = $(this).prev('input');
		if (oPassword.attr('type') == 'text') {
			oPassword.attr('type', 'password');
		} else {
			oPassword.attr('type', 'text');
		}
	})

});

