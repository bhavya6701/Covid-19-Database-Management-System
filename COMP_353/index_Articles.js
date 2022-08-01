var searchBtnClick = document.getElementById("btnprostater");

searchBtnClick.addEventListener("click", searchHandler);

function searchHandler(e) {
	e.preventDefault();
	let ID = "" + document.getElementById("searchprostater").value;
	document.getElementById(ID).scrollIntoView();
}
