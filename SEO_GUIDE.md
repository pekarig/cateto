# SEO Útmutató & Ellenőrzések

## 🎯 Meta Kulcsszavak Használata

A **Filament adminban** minden oldalhoz található egy "Meta kulcsszavak" mező. Íme hogyan használd:

### ❌ Régi gyakorlat (2010 előtt):
- Google **NEM használja** a meta keywords-öt a rangsoroláshoz
- Spam miatt elhanyagolható SEO értéke van

### ✅ Mai használat:
1. **Belső kereséshez** - ha lesz keresés a weboldalon
2. **Strukturált dokumentálás** - admin felületen átláthatóság
3. **Más keresőmotorokhoz** - Yandex, Baidu még használják
4. **Tartalmi tervezés** - segít a fókuszált tartalomkészítésben

### 📝 Jó példa:
```
unraid, nas szerver, docker, plex szerver, otthoni szerver
```

**Tipp:** 5-10 kulcsszó, egyértelmű, vessző elválasztva.

---

## 🚀 Google Search Console Teendők

### 1. **Oldal hozzáadása**
```
https://search.google.com/search-console
```
- Add meg a domain-t
- DNS vagy HTML fájl hitelesítés

### 2. **Sitemap beküldése**
```
Sitemaps menü → Add a new sitemap
URL: https://yourwebsite.com/sitemap.xml
```

### 3. **Ellenőrzendő pontok:**
- ✅ **Indexelés** - Core Web Vitals
- ✅ **Mobil használhatóság**
- ✅ **Sebesség jelentés**
- ✅ **Hibajelentések** (404-ek, szerver hibák)

### 4. **robots.txt tesztelés**
```
Search Console → Settings → robots.txt Tester
```

---

## 🧪 Tesztelési Eszközök

### Google Eszközök:
1. **Rich Results Test** (Strukturált adatok)
   ```
   https://search.google.com/test/rich-results
   ```
   Beilleszted az oldalad URL-jét, és ellenőrzi a Schema.org adatokat.

2. **PageSpeed Insights**
   ```
   https://pagespeed.web.dev/
   ```
   Teljesítmény + Core Web Vitals + SEO javaslatok

3. **Mobile-Friendly Test**
   ```
   https://search.google.com/test/mobile-friendly
   ```

### Meta Tag ellenőrzés:
1. **Facebook Debugger** (Open Graph)
   ```
   https://developers.facebook.com/tools/debug/
   ```

2. **Twitter Card Validator**
   ```
   https://cards-dev.twitter.com/validator
   ```

3. **LinkedIn Post Inspector**
   ```
   https://www.linkedin.com/post-inspector/
   ```

### SEO Chrome Extension-ök:
- **Meta SEO Inspector**
- **SEO Minion**
- **Lighthouse** (beépített DevTools-ban: F12 → Lighthouse)

---

## 📊 Implementált SEO Elemek

### ✅ Létrehozva:

1. **Sitemap.xml** - `/sitemap.xml`
   - Automatikusan generált
   - Minden publikált oldal benne van
   - Priority és changefreq beállítva

2. **robots.txt** - `/robots.txt`
   - Frissítve sitemap hivatkozással
   - Admin és storage blokkolva

3. **Meta Tags** (Layout):
   - ✅ Title, Description
   - ✅ Keywords (ha van kitöltve)
   - ✅ Canonical URL
   - ✅ Open Graph (Facebook, LinkedIn)
   - ✅ Twitter Card
   - ✅ Author, Robots

4. **Structured Data** (Schema.org JSON-LD):
   - ✅ WebSite schema (főoldal)
   - ✅ WebPage schema (aloldalak)
   - ✅ Organization info

---

## 🔍 Gyors Helyszíni Ellenőrzés

### Terminálból:
```bash
# Sitemap ellenőrzése
curl http://localhost/sitemap.xml

# robots.txt ellenőrzése
curl http://localhost/robots.txt
```

### Böngészőből (F12 → Console):
```javascript
// Meta tagek ellenőrzése
document.querySelectorAll('meta').forEach(m => 
  console.log(m.getAttribute('name') || m.getAttribute('property'), 
  m.getAttribute('content'))
);

// Strukturált adat ellenőrzése
document.querySelectorAll('script[type="application/ld+json"]')
  .forEach(s => console.log(JSON.parse(s.textContent)));
```

---

## 📋 Checklist Új Oldal Létrehozásakor

- [ ] **Title** - Max 60 karakter, egyedi
- [ ] **Description** - 150-160 karakter, vonzó, CTA-val
- [ ] **Keywords** - 5-10 releváns kulcsszó (opcionális)
- [ ] **Slug** - SEO-barát URL (kötőjellel, ékezet nélkül)
- [ ] **Tartalom** - H1, H2 címsorok, strukturált
- [ ] **Képek** - Alt szöveg mindenhol
- [ ] **Linkek** - Belső linkek más oldalakra
- [ ] **Publikálás** előtt ellenőrzés

---

## 🎨 OG Image generálás

A `og_image` mezőhöz ajánlott:
- **Méret:** 1200x630px
- **Formátum:** JPG vagy PNG
- **Max méret:** 1MB alatt

Jelenleg: `{{ asset('images/og-default.jpg') }}`

**TODO:** Készíts egy default OG image-t és oldalanként egyedi képeket!

---

## 🔧 További Opcionális Fejlesztések

1. **Breadcrumb Schema** - oldalstruktúra
2. **FAQ Schema** - GYIK oldalakhoz
3. **Service Schema** - szolgáltatások részletezése
4. **LocalBusiness Schema** - ha van fizikai cím
5. **hreflang tags** - többnyelvűség esetén
6. **RSS Feed** - bloghoz/hírekhez

---

**Készítette:** GitHub Copilot  
**Frissítve:** 2026.04.02
