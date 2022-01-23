
//--------------------- Copyright Block ----------------------
/*

PrayTimes.js: Prayer Times Calculator (ver 2.3)
Copyright (C) 2007-2011 PrayTimes.org

Developer: Hamid Zarrabi-Zadeh
License: GNU LGPL v3.0

TERMS OF USE:
	Permission is granted to use this code, with or
	without modification, in any website or application
	provided that credit is given to the original work
	with a link back to PrayTimes.org.

This program is distributed in the hope that it will
be useful, but WITHOUT ANY WARRANTY.

PLEASE DO NOT REMOVE THIS COPYRIGHT BLOCK.

*/


//--------------------- Help and Manual ----------------------
/*

User's Manual:
http://praytimes.org/manual

Calculation Formulas:
http://praytimes.org/calculation



//------------------------ User Interface -------------------------


	getTimes (date, coordinates [, timeZone [, dst [, timeFormat]]])

	setMethod (method)       // set calculation method
	adjust (parameters)      // adjust calculation parameters
	tune (offsets)           // tune times by given offsets

	getMethod ()             // get calculation method
	getSetting ()            // get current calculation parameters
	getOffsets ()            // get current time offsets


//------------------------- Sample Usage --------------------------


	var PT = new PrayTimes('ISNA');
	var times = PT.getTimes(new Date(), [43, -80], -5);
	document.write('Sunrise = '+ times.sunrise)


*/


//----------------------- PrayTimes Class ------------------------


