console.log('Its Verrry GooooD!')


var stateObject = {


    "Bangladesh": { "Dhaka": ["Demra", "Dhaka Cantt","Dhanmondi","Gulshan","Jatrabari","Joypara","Khilgaon","Khilkhet","Lalbag","Mirpur"],

        "Khulna": ["Alaipur", "Chalna Baza","Batiaghat" ,"Digalia" ,"Khulna Sadar" ,"Madinabad" ,"Paikgachha" ,"Phultala" ,"Sajiara","Terakhada"],

        "Chittagong ": ["Anawara", "Boalkhali", "Chittagong Sadar", "East Joara", "Fatikchhari", "Hathazari", "Jaldi", "Lohagara", "Mirsharai", "Rouzan"],
    },


    "UAE": {
        "Dubai": ["Hatta", "Jebel Ali", "Khorfakkan", "Dibba Al Fujairah", "Diba Al Sharjah", "Kalba"],

        "Abu Dhabi": ["Khalifa City A", "Khalifa City B", "Khalifa City C", "MBZ City", "Mussaffah", "Officers City", "Ruwais","Ghayathi"],

    },


    "Canada": {
        "Alberta": ["Banff", "Brooks", "Calgary ", "Edmonton ", " Fort McMurray", " Grande Prairie", "Jasper ", "Lake Louise ", "Lethbridge ", "Medicine Hat ", "Red Deer "],

        "British Columbia": ["Barkerville", "Burnaby", "Campbell River", "Chilliwack", "Courtenay", "Cranbrook", "Dawson Creek", "Delta", "Esquimalt", "Fort Saint James", "Fort Saint John", "Hope"],
        "Manitoba": ["Brandon", "Churchill", "Dauphin", "Flin Flon", "Kildonan", "Saint Boniface", "Swan River", "Thompson", "Winnipeg", "York Factory"],

        "New Brunswick": ["Bathurst", "Caraquet", "Dalhousie", "Fredericton", "Miramichi", "Moncton", "Saint John"],
        "Newfoundland & Labrador": ["Argentia", "Bonavista", "Channel-Port aux Basques", "Corner Brook", "Ferryland", "Gander", "Grand Falls–Windsor"],
        "Northwest Territories": ["Fort Smith", "Hay River", "Inuvik", "Tuktoyaktuk", "Yellowknife"],

        "Nova Scotia": ["Baddeck", "Digby", "Glace Bay", "Halifax", "Liverpool", "Louisbourg", "Lunenburg","Pictou"],
        "Ontario": ["Bancroft", "Barrie", "Belleville", "Brampton", "Brantford", "Brockville", "Burlington", "Cambridge", "Chatham", "Chatham-Kent", "Cornwall", "Elliot Lake", "Etobicoke", "Fort Erie", "Fort Frances", "Gananoque","Toronto"],

        "Quebec": ["Asbestos", "Beloeil", "Cap-de-la-Madeleine", "Chambly", "Charlesbourg", "Châteauguay", "Dorval", "Gaspé", "Gatineau"],
        "Saskatchewan": ["Batoche", "Cumberland House", "Estevan", "Flin Flon", "Moose Jaw", "Prince Albert", "Regina", "Saskatoon", "Uranium City"]


    },


    "England": {
        "Bath and North East Somerset" : ["Bath and North East Somerset"],
        "Bedford" : ["Bedford"],

        "Blackburn with Darwen" : ["Blackburn with Darwen"],
        "Blackpool" : ["Blackpool"],

        "Cambridgeshire" : ["East Cambridgeshire","Fenland", "Wisbech"],

        "Cornwall" : ["Bodmin","Falmouth ", "Fowey", "Launceston", "Looe ", "Lostwithiel ", "Penryn ", "Truro "],

        "Derby" : ["Derby"],
        "London" : ["London"],




    },

    "Japan": {
        "Aichit" : ["Anjō", "Atsuta", "Gamagōri", "Handa", "Hekinan", "Ichinomiya", "Inazawa", "Kasugai", "Nishio", "Okazaki", "Tokoname", "Toyokawa"],
        "Chiba" : ["Chiba", "Ichikawa", "Kisarazu", "Matsudo", "Narashino", "Narita", "Noda", "Sawara"],

        "Ehime" : ["Imabari", "Matsuyama", "Niihama", "Saijō", "Uwajima", "Ehime"],
        "Saitama" : ["Ageo", "Asaka", "Chichibu", "Fukaya", "Gyōda", "Iruma", "Kawagoe", "Kawaguchi", "Saitama", "Toda", "Warabi"],

        "Shizuoka" : ["Atami","Fuji", "Fujieda", "Gotemba", "Hamamatsu", "Numazu", "Shimada", "Shimizu", "Shizuoka", "Yaizu"],

        "Tokyo" : ["Chōfu","Fuchū ", "Hachiōji", "Higashimurayama", "Hino ", "Kodaira ", "Koganei ", "Tokyo "],

        "Wakayama" : ["Derby", "Kainan", "Nachi-katsuura", "Sakata", "Tsuruoka", "Wakayama", "Yamagata", "Yonezawa"],
        "Yamanashi" : ["Kōfu"],




    },


    "Turkey" : {
        "Adana" : ["Adana", "Ceyhan","Kozan", "İmamoğlu","Pozantı", "Karataş"],
        "Afyon" : ["Afyon", "Bolvadin","Dinar", "Emirdağ","Çay", "Şuhut","Çobanlar"],
        "Balıkesir" : ["Bandırma", "Edremit","Gönen", "Ayvalık","Susurluk", "Erdek"],
        "Diyarbakır" : ["Diyarbakır", "Ergani","Bismil", "Silvan","Çermik", "Çınar","Lice", "Kulp"],
        "Erzurum" : ["Erzurum", "Oltu","Horasan", "Pasinler","Aşkale"],
        "Hatay" : ["Hatay", "Samandağ","Payas", "Erzin","Harbiye", "Belen","Serinyol", "Çekmece","Narlıca", "Yeşilköy"],
        "Kahramanmaraş" : ["Kahramanmaraş", "Elbistan","Afşin", "Pazarcık","Göksun", "Türkoğlu","Çağlayancerit"],
        "Istanbul" : ["Istanbul"],
        "Mersin" : ["Mersin", "Erdemli","Anamur", "Mut","Bozyazı", "Kargıpınarı","Aydıncık", "Atayurt"],

    },



};

var countySel = document.getElementById("countySel"),
    stateSel = document.getElementById("stateSel"),
    districtSel = document.getElementById("districtSel");




// for (var country in stateObject) {
//     countySel.options[countySel.options.length] = new Option(country, country);
// }
// countySel.onchange = function () {
//     stateSel.length = 1; // remove all options bar first
//     districtSel.length = 1; // remove all options bar first
//     if (this.selectedIndex < 1) return; // done
//     for (var state in stateObject[this.value]) {
//         stateSel.options[stateSel.options.length] = new Option(state, state);
//     }
// };
// countySel.onchange(); // reset in case page is reloaded
// stateSel.onchange = function () {
//     districtSel.length = 1; // remove all options bar first
//     if (this.selectedIndex < 1) return; // done
//     var district = stateObject[countySel.value][this.value];
//     for (var i = 0; i < district.length; i++) {
//         districtSel.options[districtSel.options.length] = new Option(district[i], district[i]);
//     }
// };


