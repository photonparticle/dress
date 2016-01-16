$(document).ready(function () {
	$('#users_list').DataTable({
        responsive: true,
        order: [[0, 'asc']],
        stateSave: true,
        adaptiveHeight: true,
        language: translateData['dataTable']
     });
});