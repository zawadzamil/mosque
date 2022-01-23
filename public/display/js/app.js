
console.log('Working');

//Image Slider
var slideIndex = 0;
carousel();

function carousel() {
    var i;
    var x = document.getElementsByClassName("mySlides");
    for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
    }
    slideIndex++;
    if (slideIndex > x.length) { slideIndex = 1 }
    x[slideIndex - 1].style.display = "block";
    setTimeout(carousel, 3000); // Change image every 3 seconds
}


// Time For Clock
let a;
let time;
setInterval(() => {
    a = new Date();
    let time = a.toLocaleTimeString();
    // time = a.getHours() + ':' + a.getMinutes() + ':' + a.getSeconds();
    document.getElementById('time').innerHTML = time;


}, 1000);


// Date Day Finding
const weekday = ["Sun", "Mon", "TUE", "WED", "THU", "Fri", "SAT"];
const months = ["JAN", "FEB", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
const dateBottom = document.getElementById('dateBottom')

const d = new Date();
let day = weekday[d.getDay()];
let month = months[d.getMonth()];
let date = d.getDate();
let year = d.getFullYear();

dateBottom.innerText = day + ' ' + month + ' ' + date + ' ' + year;

//Play Audio Function
function playFazar() {
    var audio = new Audio('public/display/assets/audio/azanFaraz.mp3');
    audio.play();

}
//Play Audio Function
function play() {
    var audio = new Audio('public/display/assets/audio/audio.mp3');


    console.log('Playing...')
    audio.play();






}

// Azan In Start Time
let at;
let timeT;
setInterval(() => {
    at = new Date();
    let timeT = a.toLocaleTimeString();
    // time = a.getHours() + ':' + a.getMinutes() + ':' + a.getSeconds();
    document.getElementById('time').innerHTML = timeT;
    var time1 = moment().format("hh:mm")
    let fullTime = time1 + " " + timeT.slice(-2);
    const fazar = document.getElementById('f-start').innerText;
    const duhur = document.getElementById('d-start').innerText;
    const asr = document.getElementById('a-start').innerText;
    const magrib = document.getElementById('m-start').innerText;
    const isha = document.getElementById('i-start').innerText;
    const jummah = document.getElementById('j-start').innerText;


    var resultFazar = fullTime.localeCompare(fazar);
    var resultDuhur = fullTime.localeCompare(duhur);
    var resultAsr = fullTime.localeCompare(asr);
    var resultMagrib = fullTime.localeCompare(magrib);
    var resultIsha = fullTime.localeCompare(isha);
    var resultJummah = fullTime.localeCompare(jummah);

    if (resultFazar == 0) {
        playFazar();

    }
    if (resultDuhur == 0 || resultAsr == 0 || resultMagrib == 0 || resultIsha == 0 && day != 'Fri') {
        play();
    }
    if (resultJummah == 0) {
        play();
    }
    console.log(fullTime + ' ' + jummah + ' ' + resultJummah)



}, 57000);




// Toggle Button State
const toggleButton = document.getElementById('togBtn');
const englishTable  = document.getElementById('eng-table');
const banglaTable  = document.getElementById('ban-table');
const titleName = document.getElementById('arabic')
const slider = document.getElementById('slider')

const titleNameB = document.getElementById('bangla')

banglaTable.style.display = 'none';
titleNameB.style.display= 'none'

toggleButton.addEventListener('click', function () {
    var isChecked = toggleButton.checked;
    if(isChecked)
    {
        console.log("Green Bangla!")
        englishTable.style.display = 'none';
        banglaTable.style.display = 'table';
        titleName.style.color = '#D92828'
        slider.style.background = "rgb(18,1,1)"
        slider.style.background = "linear-gradient(90deg, rgba(18,1,1,1) 0%, rgba(212,14,14,1) 49%, rgba(29,2,2,1) 100%)";
        titleName.style.display = 'none'
        titleNameB.style.display = 'block'
        titleNameB.style.color = 'block'

    }
    else{
        console.log("Blue Eng!")
        englishTable.style.display = 'table';
        banglaTable.style.display = 'none';
        titleName.style.color = '#0B2183'
        slider.style.background = "rgb(0,1,22)"
        slider.style.background = "linear-gradient(90deg, rgba(0,1,22,1) 0%, rgba(59,40,167,1) 52%, rgba(33,2,55,1) 100%)";
        titleName.style.display = 'block'
        titleNameB.style.display = 'none'
    }

})
