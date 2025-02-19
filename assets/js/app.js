/**
 * @author Kishor Mali
 */


$(document).ready(function(){
	
	$(document).on("click", ".deleteAnalyse", function(){
		var analyseId = $(this).data("analyseid"),
			hitURL = baseURL + "analyse/deleteAnalyse",
			currentRow = $(this);
		
		var confirmation = confirm("Etes-vous sûr de supprimer cette analyse ?");
		
		if(confirmation)
		{
			$.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { analyseId : analyseId }
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Analyse supprimée avec succès"); }
				else if(data.status = false) { alert("La suppression de l'analyse a échoué"); }
				else { alert("Accès refusé..!"); }
			});
		}
	});
	
	
	$(document).on("click", ".searchList", function(){
		
	});
	
});


(function(){

	var container = $('#dossier_container');

	console.log('started');

	if (container.length === 0) return false;

	$(document).ready(function(){

		$("#analyses").select2({
			theme: "classic",
			placeholder: "Sélectionner les analyses",
			allowClear: true,
		});
		$("#labos").select2({
			theme: "classic",
			placeholder: "Sélectionner un labo",
		});
		$('#date').datepicker({
			format: 'dd-mm-yyyy',
			autoclose: true,
			todayHighlight: true,
			defaultDate: new Date()
		})
		$('#date').datepicker("setDate", new Date());

		$('#date_').datepicker({
			format: 'dd-mm-yyyy',
			autoclose: true,
			todayHighlight: true,
		})

		var startDateInput = $('#startDate');
		var endDateInput = $('#endDate');

		startDateInput.datepicker({
			format: 'dd-mm-yyyy',
			autoclose: true,
			todayHighlight: true
		}).on('changeDate', function (selected) {
			var minDate = new Date(selected.date.valueOf());
			endDateInput.datepicker('setStartDate', minDate);
		});

		endDateInput.datepicker({
			format: 'dd-mm-yyyy',
			autoclose: true,
			todayHighlight: true
		}).on('changeDate', function (selected) {
			var maxDate = new Date(selected.date.valueOf());
			startDateInput.datepicker('setEndDate', maxDate);
		});


	}).on("click", ".deleteDossier", function(){
		var patientId = $(this).attr("data-patientid"),
			ref = $(this).attr("data-ref"),
			hitURL = baseURL + "dossier/deleteDossier",
			currentRow = $(this);

		var confirmation = confirm("Êtes-vous sûr de supprimer ce dossier ?");

		if (confirmation) {
			$.post(hitURL, { ref,patientId }, function(data) {
				console.log(data);
				if (data.status === true) {
					alert("Dossier supprimé avec succès");
					currentRow.parents('tr').remove();
				} else if (data.status === false) {
					alert("La suppression du dossier a échoué");
				} else {
					alert("Accès refusé..!");
				}
			}, "json");
		}
	}).on("keyup","#first_name", function () {
		let hitURL = baseURL + "dossier/search";
		let query = $(this).val();
		if (query.length > 2) {

			$.post(hitURL, { query },
				function(rep) {
				if (rep) {
					$("#patientList").html(rep);
				} else {
					$("#patientList").html("");
				}
			});

		} else {
			$("#patientList").html("");
		}
	}).on("click", ".patient-option", function () {
		let patientId = $(this).attr("data-id");
		let firstName = $(this).attr("data-firstName");
		let lastName = $(this).attr("data-lastName");
		let age = $(this).attr("data-age");
		let phone = $(this).attr("data-phone");
		$("#patientId").val(patientId);
		$("#first_name").val(firstName);
		$("#last_name").val(lastName);
		$("#age").val(age);
		$("#phone").val(phone);
		$("#patientList").html("");

	});
})();

//dashboard

(function(){

	var container = $('#dashboard_container');

	console.log('started');

	if (container.length === 0) return false;

	$(document).ready(function(){

		$("#analyses").select2({
			theme: "classic",
			placeholder: "Sélectionner les analyses",
			allowClear: true,
		});


	}).on("click", ".deleteAnalyse", function(){

		}).on('change',"#analyses", function () {
		let totalPrice = 0;

		// Iterate through selected options and sum their data-price values
		$('#analyses option:selected').each(function () {
			totalPrice += parseFloat($(this).data('price')) || 0;
		});

		// Update the total price display
		$('#total-price').text(totalPrice.toFixed(2));
	});



})();

//Labo

(function(){

	var container = $('#labo_container');

	console.log('started');

	if (container.length === 0) return false;

	$(document).ready(function(){

		$("#analyses").select2({
			theme: "classic",
			placeholder: "Sélectionner les analyses",
			allowClear: true,
		});


	}).on("click", ".deleteLabo", function(){

		var laboid = $(this).attr("data-laboid"),
			hitURL = baseURL + "labo/deleteLabo",
			currentRow = $(this);

		var confirmation = confirm("Êtes-vous sûr de supprimer ce labo ?");

		if (confirmation) {
			$.post(hitURL, { laboId: laboid }, function(data) {
				console.log(data);
				if (data.status === true) {
					alert("Labo supprimé avec succès");
					currentRow.parents('tr').remove();
				} else if (data.status === false) {
					alert("La suppression du Labo a échoué");
				} else {
					alert("Accès refusé..!");
				}
			}, "json");
		}

	})


})();