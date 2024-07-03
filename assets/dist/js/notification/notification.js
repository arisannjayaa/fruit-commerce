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
			data.forEach((item) => {
				html += `<div class="list-group-item">
								<div class="row align-items-center">
								<div class="col-auto"><span class="status-dot status-dot-animated bg-success d-block"></span></div>
								<div class="col text-truncate">
								<a href="#" data-testid="notification-title" class="text-body d-block">${item.title}</a>
								<div data-testid="notification-message" class="d-block text-muted text-truncate mt-n1">
								${subStr(item.message, 70)}
								</div>
								</div>
								</div>
								</div>`;
			});
			$("#notification-count").html(data.length);
			$("#notification-container").html(html);
		}

	});
}
