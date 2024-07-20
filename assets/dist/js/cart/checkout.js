let loadingElement = `<div class="d-flex justify-content-center">
								  <div class="spinner-border" role="status">
									<span class="sr-only">Loading...</span>
								  </div>
							  </div>`;

if ($("#address-bool").val() == 0) {
	notifyError("Anda belum membuat alamat lokasi pengiriman");
	setTimeout(() => {
		location.href = BASE_URL + 'user/settings/address';
	},1500);
}


$('#pay-button').click(function (event) {
	event.preventDefault();

	$.blockUI({
		message: loadingElement,
		css: {
			'z-index': 10002,
			border: 'none',
			padding: '15px',
			backgroundColor: '#000',
			'-webkit-border-radius': '10px',
			'-moz-border-radius': '10px',
			opacity: .5,
			color: '#fff',
		}
	});

	let tokenUrl = $("#snap-token-url").val();
		$.ajax({
			type: 'POST',
			data: {
				result_data : $("#result-data").val(),
				result_type : $("#result-type").val(),
			},
			url: tokenUrl,
			dataType: 'json',
			cache: false,
			success: function(data) {
				var resultType = document.getElementById('result-type');
				var resultData = document.getElementById('result-data');

				function changeResult(type,data){
					$("#result-type").val(type);
					$("#result-data").val(JSON.stringify(data));
				}

				snap.pay(data.token, {
					onSuccess: function(result){
						changeResult('success', result);
						$("#payment-form").submit();
					},
					onPending: function(result){
						changeResult('pending', result);
						$("#payment-form").submit();
					},
					onError: function(result){
						changeResult('error', result);
						$("#payment-form").submit();
					}
				});
			},
			error: function (res) {
				let response = JSON.parse(res.responseText);

				if (res.status == 400) {
					$.unblockUI();
					sweetError(response.message);
					setTimeout(() => {
						location.href = response.redirect;
					}, 1500);
				}
			},
			complete: function () {
				$.unblockUI();
			}
		});
});

$("#payment-form").submit(function (e) {
	e.preventDefault();
	let url = $("#snap-finish-url").val();
	let formData = new FormData(this);

	$.blockUI({
		message: loadingElement,
		css: {
			'z-index': 10002,
			border: 'none',
			padding: '15px',
			backgroundColor: '#000',
			'-webkit-border-radius': '10px',
			'-moz-border-radius': '10px',
			opacity: .5,
			color: '#fff',
		}
	});
	// send data
	$.ajax({
		type: 'POST',
		data: formData,
		url: url,
		contentType: false,
		processData: false,
		cache: false,
		success: function(res) {
			let response = JSON.parse(res);

			notifySuccess(response.message);
			setTimeout(() => {
				location.href = response.redirect;
			}, 1500);
		},
		error: function (res) {
			let response = JSON.parse(res.responseText)
			sweetError(response.message);

			setTimeout(() => {
				location.href = response.redirect;
			}, 2000);
		},
		complete: function (res) {
			let response = JSON.parse(res.responseText);

			if (response.code == 400) {
				$("#pay-button").empty().append("Gagal");
				$("#pay-button").prop("disabled", false);
				$.unblockUI();
				return
			}

			$("#pay-button").empty().append("Berhasil");
			$("#pay-button").prop("disabled", false);
			$.unblockUI();
		}
	});
});
