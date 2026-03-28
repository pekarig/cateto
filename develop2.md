1. A develop.md fájban megvalósított fejlesztéshez (web-service-items) hasonlót szeretnék a /ai-jovo oldalra is. 
Gyakorlatilag az ai_tools blokk tartalmát szeretném dinamikussá tenni ami a C:\xampp\htdocs\cateto\tesztelek.html fájba is kitettem szemléltetésképpen.
Az egyes dobozok felépítése lényegesen egyszerűbb (bár a kódbol is látszik)
- Az AI tool-ra jelemző ikon (SVG) itt ugyan azt az svg ikonfeltöltsési metódust kellene alkalmazni mint a web-service-items esetében, de most már hibamentesen
- Az AI tool neve
- Az AI tool leírása Referencia:  /admin/web-service-items/{id}/edit oldalon a Leírás* mező
- Gomb A gombnak lehessen egyedi nevet adni. Jelenleg "Megnyitás" de lehessen pl, Részletek vagy Tovább is ha a helyzet úgy kívánja. Lehessen mind külső mind belső URL-t hozzá rendelni aminek a targetálását is lehessen állítani. pl. a külső linkeknél _blank target.

2. Szeretném mérni azt, hogy a contact (kapcsolat résznél), hányan jelenítik meg az adatokat. Tehát hányak pipálják ki a checkboxot és kattintanak az Elfogadom gombra. Ennek statisztikai jelentősége lenne, persze majd később kellenek más eszközök is erre, de egyelőre ez jó visszajelzés lenne számomra.

