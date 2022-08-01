var searchBtnClick = document.getElementById("searchUser");

searchBtnClick.addEventListener("click", searchHandler);

function searchHandler(e) {
	e.preventDefault();
	let ID = "" + document.getElementById("searchID").value;
	document.getElementById(ID).scrollIntoView();
}
