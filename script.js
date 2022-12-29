// hitta alla parametrar i formen med query selector och gör så att priset ställs in enligt en funktion

const form = document.querySelector('#inputForm');
const selectedRoom = document.querySelector('#room');
const price = document.querySelector('#price');
const arrival = document.querySelector('#arrival');
const departure = document.querySelector('#departure');

function priceCalculator() {
  let roomOption = selectedRoom.options[selectedRoom.selectedIndex].text;
  let arrivalDate = arrival.value;
  let departureDate = departure.value;

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

  //skriv kod kring hur rumspriset ändras beroende på hur länge man stannar (kanske finns en discount beroende på hur många nätter man stannar)

  price.value = roomprice;

  console.log(roomOption, roomprice, arrivalDate, departureDate);

  // const arrival = document.querySel;ector('#arrival').value;
  // const departure = document.querySelector('#departure').value
  // const cost =
}

form.addEventListener('change', () => {
  console.log('u selected something');
  priceCalculator();
});
