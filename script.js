// hitta alla parametrar i formen med query selector och gör så att priset ställs in enligt en funktion

const form = document.querySelector('#inputForm');
const selectedRoom = document.querySelector('#room');
const price = document.querySelector('#price');
const arrival = document.querySelector('#arrival');
const departure = document.querySelector('#departure');

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

  //DISCOUNT
  if (totalDays > 1) {
    price.value = (roomprice * totalDays) / 1.25;
  } else {
    price.value = roomprice * totalDays;
  }
}

form.addEventListener('change', () => {
  console.log('u selected something');
  priceCalculator();
});