function PrayTimes(method) {


    //------------------------ Constants --------------------------
    var

        // Time Names
        timeNames = {
            imsak    : 'Imsak',
            fajr     : 'Fajr',
            sunrise  : 'Sunrise',
            dhuhr    : 'Dhuhr',
            asr      : 'Asr',
            sunset   : 'Sunset',
            maghrib  : 'Maghrib',
            isha     : 'Isha',
            midnight : 'Midnight'
        },


        // Calculation Methods
        methods = {
            MWL: {
                name: 'Muslim World League',
                params: { fajr: 18, isha: 17 } },
            ISNA: {
                name: 'Islamic Society of North America (ISNA)',
                params: { fajr: 15, isha: 15 } },
            Egypt: {
                name: 'Egyptian General Authority of Survey',
                params: { fajr: 19.5, isha: 17.5 } },
            Makkah: {
                name: 'Umm Al-Qura University, Makkah',
                params: { fajr: 18.5, isha: '90 min' } },  // fajr was 19 degrees before 1430 hijri
            Karachi: {
                name: 'University of Islamic Sciences, Karachi',
                params: { fajr: 18, isha: 18 } },
            Tehran: {
                name: 'Institute of Geophysics, University of Tehran',
                params: { fajr: 17.7, isha: 14, maghrib: 4.5, midnight: 'Jafari' } },  // isha is not explicitly specified in this method
            Jafari: {
                name: 'Shia Ithna-Ashari, Leva Institute, Qum',
                params: { fajr: 16, isha: 14, maghrib: 4, midnight: 'Jafari' } }
        },


        // Default Parameters in Calculation Methods
        defaultParams = {
            maghrib: '0 min', midnight: 'Standard'

        },


        //----------------------- Parameter Values ----------------------
        /*

        // Asr Juristic Methods
        asrJuristics = [
            'Standard',    // Shafi`i, Maliki, Ja`fari, Hanbali
            'Hanafi'       // Hanafi
        ],


        // Midnight Mode
        midnightMethods = [
            'Standard',    // Mid Sunset to Sunrise
            'Jafari'       // Mid Sunset to Fajr
        ],


        // Adjust Methods for Higher Latitudes
        highLatMethods = [
            'NightMiddle', // middle of night
            'AngleBased',  // angle/60th of night
            'OneSeventh',  // 1/7th of night
            'None'         // No adjustment
        ],


        // Time Formats
        timeFormats = [
            '24h',         // 24-hour format
            '12h',         // 12-hour format
            '12hNS',       // 12-hour format with no suffix
            'Float'        // floating point number
        ],
        */


        //---------------------- Default Settings --------------------

        calcMethod = 'MWL',

        // do not change anything here; use adjust method instead
        setting = {
            imsak    : '10 min',
            dhuhr    : '0 min',
            asr      : 'Standard',
            highLats : 'NightMiddle'
        },

        timeFormat = '24h',
        timeSuffixes = ['am', 'pm'],
        invalidTime =  '-----',

        numIterations = 1,
        offset = {},


        //----------------------- Local Variables ---------------------

        lat, lng, elv,       // coordinates
        timeZone, jDate;     // time variables


    //---------------------- Initialization -----------------------


    // set methods defaults
    var defParams = defaultParams;
    for (var i in methods) {
        var params = methods[i].params;
        for (var j in defParams)
            if ((typeof(params[j]) == 'undefined'))
                params[j] = defParams[j];
    };

    // initialize settings
    calcMethod = methods[method] ? method : calcMethod;
    var params = methods[calcMethod].params;
    for (var id in params)
        setting[id] = params[id];

    // init time offsets
    for (var i in timeNames)
        offset[i] = 0;



    //----------------------- Public Functions ------------------------
    return {


        // set calculation method
        setMethod: function(method) {
            if (methods[method]) {
                this.adjust(methods[method].params);
                calcMethod = method;
            }
        },


        // set calculating parameters
        adjust: function(params) {
            for (var id in params)
                setting[id] = params[id];
        },


        // set time offsets
        tune: function(timeOffsets) {
            for (var i in timeOffsets)
                offset[i] = timeOffsets[i];
        },


        // get current calculation method
        getMethod: function() { return calcMethod; },

        // get current setting
        getSetting: function() { return setting; },

        // get current time offsets
        getOffsets: function() { return offset; },

        // get default calc parametrs
        getDefaults: function() { return methods; },


        // return prayer times for a given date
        getTimes: function(date, coords, timezone, dst, format) {
            lat = 1* coords[0];
            lng = 1* coords[1];
            elv = coords[2] ? 1* coords[2] : 0;
            timeFormat = format || timeFormat;
            if (date.constructor === Date)
                date = [date.getFullYear(), date.getMonth()+ 1, date.getDate()];
            if (typeof(timezone) == 'undefined' || timezone == 'auto')
                timezone = this.getTimeZone(date);
            if (typeof(dst) == 'undefined' || dst == 'auto')
                dst = this.getDst(date);
            timeZone = 1* timezone+ (1* dst ? 1 : 0);
            jDate = this.julian(date[0], date[1], date[2])- lng/ (15* 24);

            return this.computeTimes();
        },


        // convert float time to the given format (see timeFormats)
        getFormattedTime: function(time, format, suffixes) {
            if (isNaN(time))
                return invalidTime;
            if (format == 'Float') return time;
            suffixes = suffixes || timeSuffixes;

            time = DMath.fixHour(time+ 0.5/ 60);  // add 0.5 minutes to round
            var hours = Math.floor(time);
            var minutes = Math.floor((time- hours)* 60);
            var suffix = (format == '12h') ? suffixes[hours < 12 ? 0 : 1] : '';
            var hour = (format == '24h') ? this.twoDigitsFormat(hours) : ((hours+ 12 -1)% 12+ 1);
            return hour+ ':'+ this.twoDigitsFormat(minutes)+ (suffix ? ' '+ suffix : '');
        },


        //---------------------- Calculation Functions -----------------------


        // compute mid-day time
        midDay: function(time) {
            var eqt = this.sunPosition(jDate+ time).equation;
            var noon = DMath.fixHour(12- eqt);
            return noon;
        },


        // compute the time at which sun reaches a specific angle below horizon
        sunAngleTime: function(angle, time, direction) {
            var decl = this.sunPosition(jDate+ time).declination;
            var noon = this.midDay(time);
            var t = 1/15* DMath.arccos((-DMath.sin(angle)- DMath.sin(decl)* DMath.sin(lat))/
                (DMath.cos(decl)* DMath.cos(lat)));
            return noon+ (direction == 'ccw' ? -t : t);
        },


        // compute asr time
        asrTime: function(factor, time) {
            var decl = this.sunPosition(jDate+ time).declination;
            var angle = -DMath.arccot(factor+ DMath.tan(Math.abs(lat- decl)));
            return this.sunAngleTime(angle, time);
        },


        // compute declination angle of sun and equation of time
        // Ref: http://aa.usno.navy.mil/faq/docs/SunApprox.php
        sunPosition: function(jd) {
            var D = jd - 2451545.0;
            var g = DMath.fixAngle(357.529 + 0.98560028* D);
            var q = DMath.fixAngle(280.459 + 0.98564736* D);
            var L = DMath.fixAngle(q + 1.915* DMath.sin(g) + 0.020* DMath.sin(2*g));

            var R = 1.00014 - 0.01671* DMath.cos(g) - 0.00014* DMath.cos(2*g);
            var e = 23.439 - 0.00000036* D;

            var RA = DMath.arctan2(DMath.cos(e)* DMath.sin(L), DMath.cos(L))/ 15;
            var eqt = q/15 - DMath.fixHour(RA);
            var decl = DMath.arcsin(DMath.sin(e)* DMath.sin(L));

            return {declination: decl, equation: eqt};
        },


        // convert Gregorian date to Julian day
        // Ref: Astronomical Algorithms by Jean Meeus
        julian: function(year, month, day) {
            if (month <= 2) {
                year -= 1;
                month += 12;
            };
            var A = Math.floor(year/ 100);
            var B = 2- A+ Math.floor(A/ 4);

            var JD = Math.floor(365.25* (year+ 4716))+ Math.floor(30.6001* (month+ 1))+ day+ B- 1524.5;
            return JD;
        },


        //---------------------- Compute Prayer Times -----------------------


        // compute prayer times at given julian date
        computePrayerTimes: function(times) {
            times = this.dayPortion(times);
            var params  = setting;

            var imsak   = this.sunAngleTime(this.eval(params.imsak), times.imsak, 'ccw');
            var fajr    = this.sunAngleTime(this.eval(params.fajr), times.fajr, 'ccw');
            var sunrise = this.sunAngleTime(this.riseSetAngle(), times.sunrise, 'ccw');
            var dhuhr   = this.midDay(times.dhuhr);
            var asr     = this.asrTime(this.asrFactor(params.asr), times.asr);
            var sunset  = this.sunAngleTime(this.riseSetAngle(), times.sunset);;
            var maghrib = this.sunAngleTime(this.eval(params.maghrib), times.maghrib);
            var isha    = this.sunAngleTime(this.eval(params.isha), times.isha);

            return {
                imsak: imsak, fajr: fajr, sunrise: sunrise, dhuhr: dhuhr,
                asr: asr, sunset: sunset, maghrib: maghrib, isha: isha
            };
        },


        // compute prayer times
        computeTimes: function() {
            // default times
            var times = {
                imsak: 5, fajr: 5, sunrise: 6, dhuhr: 12,
                asr: 13, sunset: 18, maghrib: 18, isha: 18
            };

            // main iterations
            for (var i=1 ; i<=numIterations ; i++)
                times = this.computePrayerTimes(times);

            times = this.adjustTimes(times);

            // add midnight time
            times.midnight = (setting.midnight == 'Jafari') ?
                times.sunset+ this.timeDiff(times.sunset, times.fajr)/ 2 :
                times.sunset+ this.timeDiff(times.sunset, times.sunrise)/ 2;

            times = this.tuneTimes(times);
            return this.modifyFormats(times);
        },


        // adjust times
        adjustTimes: function(times) {
            var params = setting;
            for (var i in times)
                times[i] += timeZone- lng/ 15;

            if (params.highLats != 'None')
                times = this.adjustHighLats(times);

            if (this.isMin(params.imsak))
                times.imsak = times.fajr- this.eval(params.imsak)/ 60;
            if (this.isMin(params.maghrib))
                times.maghrib = times.sunset+ this.eval(params.maghrib)/ 60;
            if (this.isMin(params.isha))
                times.isha = times.maghrib+ this.eval(params.isha)/ 60;
            times.dhuhr += this.eval(params.dhuhr)/ 60;

            return times;
        },


        // get asr shadow factor
        asrFactor: function(asrParam) {
            var factor = {Standard: 1, Hanafi: 2}[asrParam];
            return factor || this.eval(asrParam);
        },


        // return sun angle for sunset/sunrise
        riseSetAngle: function() {
            //var earthRad = 6371009; // in meters
            //var angle = DMath.arccos(earthRad/(earthRad+ elv));
            var angle = 0.0347* Math.sqrt(elv); // an approximation
            return 0.833+ angle;
        },


        // apply offsets to the times
        tuneTimes: function(times) {
            for (var i in times)
                times[i] += offset[i]/ 60;
            return times;
        },


        // convert times to given time format
        modifyFormats: function(times) {
            for (var i in times)
                times[i] = this.getFormattedTime(times[i], timeFormat);
            return times;
        },


        // adjust times for locations in higher latitudes
        adjustHighLats: function(times) {
            var params = setting;
            var nightTime = this.timeDiff(times.sunset, times.sunrise);

            times.imsak = this.adjustHLTime(times.imsak, times.sunrise, this.eval(params.imsak), nightTime, 'ccw');
            times.fajr  = this.adjustHLTime(times.fajr, times.sunrise, this.eval(params.fajr), nightTime, 'ccw');
            times.isha  = this.adjustHLTime(times.isha, times.sunset, this.eval(params.isha), nightTime);
            times.maghrib = this.adjustHLTime(times.maghrib, times.sunset, this.eval(params.maghrib), nightTime);

            return times;
        },


        // adjust a time for higher latitudes
        adjustHLTime: function(time, base, angle, night, direction) {
            var portion = this.nightPortion(angle, night);
            var timeDiff = (direction == 'ccw') ?
                this.timeDiff(time, base):
                this.timeDiff(base, time);
            if (isNaN(time) || timeDiff > portion)
                time = base+ (direction == 'ccw' ? -portion : portion);
            return time;
        },


        // the night portion used for adjusting times in higher latitudes
        nightPortion: function(angle, night) {
            var method = setting.highLats;
            var portion = 1/2 // MidNight
            if (method == 'AngleBased')
                portion = 1/60* angle;
            if (method == 'OneSeventh')
                portion = 1/7;
            return portion* night;
        },


        // convert hours to day portions
        dayPortion: function(times) {
            for (var i in times)
                times[i] /= 24;
            return times;
        },


        //---------------------- Time Zone Functions -----------------------


        // get local time zone
        getTimeZone: function(date) {
            var year = date[0];
            var t1 = this.gmtOffset([year, 0, 1]);
            var t2 = this.gmtOffset([year, 6, 1]);
            return Math.min(t1, t2);
        },


        // get daylight saving for a given date
        getDst: function(date) {
            return 1* (this.gmtOffset(date) != this.getTimeZone(date));
        },


        // GMT offset for a given date
        gmtOffset: function(date) {
            var localDate = new Date(date[0], date[1]- 1, date[2], 12, 0, 0, 0);
            var GMTString = localDate.toGMTString();
            var GMTDate = new Date(GMTString.substring(0, GMTString.lastIndexOf(' ')- 1));
            var hoursDiff = (localDate- GMTDate) / (1000* 60* 60);
            return hoursDiff;
        },


        //---------------------- Misc Functions -----------------------

        // convert given string into a number
        eval: function(str) {
            return 1* (str+ '').split(/[^0-9.+-]/)[0];
        },


        // detect if input contains 'min'
        isMin: function(arg) {
            return (arg+ '').indexOf('min') != -1;
        },


        // compute the difference between two times
        timeDiff: function(time1, time2) {
            return DMath.fixHour(time2- time1);
        },


        // add a leading 0 if necessary
        twoDigitsFormat: function(num) {
            return (num <10) ? '0'+ num : num;
        }

    }}



