Szeretnék az /internetes-jelenlet oldalra egy olyan fejlesztést kérni, hogy web_services key-hez tartozó blokkot egy un. loop-os megoldással szeretném úgy megoldani, hogy sorban vihessem fel a dobozokat. 3 oszlop és ahány sor kijöb a végén. Jelenleg ez a feléspítés van benne a C:\xampp\htdocs\cateto\tesztelek.html fájlban amit a key: web_tartalom content blokkból másoltam ki. 
Tehát egy-egy doboz felépítése a következőképpen nézne ki:
- Tagline
- icon (általában egy svg, de lehet png is)
- heading
- leírás
- felsorolás
Utóbbi kettő megoldható a TipTap editorral - amit jelen állás szerint nem is látok a szerkesztőben. Amúgy az hová tünt el? A lényeg, hogy viszonylag könnyen szerkeszthető legyen és gyakorlatilag végtelen számú dobozt lehessen felvinni 3 oszlopos elrendezésben. 

Válaszok: 
Kérdés: Mi a cél? 
    /internetes-jelenlet oldalon a service dobozok dinamikusan szerkeszthetőek legyenek
    3 oszlopos grid (responsive: mobil 1 col, tablet 2 col, desktop 3 col)
    Végtelen számú doboz admin felületről felvihető
    Egyszerű szerkesztés TipTap rich text editorral
Válasz: Pontosan az amiket felsoroltál
Kérdés: A TipTap nincs telepítve. Most csak Textarea van. Ha ezt használod, telepíteni kell a Filament RichEditor ComponentSet-et. 
Válasz: Itt korábban volt valami kompatibilitási probléma, de egy alapfunkciós editor volt az oldalon. Ha a kompatibilitási probléma már elhárult akkor jó lenne a teljes funkcionalitású tiptap editort használni. Ha ez a probléma még mindig fennáll akkor elég lesz egy alap editor is
Kérdés: Architektúra döntés: 2 opció
Válasz: Legyen a B opció

