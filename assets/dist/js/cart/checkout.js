$('#pay-button').click(function (event) {
	ajaxGet(allCartItemUrl).done(function (res) {
		$("#body").val(JSON.stringify(res.data));
		if (res.data.length == 0) {
			new sweetError('Keranjang anda masih kosong!');
			return false;
		}
	});

	event.preventDefault();
	let tokenUrl = $("#snap-token-url").val();
	setTimeout(function () {
		$.ajax({
			type: 'POST',
			data: {
				result_data : $("#result-data").val(),
				result_type : $("#result-type").val(),
				body : $("#body").val(),
				gross_amount: $("#total-price").val(),
			},
			url: tokenUrl,
			cache: false,

			success: function(data) {
				//location = data;
				console.log(data);
				console.log('token = '+data);

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
						console.log(result);
						changeResult('success', result);
						console.log(result.status_message);
						console.log(result);
						$("#payment-form").submit();
					},
					onPending: function(result){
						changeResult('pending', result);
						console.log(result.status_message);
						$("#payment-form").submit();
					},
					onError: function(result){
						changeResult('error', result);
						console.log(result.status_message);
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
		fetchCart();
		notifySuccess(res.message);
	});
});