//---------------------- Degree-Based Math Class -----------------------


var DMath = {

    dtr: function(d) { return (d * Math.PI) / 180.0; },
    rtd: function(r) { return (r * 180.0) / Math.PI; },

    sin: function(d) { return Math.sin(this.dtr(d)); },
    cos: function(d) { return Math.cos(this.dtr(d)); },
    tan: function(d) { return Math.tan(this.dtr(d)); },

    arcsin: function(d) { return this.rtd(Math.asin(d)); },
    arccos: function(d) { return this.rtd(Math.acos(d)); },
    arctan: function(d) { return this.rtd(Math.atan(d)); },

    arccot: function(x) { return this.rtd(Math.atan(1/x)); },
    arctan2: function(y, x) { return this.rtd(Math.atan2(y, x)); },

    fixAngle: function(a) { return this.fix(a, 360); },
    fixHour:  function(a) { return this.fix(a, 24 ); },

    fix: function(a, b) {
        a = a- b* (Math.floor(a/ b));
        return (a < 0) ? a+ b : a;
    }
}


//---------------------- Init Object -----------------------





//Geting Latitude and Longitude

if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(successFunction,errorFunction);
} else {
    alert('It seems like Geolocation, which is required for this page, is not enabled in your browser. Please use a browser which supports it.');
}
function successFunction(position) {
    //Geting Latitude and Longitude
    lat = position.coords.latitude;
    long = position.coords.longitude;

    console.log('Your latitude is :'+Math.floor(lat)+' and longitude is '+Math.floor(long));


    //Seting Prayer Time According to Lat & Long

    //Getting all Prayer Field
    const fazar = document.getElementById('f-start');
    const duhur = document.getElementById('d-start');
    const asr = document.getElementById('a-start');
    const magrib = document.getElementById('m-start');
    const isha = document.getElementById('i-start');
    const jummah = document.getElementById('j-start');
//


    var prayTimes = new PrayTimes();
    prayTimes.setMethod('MWL');

//Get Local Timezone Offset
    var clientTimezoneOffset = new Date().getTimezoneOffset()/60;
//


    var times = prayTimes.getTimes(new Date(), [lat, long],'auto','12h');

// Converting time to 12h Format For each prayer time

//Fazar
    const fazarTime = new Date('1970-01-01T' + times.fajr + 'Z')
        .toLocaleTimeString('en-US',
            {timeZone:'UTC',hour12:true,hour:'numeric',minute:'numeric'}
        );

//Dhuhur
    const duhurTime = new Date('1970-01-01T' + times.dhuhr + 'Z')
        .toLocaleTimeString('en-US',
            {timeZone:'UTC',hour12:true,hour:'numeric',minute:'numeric'}
        );

    //Asr
    const asrTime = new Date('1970-01-01T' + times.asr + 'Z')
        .toLocaleTimeString('en-US',
            {timeZone:'UTC',hour12:true,hour:'numeric',minute:'numeric'}
        );


//Maghrib
    const maghribTime = new Date('1970-01-01T' + times.maghrib + 'Z')
        .toLocaleTimeString('en-US',
            {timeZone:'UTC',hour12:true,hour:'numeric',minute:'numeric'}
        );


    //Isha
    const ishaTime = new Date('1970-01-01T' + times.isha + 'Z')
        .toLocaleTimeString('en-US',
            {timeZone:'UTC',hour12:true,hour:'numeric',minute:'numeric'}
        );




//Setting the time
    fazar.innerText = fazarTime;
    duhur.innerText = duhurTime;
    asr.innerText = asrTime;
    magrib.innerText = maghribTime;
    isha.innerText = ishaTime;


    //Finding IP (Not Necessary)

    $.getJSON('https://api.ipify.org?format=json', function(data){
        console.log(data.ip);
        console.log(data.latitude );


    });
    //Finding Location


    function ipLookUp () {
        $.ajax('http://ip-api.com/json')
            .then(
                function success(response) {

                    console.log('User\'s Country', response.country);
                    console.log('User\'s Country', response.city);
                    console.log('User\'s Country', response.regionName);

                    const name = document.getElementById('name');
                    name.innerText = response.city +', '+response.regionName +', '+response.country;
                },

                function fail(data, status) {
                    console.log('Request failed.  Returned status of',
                        status);
                }
            );
    }
    ipLookUp()


//Function Ends
}
function errorFunction() {
    switch(error.code){
        case error.PERMISSION_DENIED:
            alert("User denied the request for Geolocation.");
            break;
        case error.POSITION_UNAVAILABLE:
            alert('Location information is unavailable.');
            break;
        case error.TIMEOUT:
            alert("The request to get user location timed out.");
            break;
        case error.UNKNOWN_ERROR:
            alert("An unknown error occurred.");
            break;
    }
}

