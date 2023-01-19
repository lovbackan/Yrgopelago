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



// planets.forEach(planet => {
//   // console.log(planet);
//   const t = planet.animate([
//     {
//       transform: "rotate(0deg) translate(var(--translate, 160px)) rotate(0deg)",
//       offset: 0
//     },
//     {
//       transform: "rotate(-360deg) translate(var(--translate, 160px)) rotate(360deg)",
//       offset: 1
//     }
//   ],
//   {
//     easing: "linear",
//     duration: 10000,
//     // delay: randomIntFromInterval(0, 1000),
//     iterations: 3,
//   }
//   )
//   setInterval(() => {
//     t.progress = 30;
//     t.iterations = 1

//     let progress = Math.floor((t.timeline.currentTime / t.iterations) - t.startTime) / 100;
//     progress = progress.toPrecision(1).replace('e+2', '');
//     if (progress > 9) {
//       t.iterations = t.iterations + 1
//     }
//     console.log(progress);
//     console.log(t.iterations);
//   }, 10000);

//   planet.addEventListener('click', e => {
//       t.progress = 30;
//       t.iterations = 1

//       let progress = Math.floor(t.timeline.currentTime - t.startTime) / 100;
//       progress = progress.toPrecision(1).replace('e+1', '');
//       progress > 9
//       console.log(progress);
//     })

//   })

  function randomIntFromInterval(min, max) { // min and max included
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
