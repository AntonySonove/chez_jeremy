const burgerMenuButton= document.getElementById("burgerMenuButton");
const dropdownHeader=document.getElementById("dropdownHeader");

burgerMenuButton.addEventListener("click",(event)=>{
    dropdownHeader.classList.toggle("showDropdown")
    event.stopPropagation(); //? empêche de clique de se propager au document
});

document.addEventListener("click", (event)=>{
    if(!dropdownHeader.contains(event.target) && !burgerMenuButton.contains(event.target)){
        dropdownHeader.classList.remove("showDropdown")
    }
})


const appointmentListButton= document.getElementById("appointmentListButton");

appointmentListButton.addEventListener("click",(event)=>{
    displayBookedAppointments.classList.toggle("hideBookedAppointment")
    event.stopPropagation();
});