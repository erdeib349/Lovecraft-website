var quotes = [
    "\"Az őrület legnagyobb réme az, hogy az elméd megnyitja a kapukat, és megtudja, hogy nem a világegyetem az, aminek hittük.\"",
    "\"A rémálom az álom vége, és a valóság kezdete.\"",
    "\"A legerősebb érzelem az ismeretlen félelme, az ismeretlen legmélyebb gyökereiben.\"",
    "\"Az élet olyan rövid, és a tudás ilyen hosszú.\"",
    "\"Ne féljünk az ismeretlentől, csak attól, hogy nem tudjuk, mit rejteget.\"",
    "\"A legősibb és legmélyebb félelem az ismeretlen félelme.\"",
    "\"A szó elcsitul és a hallgatásban az éjszaka bugyraiban a barbár mennydörgés is megcsendesül.\"",
    "\"A régi világ elkallódott, sötétségbe merült, és az éjszaka más, mint amilyennek az emberek gondolják.\"",
    "\"Az igazság nagyon ritka dolog, de azt mondják, hogy a legtöbb dolog rejtve van a sötétségben.\"",
    "\"Azt mondják, hogy az őrület a fény túl fényes pillanata, amikor a világosság minden titkot felfed.\"",
    "\"Az élet csak egy kis tükörkép, egy szakadék a végtelen ismeretlen előtt.\"",
    "\"A legmélyebb sötétségben is van egy fénysugár, de az emberi szem nem mindig látja meg.\"",
    "\"Az álmok az elme legmélyebb titkai, ahol a valóság és a képzelet összefonódik.\"",
    "\"Az elmúlt idők városai alatt rejlik a múlt sötét titka, amelyre már senki sem emlékszik.\"",
    "\"A félelem a legősibb és legelső emberi érzelem, és mindig is az marad.\"",
    "\"A tudás igazi mélységei túlmutatnak az emberi értelem határain.\"",
    "\"Az emberi elmének csak egy vékony fátyol választja el a valóságot az őrülettől.\"",
    "\"Az éjszaka csendjében a régi idők hangjai szólalnak meg, melyek már régen elfelejtve vannak.\"",
    "\"A titok mindig ott lapul az árnyakban, vágyva arra, hogy felfedje magát az ember előtt.\"",
    "\"A tudás hatalmas terhet jelent, mely alatt a legtöbb ember összeroskad.\"",
    "\"A végtelen idő és a végtelen tér között elveszni olyan érzés, amit csak az igazi tudósok ismerhetnek.\""
];

function newQuote() {
    var randomNumber = Math.floor(Math.random() * (quotes.length));
    if(quotes[randomNumber] === prev){
        let randomNumber = Math.floor(Math.random() * (quotes.length));
    }
    document.getElementById('quoteDisplay').innerHTML = quotes[randomNumber];
    var prev = quotes[randomNumber];
}