function codeLatLng(lat, lng) {
    console.log('Function Working!');
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(lat, lng);
    geocoder.geocode({'latLng': latlng}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            console.log(results)
            if (results[1]) {
                //formatted address
                alert(results[0].formatted_address)
                //find country name
                for (var i=0; i<results[0].address_components.length; i++) {
                    for (var b=0;b<results[0].address_components[i].types.length;b++) {

                        //there are different types that might hold a city admin_area_lvl_1 usually does in come cases looking for sublocality type will be more appropriate
                        if (results[0].address_components[i].types[b] == "administrative_area_level_1") {
                            //this is the object you are looking for
                            city= results[0].address_components[i];
                            break;
                        }
                    }
                }
                //city data
                alert(city.short_name + " " + city.long_name)


            } else {
                alert("No results found");
            }
        } else {
            alert("Geocoder failed due to: " + status);
        }
    });
}















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
    var audio = new Audio('assets/audio/azanFaraz.mp3');
    audio.play();

}
//Play Audio Function
function play() {
    var audio = new Audio('assets/audio/audio.mp3');


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



}, 56000);




// // Toggle Button State
// const toggleButton = document.getElementById('togBtn');
// const englishTable  = document.getElementById('eng-table');
// const banglaTable  = document.getElementById('ban-table');
// const titleName = document.getElementById('arabic')
// const slider = document.getElementById('slider')
//
// const titleNameB = document.getElementById('bangla')
//
// banglaTable.style.display = 'none';
// titleNameB.style.display= 'none';

