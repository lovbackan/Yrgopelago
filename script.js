// hitta alla parametrar i formen med query selector och gör så att priset ställs in enligt en funktion

const form = document.querySelector('#inputForm');
const selectedRoom = document.querySelector('#room');
const price = document.querySelector('#totalCost');
const arrival = document.querySelector('#arrival');
const departure = document.querySelector('#departure');
let offer1Checked;

function getCheckboxStatus() {
  const offer1 = document.querySelector('#offer1').checked;
  if (offer1) {
    offer1Checked = true;
    console.log('yes');
  } else {
    console.log('no');
    offer1Checked = false;
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
}

form.addEventListener('change', () => {
  getCheckboxStatus();
  priceCalculator();
  price.value = Math.round(price.value);
});
