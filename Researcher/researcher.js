var searchArtBtn = document.getElementById("searchArticle");

searchArtBtn.addEventListener("click", searchArticleHandler);

function searchArticleHandler() {
	let ID = "" + document.getElementById("searchArtID").value;
	document.getElementById(ID).scrollIntoView();
}
