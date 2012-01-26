window.onload = function() {
	try {
		var user_id;
		if( !( user_id = localStorage.getItem('user_id') ) ) {
			user_id = window.rand_id;
			// store user_id
			localStorage.setItem('user_id',user_id)
		}else {
			
		}
		 var DOMInputUserId;
		if( ( DOMInputUserId = document.getElementById("input_user_id")) ) {
			DOMInputUserId.value = user_id;
		}
		
	}catch (e) {
		// local storage not supported
		alert("non supportato");
	}
}