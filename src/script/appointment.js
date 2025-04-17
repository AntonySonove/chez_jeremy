const dateInput = document.getElementById("dateInput");
const hairdresser=document.getElementById("hairdresser");
const selectHour = document.getElementById("selectHour");
const dateAddAppointment= document.getElementById("dateAddAppointment");
const inputDisplayAppointment= document.getElementById("inputDisplayAppointment");
const displayBookedAppointments=document.getElementById("displayBookedAppointments");
// Création de la date du jour au format YYYY-MM-DD
const today = new Date().toISOString().split("T")[0];

// Application dans l'input
dateInput.value = today;
dateInput.min = today;
dateAddAppointment.value = today;
inputDisplayAppointment.value = today;

//! GENERER LES CRENEAUX DISPONIBLES
// dateInput.addEventListener("change", async function() {

//   try{

//     const selectedDate = dateInput.value;
//     const response = await fetch(`controller_appointment.php?date=${selectedDate}`);
//     const data = await response.text();
  
//     selectHour.innerHTML = data;

//   }catch(error){
//     console.log("erreur lors du fetch : ", error);
//   }

// });

async function fetchAppointment(){

  const selectedDate = dateInput.value;
  const selectedHairdresser = hairdresser.value;

  if(!selectedDate){

    return;
  }

  try{

    let url=`controller_appointment.php?date=${selectedDate}`;

    if (selectedHairdresser !="choice"){

      url += `&hairdresser=${selectedHairdresser}`;
    }

    const response = await fetch(url);
    const data = await response.text();
    
    selectHour.innerHTML = data;

  }catch(error){
    console.log("erreur lors du fetch : ", error);
  }
}


dateInput.addEventListener("change", fetchAppointment)
hairdresser.addEventListener("change", fetchAppointment);


//! AFFICHER LES RENDEZ-VOUS
inputDisplayAppointment.addEventListener("change", async function() {
  try{

    const selectedDateAppointment = inputDisplayAppointment.value;
    const response = await fetch(`controller_booked_appointment.php?date=${selectedDateAppointment}`);
    const data = await response.text();
  
    displayBookedAppointments.innerHTML = data;

  }catch(error){
    console.log("erreur lors du fetch : ", error);
  }

});

//! Désactiver les dimanches et lundis
dateInput.addEventListener("input", () => {
  const selectedDate = new Date(dateInput.value);
  const day = selectedDate.getDay(); // 0 = dimanche, 1 = lundi, ..., 6 = samedi

  if (day === 0 || day === 1) {
    alert("Désolé, le salon est fermé le dimanche et le lundi.");
    dateInput.value = today; // Reset à aujourd'hui
    dateInput.dispatchEvent(new Event("change")); // Recharge les créneaux valides
  }
});
//! charger les créneaux directement a l'affichage de la page
dateInput.dispatchEvent(new Event("change"));
hairdresser.dispatchEvent(new Event("change"));
dateAddAppointment.dispatchEvent(new Event("change"));
inputDisplayAppointment.dispatchEvent(new Event("change"));

//! bouton pour selectionner toutes les checkbox
document.addEventListener("DOMContentLoaded", function () {
  const toggleButton = document.getElementById("toggleCheckboxes");
  const checkboxes = document.querySelectorAll("input[name='checkboxAddAppointment[]']");
      
  let allChecked = false;

  toggleButton.addEventListener("click", function () {
    allChecked = !allChecked;

    checkboxes.forEach(function (checkbox) {
        checkbox.checked = allChecked;
    });

    toggleButton.textContent = allChecked ? "Tout désélectionner" : "Tout sélectionner";
  });
});

