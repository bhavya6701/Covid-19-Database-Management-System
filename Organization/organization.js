var searchRecBtn = document.getElementById("searchRecord");

searchArtBtn.addEventListener("click", searchArticleHandler);

function searchArticleHandler() {
    let ID = "" + document.getElementById("searchProstater").value;
    document.getElementById(ID).scrollIntoView();
}
