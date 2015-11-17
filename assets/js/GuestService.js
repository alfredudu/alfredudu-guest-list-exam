var GuestService = {

	list: [],
	
	add: function(guest, callback) {
		$.ajax({
			type: 'POST',
			contentType: 'application/json',
			url: 'api/guests/',
			data: JSON.stringify(guest),
			success: function(addedGuest) {
				console.log('Guest created!');
				callback(addedGuest);
			},
			error: function() {
				console.log('Error to add guest ' + guest.name);
			}
		});
	},
	
	remove: function(id, callback) {
		$.ajax({
			type: 'DELETE',
			url: 'api/guests/' + id,
			success: function(response) {
				console.log('Guest deleted!');
				callback(true);
			},
			error: function(jqXHR) {
				console.log('Error to delete guest with id ' + id);
				callback(false);
			}
		});
	},
	
	getList: function(callback) {
		$.ajax({
			type: 'GET',
			url: 'api/guests',
			dataType: 'json',
			success: function(list) {
				callback(list);
			}
		});
	}
}