// toggleButton.addEventListener('click', function () {
//     var isChecked = toggleButton.checked;
//     if(isChecked)
//     {
//         console.log("Green Bangla!")
//         englishTable.style.display = 'none';
//         banglaTable.style.display = 'table';
//         titleName.style.color = '#D92828'
//         slider.style.background = "rgb(18,1,1)"
//         slider.style.background = "linear-gradient(90deg, rgba(18,1,1,1) 0%, rgba(212,14,14,1) 49%, rgba(29,2,2,1) 100%)";
//         titleName.style.display = 'none'
//         titleNameB.style.display = 'block'
//         titleNameB.style.color = 'block'
//
//     }
//     else{
//         console.log("Blue Eng!")
//         englishTable.style.display = 'table';
//         banglaTable.style.display = 'none';
//         titleName.style.color = '#0B2183'
//         slider.style.background = "rgb(0,1,22)"
//         slider.style.background = "linear-gradient(90deg, rgba(0,1,22,1) 0%, rgba(59,40,167,1) 52%, rgba(33,2,55,1) 100%)";
//         titleName.style.display = 'block'
//         titleNameB.style.display = 'none'
//     }
//
// })

// Full Screen
const  fullScreenButton = document.getElementById('fullScreen');
const  exitFullScreenButton = document.getElementById('exitFScreeen');
exitFullScreenButton.style.display = 'none';

var elem = document.documentElement;
fullScreenButton.addEventListener('click',function () {
    console.log('Working!!');
    if (elem.requestFullscreen) {
        elem.requestFullscreen();
    } else if (elem.webkitRequestFullscreen) { /* Safari */
        elem.webkitRequestFullscreen();
    } else if (elem.msRequestFullscreen) { /* IE11 */
        elem.msRequestFullscreen();
    }




});
exitFullScreenButton.addEventListener('click',function () {
    if (document.exitFullscreen) {
        document.exitFullscreen();
    } else if (document.mozCancelFullScreen) {
        document.mozCancelFullScreen();
    } else if (document.webkitExitFullscreen) {
        document.webkitExitFullscreen();
    } else if (document.msExitFullscreen) {
        window.top.document.msExitFullscreen();
    }

})
// Exit Full Screen Event Handel
var fulScreenCount = 0;
document.addEventListener("fullscreenchange", function() {
    if(fulScreenCount ==0)
    {
        fullScreenButton.style.display = 'none'
        fulScreenCount =1
        exitFullScreenButton.style.display = 'inline';
    }
    else{
        fullScreenButton.style.display = 'inline';
        fulScreenCount =0
        exitFullScreenButton.style.display = 'none';
    }
});


