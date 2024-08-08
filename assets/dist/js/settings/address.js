let totalRows = $("#total-rows").val();
let loadingElement = `<div class="d-flex justify-content-center">
								  <div class="spinner-border" role="status">
									<span class="sr-only">Loading...</span>
								  </div>
							  </div>`;
checkRows(totalRows);

var latlng = [-8.7956767, 115.2128371];
var radiusInKm = 20;
var map = L.map('map').setView(latlng, 13);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
	maxZoom: 20,
	attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

var circle = L.circle(latlng, {
	color: 'red',       // Warna garis lingkaran
	fillColor: '#f03',  // Warna isi lingkaran
	fillOpacity: 0.1,   // Transparansi isi lingkaran
	radius: radiusInKm * 1000 // Radius dalam meter (kilometer * 1000)
}).addTo(map);

var marker;

function onMapClick(e) {
	var lat = e.latlng.lat;
	var lng = e.latlng.lng;

	if (marker) {
		map.removeLayer(marker);
	}

	marker = L.marker([lat, lng]).addTo(map)
		.bindPopup("Titik lokasi anda").openPopup();

	document.getElementById('latitude').value = lat;
	document.getElementById('longitude').value = lng;
}

$('#modal-address').on('shown.bs.modal', function() {
	map.invalidateSize();
});

map.on('click', onMapClick);



$('#btn-add').click(function () {
	if (marker) {
		marker.remove();
		marker = null;
	}

	if (totalRows == 5) {
		sweetError('Tidak dapat menyimpan data alamat lebih dari 5');
		return;
	}

	$("#modal-address").modal('show');

	$('.modal-title').empty().append('Tambah Alamat');
});

$("#form-address").submit(function (e) {
	e.preventDefault();

	let id = $("#id").val();
	let formData = new FormData(this);
	let btn = "#btn-submit";
	let table = "#table";
	let form = "#form-address";
	let modal = "#modal-address";

	if (id !== "") {
		var url = $("#update-url").val();
	} else {
		var url = $("#create-url").val();
	}

	// send data
	ajaxPost(url, formData, btn).done(function (res) {
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
		notifySuccess(res.message);
		$(modal).modal("hide");
		$(form)[0].reset();
		setTimeout(() => {
			$.unblockUI();
			location.reload();
		}, 1500);
	});
});

$('#modal-address').on('hidden.bs.modal', function (e) {
	$("#check-is-primary").show();
});

$(".edit").click(function () {
	let id = $(this).data("id");
	let url = $("#edit-url").val();
	url = url.replace(":id", id);

	ajaxGet(url).done(function (res) {
		let newLatLng = [res.data.latitude, res.data.longitude];
		marker = L.marker(newLatLng).addTo(map)
			.bindPopup("Titik lokasi anda").openPopup();
		map.setView(newLatLng, 13);

		$(".modal-title").empty().append("Edit Alamat");
		$("#id").val(res.data.id);
		$("#addressee").val(res.data.addressee);
		$("#telephone").val(res.data.telephone);
		$("#label").val(res.data.label);
		$("#address").val(res.data.address);
		$("#postal_code").val(res.data.postal_code);
		$("#latitude").val(res.data.latitude);
		$("#longitude").val(res.data.longitude);

		if (res.data.is_primary == 1) {
			$("#check-is-primary").hide();
			$('#is-primary').attr('checked', 'checked');
		} else {
			$("#check-is-primary").show();
			$('#is-primary').removeAttr('checked');
		}

		$("#modal-address").modal("show");
	});
});

$(".delete").click(function () {
	let id = $(this).data("id");
	let url = $("#delete-url").val();

	Swal.fire({
		title: 'Apakah anda yakin ingin menghapus data ini?',
		text: 'Data tidak dapat dipulihkan!',
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#c82333',
		confirmButtonText: 'Hapus',
		cancelButtonText: 'Batal',
	}).then((result) => {
		console.log(result);
		if (result.value) {
			$.ajax({
				type: 'POST',
				url: url,
				data: {'id': id},
				dataType: 'json',
				success: function (res) {
					if (res.success == true) {
						notifySuccess(res.message);
						setTimeout(function () {
							location.reload();
						}, 1500);
					} else {
						new sweetError(res.message);
					}
				},
				error: function (res) {
					new sweetError('There is an error');
				}
			});
		}
	});
});

$(".set-primary").click(function () {
	let id = $(this).data("id");
	let url = $("#set-primary-url").val();

	Swal.fire({
		title: 'Apakah anda yakin?',
		text: 'Ini akan menjadikan sebagai alamat utama anda',
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#82ae46',
		confirmButtonText: 'Jadikan Alamat Utama',
		cancelButtonText: 'Batal',
	}).then((result) => {
		console.log(result);
		if (result.value) {
			$.ajax({
				type: 'POST',
				url: url,
				data: {'id': id},
				dataType: 'json',
				success: function (res) {
					if (res.success == true) {
						setTimeout(function () {
							location.reload();
						}, 500);
					} else {
						new sweetError(res.message);
					}
				},
				error: function (res) {
					new sweetError('There is an error');
				}
			});
		}
	});
});

function checkRows(total) {
	if (total == 0) {
		$("#check-is-primary").hide();
		return;
	}

	$("#check-is-primary").show();
}
