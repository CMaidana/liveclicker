window.onload	= _ =>{
	let firstname 	= document.getElementById("firstname");
	let lastname 	= document.getElementById("lastname");

	let color 		= document.getElementById("color");
	let size 		= document.getElementById("size");
	let vpos 		= document.getElementById("vposition");
	let hpos 		= document.getElementById("hposition");

	let user;

	let savebutton 	= document.getElementById("saveButton");
	let img 		= document.getElementById("image");

	fetch(API_USER_GET).then(_ =>_.json()).then(response =>{
		if(!response.success){
			location.href = "login.html";
		}else{
			user = response.response;
			loadUserData(user);
		}
	})

	function loadUserData(user){
		firstname.value 		= user.firstname;
		lastname.value 			= user.lastname;
		color.value	 			= user.imageOptions.color;
		size.value 				= user.imageOptions.size;
		vpos.value 				= user.imageOptions.vposition;
		hposition.value 		= user.imageOptions.hposition;
	}

	function updateUserData(){
		let body = {
			firstname : firstname.value,
			lastname  : lastname.value,
			imageOptions : {
				color : color.value,
				size  : size.value,
				vposition  : vpos.value,
				hposition  : hpos.value,
			}
		}
		let params = {
			method : "POST",
			body  : JSON.stringify(body),
			headers: {'Content-Type': 'application/json'}
		}
		fetch(API_USER_UPDATE,params).then(_ => _.json()).then(response =>{
			if(response.success){
				showMessage();
				image.classList.remove("show");
				image.onload = _=> {
					hideMessage();
					image.classList.add("show");
				}
				image.src = image.src;
			}
		})
	}

	function showMessage(){
		document.getElementById("message").classList.add("show");
		
	}
	function hideMessage(){
		document.getElementById("message").classList.remove("show");
	}

	savebutton.addEventListener("click",_=>{
		updateUserData();
	})

	document.getElementById("logoutButton").addEventListener("click",_=>{
		fetch(API_LOGOUT).then(_ => _.json()).then(response => {
			if(response.success){
				location.href = "login.html";
			}
		})
	})
}