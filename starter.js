const isActive = localStorage.getItem("darkmode");
console.log(isActive)
if (isActive == "active") {
    document.body.classList.add("darkmode");
} else {
    document.body.classList.remove("darkmode");
}
