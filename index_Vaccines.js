var searchBtnClick = document.getElementById("btnvaccine");

searchBtnClick.addEventListener("click", searchHandler);

function searchHandler(e) {
	e.preventDefault();
	let ID = "" + document.getElementById("searchvaccine").value;
	document.getElementById(ID).scrollIntoView();
}
