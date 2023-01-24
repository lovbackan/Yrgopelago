const planets = document.querySelectorAll(".planet");

const form = document.querySelector('#inputForm');
const selectedRoom = document.querySelector('#room');
const price = document.querySelector('#totalCost');
const arrival = document.querySelector('#arrival');
const departure = document.querySelector('#departure');
const slidesContainer = document.getElementById('slides-container');
const slide = document.querySelector('.slide');
const prevButton = document.getElementById('slide-arrow-prev');
const nextButton = document.getElementById('slide-arrow-next');
const roomPriceEconomy = 3;
const roomPriceStandard = 5;
const roomPriceLuxury = 8;
const featureOnePrice = 3;
const featureTwoPrice = 5;
let offer1Checked;
let offer2Checked;
let offer3Checked;

//See the checkbox status!
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
}

//fucntion that calculates the price
function priceCalculator() {
  const roomOption = selectedRoom.options[selectedRoom.selectedIndex].text;
  const arrivalDate = arrival.value;
  const departureDate = departure.value;
  const totalDays =
    departureDate.split('-').pop() - arrivalDate.split('-').pop();

  let roomprice;
  if (roomOption === 'Economy') {
    roomprice = roomPriceEconomy;
  } else if (roomOption === 'Standard') {
    roomprice = roomPriceStandard;
  } else if (roomOption === 'Luxury') {
    roomprice = roomPriceLuxury;
  } else {
    roomprice = 0;
  }

  //This calculates the price and adds a  20% discount on the room booking price if u stay longer than one day
  if (totalDays > 1) {
    price.value = roomprice * totalDays;
    price.value = price.value * 0.8;
  } else {
    price.value = roomprice * totalDays;
  }

  //Checks features and adds it to price
  if (offer1Checked === true) {
    price.value = Number(price.value) + featureOnePrice;
  }
  if (offer2Checked === true) {
    price.value = Number(price.value) + featureTwoPrice;
  }

  //I have this weird thing where when i call an alert in php throguh javascript it creates a new page and displays the alert. But this alert works as it should, opening an alert at the same page if you try to book a departure that is before an arrival-
  if (price.value < -1) {
    alert('Sadly timetravel is not a feature at this hotel, atleast for now!');
  }
}

//When u change the form the price gets calculated and is rounded down or up.
if (form) {
  form.addEventListener('change', () => {
    getCheckboxStatus();
    priceCalculator();
    price.value = Math.round(price.value);
  });
}

/* function to rotate planets on hotel-manager.php */
function rotate(el, radius = 160, time = 4000) {
	let rotate = 0

	return setInterval( () => {
        rotate++
	    if (rotate == 360) {
            rotate = 0
	    }
	    el.style.transform = `rotate(${rotate}deg) translateX(${radius}px) rotate(-${rotate}deg)`
    }, time / 100);
}

/* Loop for add the animation to the planets on hotel-manager.php */
for (let i = 0; i < planets.length; i++) {
  const planet = planets[i];
  const transformX = 160 + 70 * i
  const itervalId = rotate(planet, transformX, randomIntFromMinMax(9000, 1200))

  planet.dataset.id = itervalId;
  planet.style.setProperty('--transform', `${transformX}px`);


/* Click event to make the planets stop in the end poison */
planet.addEventListener('click', e => {
      const planetIndex = Array.prototype.indexOf.call(planets, e.target)

      for (let i = 0; i <= planetIndex; i++) {
        const planet = planets[i];

        const intervalId = planet.dataset.id
        clearInterval(intervalId);
        planet.classList.add('returnToStart')
      }
      console.log(planetIndex + 2);
  })
}

/* Helper function to get a random number between an min and max value */
function randomIntFromMinMax(min, max) {
  return Math.floor(Math.random() * (max - min + 1) + min)
}

//the follow section is for the slider
nextButton.addEventListener('click', () => {
  const slideWidth = slide.clientWidth;
  slidesContainer.scrollLeft += slideWidth;
  console.log('click');
});

prevButton.addEventListener('click', () => {
  const slideWidth = slide.clientWidth;
  slidesContainer.scrollLeft -= slideWidth;
  console.log('click');
});
