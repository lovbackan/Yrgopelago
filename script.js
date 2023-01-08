// hitta alla parametrar i formen med query selector och gör så att priset ställs in enligt en funktion

const form = document.querySelector('#inputForm');
const selectedRoom = document.querySelector('#room');
const price = document.querySelector('#totalCost');
const arrival = document.querySelector('#arrival');
const departure = document.querySelector('#departure');
const heroButton = document.querySelector('.buy');
console.log(heroButton);
let offer1Checked;
let offer2Checked;
let offer3Checked;

function getCheckboxStatus() {
  const offer1 = document.querySelector('#offer1').checked;
  if (offer1) {
    offer1Checked = true;
  } else {
    offer1Checked = false;
  }
  const offer2 = document.querySelector('#offer2').checked;
  if (offer2) {
    offer2Checked = true;
  } else {
    offer2Checked = false;
  }
  const offer3 = document.querySelector('#offer3').checked;
  if (offer3) {
    offer3Checked = true;
  } else {
    offer3Checked = false;
  }
}

function priceCalculator() {
  const roomOption = selectedRoom.options[selectedRoom.selectedIndex].text;
  const arrivalDate = arrival.value;
  const departureDate = departure.value;
  const totalDays =
    departureDate.split('-').pop() - arrivalDate.split('-').pop();

  let roomprice;
  if (roomOption === 'Economy') {
    roomprice = 5;
  } else if (roomOption === 'Standard') {
    roomprice = 10;
  } else if (roomOption === 'Luxury') {
    roomprice = 15;
  } else {
    roomprice = 0;
  }

  //DISCOUNT if stayed longer than 1 day, and also add features to totalcost
  if (totalDays > 1) {
    price.value = roomprice * totalDays * 0.7;
  } else {
    price.value = roomprice * totalDays;
  }

  //Checks features and adds it to price
  if (offer1Checked === true) {
    price.value = Number(price.value) + 10;
  }
  if (offer2Checked === true) {
    price.value = Number(price.value) + 15;
  }
  if (offer3Checked === true) {
    price.value = Number(price.value) + 20;
  }
}

form.addEventListener('change', () => {
  getCheckboxStatus();
  priceCalculator();
  price.value = Math.round(price.value);
});

heroButton.addEventListener('click', () => {
  window.scrollTo(0, document.body.scrollHeight);
});
