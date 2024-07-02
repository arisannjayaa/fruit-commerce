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
	$("#pay-button").empty().append(loadingElement);
	let tokenUrl = $("#snap-token-url").val();
	setTimeout(function () {
		$.ajax({
			type: 'POST',
			data: {
				result_data : $("#result-data").val(),
				result_type : $("#result-type").val(),
			},
			url: tokenUrl,
			cache: false,

			success: function(data) {
				$("#pay-button").empty().append("Pilih Pembayaran");
				var resultType = document.getElementById('result-type');
				var resultData = document.getElementById('result-data');

				function changeResult(type,data){
					$("#result-type").val(type);
					$("#result-data").val(JSON.stringify(data));
					//resultType.innerHTML = type;
					//resultData.innerHTML = JSON.stringify(data);
				}

				snap.pay(data, {
					onSuccess: function(result){
						// console.log(result);
						changeResult('success', result);
						// console.log(result.status_message);
						// console.log(result);
						$("#payment-form").submit();
					},
					onPending: function(result){
						changeResult('pending', result);
						$("#payment-form").submit();
					},
					onError: function(result){
						changeResult('error', result);
						// console.log(result.status_message);
						$("#payment-form").submit();
					}
				});
			}
		});
	},500);
});

$("#payment-form").submit(function (e) {
	e.preventDefault();
	let url = $("#snap-finish-url").val();
	let formData = new FormData(this);

	// send data
	ajaxPost(url, formData).done(function (res) {
		notifySuccess(res.message);
		setTimeout(() => {
			location.href = BASE_URL;
		}, 1000)
	});
});
