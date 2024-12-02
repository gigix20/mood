const isActive = localStorage.getItem("darkmode");

if(isActive) {
    document.body.classList.add("darkmode");
}else {
    document.body.classList.remove("darkmode");
}   