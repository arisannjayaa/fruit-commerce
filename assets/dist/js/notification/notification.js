// Enable pusher logging - don't include this in production
fetchNotification();
Pusher.logToConsole = true;

var pusher = new Pusher('127db0c2612c670ab73d', {
	cluster: 'ap1'
});

var channel = pusher.subscribe('my-channel');
channel.bind('my-event', function(data) {
	if (data.message == "OK") {
		let audio = document.getElementById('notification-sound');
		audio.play().catch(function(error) {
			console.error('User interaction required to play sound:', error);
		});
		fetchNotification();
	}
});

$(document).on("click", ".read-notification", function() {
	const id =  $(this).attr("data-id");
	const redirect = $(this).attr("data-url");
	const url = BASE_URL + 'notifications/read';
	const formData = {
		id : id,
		clicked : 1
	}

	$.ajax({
		url   : url,
		type  : 'POST',
		data : formData,
		dataType : 'json',
		success : function(res){
			if (res.message === "OK") {
				location.href = redirect;
			}
		}
	});
});

function fetchNotification() {
	$.ajax({
		url   : BASE_URL + 'notifications',
		type  : 'GET',
		async : true,
		dataType : 'json',
		success : function(res){
			let data = res.data;
			let html = '';
			$("#notification-container").empty();

			if (data.length == 0) {
				html += `<div class="list-group-item">
							<div class="row align-items-center">
								<div data-testid="notification-message" class="d-block text-muted text-truncate mt-n1">Belum Ada Notifikasi</div>
							</div>
						 </div>`;
			} else {
				data.forEach((item) => {
					html += `<div class="list-group-item">
								<div class="row align-items-center">
								<div class="col-auto"><span class="status-dot status-dot-animated bg-success d-block"></span></div>
								<div class="col text-truncate">
								<a href="javascript:void(0)" data-testid="notification-title" data-id="${item.id}" data-url="${item.url}" class="text-body d-block read-notification">${item.title}</a>
								<div data-testid="notification-message" class="d-block text-muted text-truncate mt-n1">
								${subStr(item.message, 70)}
								</div>
								</div>
								</div>
								</div>`;
				});
			}
			$("#notification-count").html(data.length);
			$("#notification-container").html(html);
		}
	});
}
