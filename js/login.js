window.onload = _ =>{
	let messageDiv = document.getElementById("errorMessage");

	document.getElementById("loginButton").addEventListener("click", _ =>{
		let username 	= document.getElementById("username").value;
		let password 	= document.getElementById("password").value; 
		if(validFields(username,password)){
			let body = {
				username : username,
				password : password
			}
			let params = {
				method : "POST",
				headers: {'Content-Type': 'application/json'},
				body : JSON.stringify(body) 
			}
			fetch(API_LOGIN,params).then(response => {
				return response.json();
			}).then(response => {
				if(response.success){
					location.href = "home.html";
				}else{
					mensajeError(LANG.BAD_CREDENTIALS);
				}
			})
		}
	})

	document.getElementById("password").addEventListener("keyup", event =>{
		if(event.keyCode == 13)
			document.getElementById("loginButton").click();
	})

	function mensajeError(msg){
		messageDiv.textContent = msg;
		messageDiv.classList.add("show");
		setTimeout(_ => {
			messageDiv.classList.remove("show");
		},2000); // Two seconds and hide message
	}

	/**
	*	Function that check if username and pasword are not empty
	*/
	function validFields(username,password){
		return username != "" && password != "";
	}

}