# De Grote Portfolio PHP CRUD Handleiding

*Of: hoe je in godsnaam zelf zo'n ding bouwt zonder te huilen.*

---

Hoi Rody. Welkom bij de handleiding. Ga er even goed voor zitten, pak een kop koffie (of een energiedrankje als je 16 bent en denkt dat je onsterfelijk bent), en we gaan dit samen rustig doornemen.

Deze handleiding gaat je stap voor stap uitleggen hoe je dit hele project zelf had kunnen bouwen, inclusief waarom je dingen doet, niet alleen hoe. Want "ctrl+c, ctrl+v" is leuk voor je cijfer, maar als je docent gaat vragen *"Rody, wat doet die regel nou eigenlijk?"* en jij staat te stotteren als een vastgelopen printer, dan heb je er niks aan.

Dus: we doen het rustig. Met humor. Met vergelijkingen. En af en toe met een slechte grap. Deal?

---

## Inhoudsopgave

1. [Wat gaan we eigenlijk bouwen?](#hoofdstuk-1--wat-gaan-we-eigenlijk-bouwen)
2. [Hoe werkt PHP samen met MySQL?](#hoofdstuk-2--hoe-werkt-php-samen-met-mysql)
3. [Project openen en installeren](#hoofdstuk-3--project-openen-en-installeren)
4. [De HTML-template begrijpen](#hoofdstuk-4--de-html-template-begrijpen)
5. [Database aanmaken in phpMyAdmin](#hoofdstuk-5--database-aanmaken-in-phpmyadmin)
6. [De projects-tabel maken](#hoofdstuk-6--de-projects-tabel-maken)
7. [Dummy data toevoegen](#hoofdstuk-7--dummy-data-toevoegen)
8. [De PDO-databaseverbinding](#hoofdstuk-8--de-pdo-databaseverbinding)
9. [Projecten ophalen met PHP](#hoofdstuk-9--projecten-ophalen-met-php)
10. [De overzichtspagina dynamisch maken](#hoofdstuk-10--de-overzichtspagina-dynamisch-maken)
11. [De detailpagina](#hoofdstuk-11--de-detailpagina)
12. [Zoeken toevoegen](#hoofdstuk-12--zoeken-toevoegen)
13. [Filteren op jaar](#hoofdstuk-13--filteren-op-jaar)
14. [Pagination (het engste hoofdstuk)](#hoofdstuk-14--pagination-het-engste-hoofdstuk)
15. [De users-tabel](#hoofdstuk-15--de-users-tabel)
16. [Wachtwoorden veilig opslaan](#hoofdstuk-16--wachtwoorden-veilig-opslaan)
17. [De loginpagina](#hoofdstuk-17--de-loginpagina)
18. [Sessions begrijpen](#hoofdstuk-18--sessions-begrijpen)
19. [Logout](#hoofdstuk-19--logout)
20. [CREATE — project toevoegen](#hoofdstuk-20--create--project-toevoegen)
21. [UPDATE — project aanpassen](#hoofdstuk-21--update--project-aanpassen)
22. [DELETE — project verwijderen](#hoofdstuk-22--delete--project-verwijderen)
23. [CRUD-beveiliging](#hoofdstuk-23--crud-beveiliging)
24. [File upload](#hoofdstuk-24--file-upload)
25. [Afbeeldingen weergeven](#hoofdstuk-25--afbeeldingen-weergeven)
26. [Help, hij doet het niet! (veelvoorkomende fouten)](#hoofdstuk-26--help-hij-doet-het-niet-veelvoorkomende-fouten)
27. [Git — committen en pushen](#hoofdstuk-27--git--committen-en-pushen)
28. [Eindcontrole](#hoofdstuk-28--eindcontrole)

---

## Hoofdstuk 1 — Wat gaan we eigenlijk bouwen?

We gaan een **portfolio-website** bouwen. Een plek waar jij je mooiste projecten kunt showcasen, met plaatjes erbij, zodat je straks tegen een werkgever kunt zeggen: *"Zie je dit? Dat heb ik gemaakt. In mijn eentje. Met PHP. Met mijn eigen handjes."*

Maar het is geen simpele statische website. Nee hoor. Deze website moet:

- Projecten uit een **database** halen (niet uit hardcoded HTML).
- Je laten **zoeken** op titel.
- Je laten **filteren** op jaar.
- **Pagination** hebben (want 500 projecten op één pagina is lelijk).
- Een **loginsysteem** hebben met wachtwoorden.
- **CRUD** ondersteunen: projecten toevoegen, aanpassen en verwijderen.
- **Afbeeldingen** kunnen uploaden.
- Veilig zijn (dus niemand kan zomaar je projecten slopen).

### Wat is CRUD?

CRUD is een afkorting die je de rest van je leven tegen gaat komen in software development. Het staat voor:

| Letter | Betekenis | In het Nederlands | Welk bestand |
|--------|-----------|-------------------|--------------|
| **C** | Create | Toevoegen | `add.php` |
| **R** | Read | Bekijken | `index.php` + `detail.php` |
| **U** | Update | Aanpassen | `edit.php` |
| **D** | Delete | Verwijderen | `delete.php` |

Zie het als de vier dingen die je kunt doen met een rij in je databank: aanmaken, lezen, aanpassen, weggooien. Dat is het. Dat is CRUD. Niet ingewikkelder maken dan het is.

> **Vergelijking:** CRUD is als een Netflix-watchlist. Je kunt een film **toevoegen** (Create), **bekijken** welke films erop staan (Read), een filmtitel **aanpassen** als je hem fout spelde (Update), of een film **weghalen** (Delete). Boom. CRUD.

---

## Hoofdstuk 2 — Hoe werkt PHP samen met MySQL?

Oké, dit is belangrijk. Hier worstelen heel veel beginners mee. Dus goed opletten.

### Het grote plaatje

Elke keer dat je een PHP-pagina opent in je browser, gebeurt dit:

```
Browser   (jij typt een URL in)
   ↓
Webserver (bijv. Apache in Docker)
   ↓
PHP       (voert jouw .php-code uit)
   ↓
MySQL     (geeft antwoord op vragen van PHP)
   ↓
PHP       (zet het antwoord in HTML)
   ↓
Browser   (laat HTML aan jou zien)
```

### Elk onderdeel uitgelegd

- **Browser** = Chrome, Safari, Firefox. Die laat jou webpagina's zien. Je typt een URL, en de browser vraagt: *"Mag ik die pagina?"*
- **Webserver (Apache)** = De gastheer. Die luistert naar vragen van browsers en zegt: *"Ja hoor, kom maar binnen, ik zoek het even op."*
- **PHP** = De slimme assistent achter de bar. PHP leest jouw `.php`-bestanden, voert de code uit en bouwt HTML.
- **MySQL** = De archiefkast. Daar staan al je gegevens in. PHP kan vragen stellen zoals: *"Geef me alle projecten uit 2026."*
- **phpMyAdmin** = Een handige grafische tool waarmee jij in de archiefkast kunt kijken zonder dat je zelf SQL hoeft te typen in een zwart terminalscherm.

> **Vergelijking:** PHP is de ober in een restaurant, MySQL is de keuken. Jij (de browser) bestelt bij de ober. De ober loopt naar de keuken, haalt je bord op, loopt terug, en zet het voor je neer. Jij ziet alleen het eindresultaat. Dat is PHP + MySQL.

### Statisch vs dynamisch

- **Statische HTML** = je typt de projecten letterlijk in de HTML. Als je 10 projecten hebt, kopieer je 10 keer dezelfde HTML-blok. En dan heb je 100 projecten en wil je sterven.
- **Dynamische HTML** (met PHP) = je typt het HTML-blok één keer, en PHP herhaalt het automatisch voor elk project uit de database.

Dit project is dynamisch. Daarom is het zoveel krachtiger dan een statische site.

---

## Hoofdstuk 3 — Project openen en installeren

Jij draait Docker (ik weet dat omdat ik je memory las, mysterieus hè). Dat betekent dat je **geen** MAMP of XAMPP nodig hebt. Je stack staat al klaar.

### Wat je setup heeft

- **Apache** (de webserver) → poort 80
- **PHP-FPM** (PHP uitvoerder) → poort 9000 (praat via Apache)
- **MySQL** (database) → poort 3306
- **phpMyAdmin** (database-GUI) → poort 8080

### Project in de goede map zetten

Jouw Docker-stack bedient alle projecten die onder `~/Sites/localhost/` staan. Dus zorg dat de map `portfolio` daar ergens onder staat.

Bij jou is dat:

```
/Users/rodystockschen/Sites/localhost/9.1/Eindopdracht-PHP/portfolio/
```

Dus de URL in de browser wordt:

```
http://localhost/9.1/Eindopdracht-PHP/portfolio/
```

### Database importeren

1. Open **phpMyAdmin** → `http://localhost/phpmyadmin/`
2. Login met `root` / `root`
3. Klik bovenin op **Importeren**
4. Kies het bestand `database.sql`
5. Klik op **Uitvoeren**

Boem. Database bestaat. Nu kan je PHP met MySQL praten.

> **Belangrijk voor jouw Docker-setup:** De `host` in `database.php` is **niet** `localhost`, maar `mysql_db`. Dat is omdat PHP in een eigen container draait, en vanuit die container is `localhost` niet jouw Mac maar de PHP-container zelf. Zie het als: PHP woont in een appartement, en MySQL woont in het appartement ernaast. Vanuit PHP's deur zie je niet de buurman als "jezelf", maar als "de buurman". Die buurman heet in Docker `mysql_db`.

---

## Hoofdstuk 4 — De HTML-template begrijpen

Voordat we PHP erop loslaten, moeten we begrijpen wat we hebben.

De template bestond uit drie HTML-bestanden:

- `index.html` → overzichtspagina met zoekbalk, project-kaartjes en paginering
- `detail.html` → één project groot in beeld
- `login.html` → simpel inlogformulier

### Wat zag je in `index.html`?

- Een `<nav>` met een `<input type="search">` → dat wordt onze zoekbalk.
- Een `<div class="projects">` met daarin meerdere `<div class="project card">` → dat zijn de projectkaartjes.
- Elke kaart heeft een `<h2>` (titel), een `<div>` (omschrijving) en drie knoppen: View, Edit, Delete.
- Onderaan een `<ul class="pagination">` → de pagineerknoppen.

### Wat gaan we doen?

Alles wat **hardcoded** in de HTML stond, gaan we **dynamisch** maken. In plaats van 5 keer dezelfde `<div class="project card">` te typen, laten we PHP een `foreach`-loopje draaien over alle projecten uit de database.

> **Vergelijking:** De HTML-template is als een boterham-mal. Jij hebt één mal (het HTML-sjabloon). PHP is de machine die eindeloos boterhammen uit die mal perst, elk met andere ingrediënten (= andere projecten).

### Bootstrap

De template gebruikt Bootstrap via een CDN:

```html
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
```

**CDN** = Content Delivery Network. Het betekent dat je Bootstrap niet op je eigen server zet, maar laadt vanaf hun server. Lekker makkelijk, en snel.

Bootstrap geeft ons kant-en-klare CSS-classes zoals `btn btn-primary`, `card`, `container`, `row`, etc. Dat scheelt enorm veel eigen CSS schrijven. Danku Bootstrap-team.

---

## Hoofdstuk 5 — Database aanmaken in phpMyAdmin

Dit is waar beginners vaak vastlopen. Dus rustig aan.

### Wat is een database?

Een database is een **digitale archiefkast**. Niets meer, niets minder.

- De **kast** zelf = de database (`portfolio_db`)
- De **lades** = tabellen (`projects`, `users`)
- Elk **dossier** in een lade = een rij
- Elke **soort informatie** in een dossier = een kolom

Dus:
- Database `portfolio_db` → de kast
- Tabel `projects` → de lade waar al je projecten in zitten
- Eén rij = één project
- Kolom `title` = het stukje papier waar de titel van dat project op staat

### Database aanmaken

1. Open phpMyAdmin.
2. Klik links op **Nieuw**.
3. Vul in: `portfolio_db`
4. Kies collation: **utf8mb4_unicode_ci** (dat is belangrijk, anders kun je geen emoji's of rare tekens opslaan en ga je over een maand janken wanneer iemand een hartje in een titel typt).
5. Klik op **Aanmaken**.

Je hebt nu een kast. Hij is leeg. Nu gaan we een lade erin zetten.

---

## Hoofdstuk 6 — De projects-tabel maken

Nu maken we de eerste tabel. Hierin gaan al onze projecten staan.

### Welke kolommen hebben we nodig?

Nadenkmomentje: wat voor info heb je per project nodig?

- Een **id** (uniek nummer per project)
- Een **titel**
- Een **korte omschrijving** (voor op het overzicht)
- Een **lange omschrijving** (voor op de detailpagina)
- Een **type** (website, webapp, blog, etc.)
- Een **jaar**
- Een **afbeelding** (bestandsnaam)
- Een **created_at** (wanneer het toegevoegd is)

### Tabel maken in phpMyAdmin

1. Klik op de database `portfolio_db`.
2. Klik op **Nieuw** om een tabel te maken.
3. Vul in: naam = `projects`, aantal kolommen = 8.
4. Klik op **Uitvoeren**.
5. Vul de kolommen in zoals hieronder.

### De kolommen uitgelegd

| Naam | Type | Lengte | Extra | Uitleg |
|------|------|--------|-------|--------|
| `id` | INT | — | A_I, PRIMARY | Uniek nummer, loopt automatisch op |
| `title` | VARCHAR | 255 | — | Kort stukje tekst (max 255 tekens) |
| `short_description` | VARCHAR | 255 | — | Korte omschrijving |
| `description` | TEXT | — | — | Lange tekst (duizenden tekens) |
| `type` | VARCHAR | 100 | — | website/webapp/etc |
| `year` | INT | — | — | Jaartal als getal |
| `image` | VARCHAR | 255 | NULL mogelijk | Bestandsnaam van de foto |
| `created_at` | TIMESTAMP | — | DEFAULT CURRENT_TIMESTAMP | Automatisch de huidige datum |

### Wacht, wat betekenen die types?

- **INT** = een geheel getal. Zoals 1, 42, 1000. Geen komma's.
- **VARCHAR(255)** = een stukje tekst van maximaal 255 tekens. Voor korte dingen zoals een titel of een naam.
- **TEXT** = lange tekst. Kan heel lang zijn (65.535 tekens). Voor lange omschrijvingen.
- **TIMESTAMP** = een datum + tijd. Zoals `2026-10-01 14:23:00`.

### Wat is PRIMARY KEY?

Een **primary key** is dé unieke identifier van een rij. Elke rij moet er eentje hebben, en hij moet uniek zijn. Bij ons is dat `id`.

> **Vergelijking:** Een primary key is als je BSN-nummer. Er is maar één persoon met jouw BSN. Zelfs als er honderd Rody's zijn, is er maar één Rody met jouw specifieke BSN.

### Wat is AUTO_INCREMENT?

AUTO_INCREMENT (afgekort A_I) betekent: *"MySQL, hou jij maar bij welk nummer de volgende is."* Elke keer dat je een rij toevoegt, telt MySQL automatisch 1 op bij de laatste id.

Dus: eerste project krijgt id 1, tweede krijgt id 2, derde krijgt id 3. Jij hoeft er niks voor te doen.

---

## Hoofdstuk 7 — Dummy data toevoegen

Een lege tabel is saai. We hebben wat voorbeeldprojecten nodig om op te testen.

### Twee manieren

**Manier 1: via phpMyAdmin GUI**
1. Klik op tabel `projects`.
2. Klik op tabblad **Invoegen**.
3. Vul de velden in (behalve `id` en `created_at`, die vullen zichzelf).
4. Klik **Uitvoeren**.
5. Herhaal 5-9 keer.

**Manier 2: SQL rechtstreeks (sneller)**

In `database.sql` heb ik dit al voor je gedaan:

```sql
INSERT INTO projects (title, short_description, description, type, year, image) VALUES
('Portfolio Website', 'Mijn eigen portfolio...', 'Dit is mijn...', 'website', 2026, NULL),
('Festival App', 'Een webapp voor...', 'Een complete...', 'webapp', 2026, NULL),
...
```

Wat gebeurt hier?
- `INSERT INTO projects` = "Zet in de tabel projects"
- `(title, short_description, ...)` = "deze kolommen vul ik"
- `VALUES ('Portfolio Website', ...)` = "met deze waarden"

Elk rijtje tussen haakjes is één nieuw project.

> **Vergelijking:** `INSERT INTO` is als een bestelformulier. Je zet een kruisje bij alle velden die je wil invullen, en MySQL maakt er een nieuw dossier van en legt het in de lade.

---

## Hoofdstuk 8 — De PDO-databaseverbinding

Oké, dit is misschien wel het belangrijkste hoofdstuk. Lees het twee keer.

### Wat is PDO?

**PDO** staat voor **PHP Data Objects**. Het is dé moderne manier om vanuit PHP met een database te praten. De oude manier (`mysql_connect`, `mysql_query`) is sinds PHP 7 verwijderd. Dus die mag je vergeten.

PDO is:
- **Veilig** (als je prepared statements gebruikt).
- **Werkt met verschillende databases** (MySQL, PostgreSQL, SQLite — allemaal met dezelfde code).
- **Standaard in PHP** — je hoeft niks te installeren.

### De verbinding opzetten

Hier is `database.php`:

```php
<?php
$host     = 'mysql_db';
$dbname   = 'portfolio_db';
$username = 'root';
$password = 'root';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Kan geen verbinding maken met de database: " . $e->getMessage());
}
```

### Regel voor regel

**Regel 1-5:** We maken vier variabelen aan met de instellingen voor de database. Deze zet je bovenaan zodat je ze makkelijk kunt aanpassen.

**Regel 7:** `try {` — dit betekent: *"Probeer dit, en als het misgaat, spring naar de `catch`."* Een soort veiligheidsnet.

**Regel 8-12:** We maken een nieuw PDO-object. De tekst `"mysql:host=$host;dbname=$dbname;charset=utf8mb4"` heet een **DSN** (Data Source Name). Daarin vertel je PDO: welk type database (mysql), op welke host, welke databasenaam, en met welke tekencodering (utf8mb4 = alles kan, inclusief emoji's).

**Regel 13:** `setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION)` → *"Als er een SQL-fout is, gooi een exception zodat ik hem kan vangen."* Standaard zwijgt PDO als er iets fout gaat, en dat wil je niet.

**Regel 14:** `setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC)` → *"Geef resultaten als associatieve array, dus `$project['title']` in plaats van `$project[0]`."* Veel leesbaarder.

**Regel 15-17:** `catch (PDOException $e)` — als er iets misging in de `try`, komt de code hier terecht. We laten een foutmelding zien en stoppen de pagina met `die()`.

### De `$pdo` variabele

`$pdo` is nu een **object** dat weet hoe het met jouw database moet praten. Elke keer dat je iets uit de database wil halen, gebruik je dit object.

> **Vergelijking:** `$pdo` is als een telefoonverbinding met MySQL. Zodra `database.php` is uitgevoerd, "bel" je MySQL en de lijn staat open. Elke query is een vraag die je door de telefoon stelt.

---

## Hoofdstuk 9 — Projecten ophalen met PHP

Nu de leuke dingen. Hoe haal je data uit de database?

### Het patroon

Vrijwel elke query bestaat uit drie stappen:

1. **Prepare** — zeg tegen MySQL wat je gaat vragen.
2. **Execute** — stel de vraag.
3. **Fetch** — haal het antwoord op.

### Simpel voorbeeld

```php
$stmt = $pdo->prepare("SELECT * FROM projects");
$stmt->execute();
$projects = $stmt->fetchAll();
```

### Regel 1

```php
$stmt = $pdo->prepare("SELECT * FROM projects");
```

PHP zegt tegen MySQL: *"Beste MySQL, ik ga je zo meteen vragen om alles uit de tabel projects. Maak je even klaar."* 

De query (`SELECT * FROM projects`) betekent: **selecteer alle (`*`) kolommen uit de tabel `projects`**.

`$stmt` is een afkorting van "statement" en is nu een voorbereide query. Hij is nog niet uitgevoerd!

### Regel 2

```php
$stmt->execute();
```

Nu zeggen we: *"Oké MySQL, voer uit!"* MySQL gaat alle rijen zoeken en legt ze klaar.

### Regel 3

```php
$projects = $stmt->fetchAll();
```

*"Geef me alle resultaten in één keer."* `$projects` is nu een **array van arrays**. Dus:

```php
$projects[0]['title']   // titel van het eerste project
$projects[0]['year']    // jaar van het eerste project
$projects[1]['title']   // titel van het tweede project
```

### fetch vs fetchAll

- `fetch()` → geeft **één rij** terug. Gebruik dit als je maar één project verwacht (bijv. detailpagina).
- `fetchAll()` → geeft **alle rijen** terug als array. Gebruik dit voor het overzicht.

### De projecten tonen

Nu we `$projects` hebben, kunnen we er doorheen loopen:

```php
<?php foreach ($projects as $project): ?>
    <h2><?php echo htmlspecialchars($project['title']); ?></h2>
    <p><?php echo htmlspecialchars($project['short_description']); ?></p>
<?php endforeach; ?>
```

`foreach` is een loop die voor elk project in de array de HTML binnen de loop afdrukt. Als je 9 projecten hebt, krijg je 9 `<h2>` elementen.

### Wat is `htmlspecialchars`?

`htmlspecialchars()` zorgt dat gevaarlijke tekens worden omgezet in onschuldige. Bijvoorbeeld: `<` wordt `&lt;`.

Waarom? Stel iemand voegt een project toe met als titel `<script>alert('haha')</script>`. Zonder `htmlspecialchars` wordt dat echt uitgevoerd in de browser. Met `htmlspecialchars` wordt het gewoon als tekst getoond.

> **Vergelijking:** `htmlspecialchars` is als een douanebeambte. Hij haalt alle wapens uit de koffer voordat hij hem doorlaat naar de pagina.

---

## Hoofdstuk 10 — De overzichtspagina dynamisch maken

Nu bouwen we `index.php`.

### Basisstructuur

```php
<?php
require_once 'database.php';
$pageTitle = 'Portfolio - Overzicht';

$stmt = $pdo->prepare("SELECT * FROM projects ORDER BY year DESC, id DESC");
$stmt->execute();
$projects = $stmt->fetchAll();

include 'includes/header.php';
?>

<div class="row row-cols-1 g-1 projects">
    <?php foreach ($projects as $project): ?>
        <div class="project card shadow-sm card-body m-2">
            <h2><?php echo htmlspecialchars($project['title']); ?></h2>
            <div><?php echo htmlspecialchars($project['short_description']); ?></div>
            <a href="detail.php?id=<?php echo (int)$project['id']; ?>">View</a>
        </div>
    <?php endforeach; ?>
</div>

<?php include 'includes/footer.php'; ?>
```

### Wat gebeurt hier?

1. `require_once 'database.php'` — laadt de PDO-verbinding. `require_once` zorgt dat het maar één keer wordt ingeladen (handig).
2. `$pageTitle` — een variabele die we in `header.php` gebruiken voor de browser-tab titel.
3. We halen alle projecten op.
4. `include 'includes/header.php'` — laadt de bovenkant van de pagina (nav, HTML-head).
5. We loopen door alle projecten en printen een kaartje.
6. `include 'includes/footer.php'` — laadt de onderkant (script-tag, closing tags).

### `include` vs `require`

- `include` → als het bestand niet bestaat, geeft een waarschuwing maar gaat door.
- `require` → als het bestand niet bestaat, **stopt** de pagina met een fatal error.
- `_once` → zorgt dat het bestand maar één keer wordt geladen.

Vuistregel: gebruik `require_once` voor essentiële bestanden (zoals `database.php`), en `include` voor stukjes HTML (zoals `header.php`).

### `ORDER BY`

```sql
ORDER BY year DESC, id DESC
```

Dit sorteert eerst op jaar (hoogste eerst, `DESC` = descending = aflopend), en als twee projecten in hetzelfde jaar zijn, op id (hoogste id eerst, dus nieuwste project).

### De link naar de detailpagina

```php
<a href="detail.php?id=<?php echo (int)$project['id']; ?>">View</a>
```

- `detail.php?id=5` → in de URL staat na het vraagteken `id=5`.
- `(int)` zet de waarde om naar een integer. Veiligheidstruc.
- Als iemand op deze link klikt, opent `detail.php` met in `$_GET['id']` het nummer 5.

> **Vergelijking:** De URL-parameters (`?id=5`) zijn als een briefje dat je meegeeft bij een bezoek: *"Hoi, ik kom voor project nummer 5."*

---

## Hoofdstuk 11 — De detailpagina

Nu `detail.php`. Hierin tonen we één project.

### De code

```php
<?php
require_once 'database.php';
$pageTitle = 'Project Detail';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$project = null;
if ($id > 0) {
    $stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
    $stmt->execute([$id]);
    $project = $stmt->fetch();
}

include 'includes/header.php';
?>

<?php if (!$project): ?>
    <div class="alert alert-warning">Project niet gevonden.</div>
<?php else: ?>
    <h2><?php echo htmlspecialchars($project['title']); ?></h2>
    <p><?php echo htmlspecialchars($project['description']); ?></p>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
```

### De belangrijkste regel

```php
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
```

Dit is een **ternary operator**. Hij werkt zo:

```
voorwaarde ? waarde_als_true : waarde_als_false
```

Dus hier: *"Als `$_GET['id']` bestaat, cast hem naar integer. Anders gebruik 0."*

Dit is korter dan:

```php
if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
} else {
    $id = 0;
}
```

### `isset()` uitgelegd

`isset($_GET['id'])` → **"bestaat de variabele `$_GET['id']` en is-ie niet null?"**

Dit voorkomt een "Undefined array key" waarschuwing wanneer iemand `detail.php` opent zonder `?id=...`.

### Prepared statement met parameter

```php
$stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
$stmt->execute([$id]);
```

Zie je dat `?` in de query? Dat is een **placeholder**. We vullen hem later in met de echte waarde.

**Waarom niet gewoon zo:**
```php
$stmt = $pdo->query("SELECT * FROM projects WHERE id = $id");  // NIET DOEN
```

Omdat dat **SQL injection** mogelijk maakt. Als iemand `?id=1; DROP TABLE projects` in de URL zet, is je tabel weg. Je zit huilend in een hoekje. Je docent is boos.

Prepared statements voorkomen dit. De `?` wordt veilig vervangen door de waarde, zonder dat MySQL hem als SQL-code ziet.

> **Vergelijking:** Een prepared statement is als een invulformulier bij een bank. Je mag alleen in de daarvoor bestemde vakjes schrijven. Je kunt geen briefje in de kluis stoppen met *"Geef mij al het geld, b.v.d."*.

### `fetch()`

```php
$project = $stmt->fetch();
```

We verwachten maar één resultaat (want `id` is uniek), dus `fetch()` is genoeg. `$project` is nu óf een array met de projectdata, óf `false` als er niks gevonden werd.

### De `if (!$project)` check

Als `$project` leeg is (false), is er geen project gevonden. We tonen dan een vriendelijke melding in plaats van een crash.

Dit is belangrijk voor:
- `detail.php` zonder id → 404-ish melding.
- `detail.php?id=99999` → id bestaat niet → nette melding.
- `detail.php?id=banaan` → `(int)'banaan'` wordt `0` → nette melding.

---

## Hoofdstuk 12 — Zoeken toevoegen

Nu willen we kunnen zoeken op titel.

### Het zoekformulier

```html
<form method="get" action="index.php">
    <input type="search" name="search" placeholder="Zoek op titel...">
    <button type="submit">Zoeken</button>
</form>
```

- `method="get"` → de zoekterm komt in de URL (bijv. `index.php?search=portfolio`). Handig want je kunt de URL delen of bookmarken.
- `name="search"` → in PHP wordt dit `$_GET['search']`.

### GET vs POST

- **GET** → data komt in de URL. Zichtbaar. Deelbaar. Bedoeld voor zoeken, filteren, pagination.
- **POST** → data komt in de body van de request. Niet zichtbaar in de URL. Bedoeld voor dingen die iets veranderen (login, create, update, delete).

Vuistregel:
- "Haalt dit data op?" → GET
- "Verandert dit data?" → POST

### Zoeken in PHP

```php
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

if ($search !== '') {
    $stmt = $pdo->prepare("SELECT * FROM projects WHERE title LIKE ?");
    $stmt->execute(["%" . $search . "%"]);
} else {
    $stmt = $pdo->prepare("SELECT * FROM projects");
    $stmt->execute();
}
$projects = $stmt->fetchAll();
```

### Wat is `LIKE` en `%`?

- `=` → exact gelijk. `WHERE title = 'Portfolio'` → alleen rijen waar de titel letterlijk `Portfolio` is.
- `LIKE` → zoeken met jokertekens.
- `%` → nul of meer tekens.

Dus:
- `LIKE 'Portfolio%'` → begint met Portfolio.
- `LIKE '%Portfolio'` → eindigt op Portfolio.
- `LIKE '%Portfolio%'` → bevat Portfolio ergens.

Wij gebruiken `%...%` omdat we willen dat de zoekterm **ergens** in de titel kan staan.

### `trim()`

`trim($_GET['search'])` → haalt spaties aan het begin en eind weg. Als iemand "   portfolio   " typt, wordt dat "portfolio".

---

## Hoofdstuk 13 — Filteren op jaar

Nu willen we projecten kunnen filteren op jaar.

### Het idee

Een `<select>` met alle beschikbare jaren. De gebruiker kiest een jaar, en we tonen alleen die projecten.

### Jaren uit de database halen

```php
$yearsStmt = $pdo->query("SELECT DISTINCT year FROM projects ORDER BY year DESC");
$years = $yearsStmt->fetchAll();
```

- `DISTINCT year` → geef elk jaar maar één keer terug. Als je 5 projecten uit 2026 hebt, krijg je 2026 maar één keer in de lijst.
- `$pdo->query()` → een snelle manier als je géén gebruikersinput gebruikt. Hier is `SELECT DISTINCT year FROM projects` 100% statisch, dus veilig.

### Het dropdown-menu

```html
<select name="year">
    <option value="">Alle jaren</option>
    <?php foreach ($years as $y): ?>
        <option value="<?php echo htmlspecialchars($y['year']); ?>"
            <?php echo ($filterYear == $y['year']) ? 'selected' : ''; ?>>
            <?php echo htmlspecialchars($y['year']); ?>
        </option>
    <?php endforeach; ?>
</select>
```

Dat `selected`-stukje is slim: als de huidige filter 2026 is, krijgt `<option value="2026">` het `selected` attribuut, zodat de dropdown onthoudt wat de gebruiker had gekozen na een reload.

### Zoeken + filter combineren

Hier wordt het interessant. We willen beide tegelijk kunnen gebruiken.

```php
$where  = [];
$params = [];

if ($search !== '') {
    $where[]  = "title LIKE ?";
    $params[] = "%" . $search . "%";
}

if ($filterYear !== '') {
    $where[]  = "year = ?";
    $params[] = $filterYear;
}

$whereSql = '';
if (count($where) > 0) {
    $whereSql = "WHERE " . implode(" AND ", $where);
}

$sql = "SELECT * FROM projects $whereSql ORDER BY year DESC, id DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$projects = $stmt->fetchAll();
```

### Wat gebeurt hier?

We bouwen de WHERE-clausule **dynamisch** op, afhankelijk van wat de gebruiker heeft gekozen.

**Scenario 1:** Niets ingevuld → `$where` blijft leeg → geen WHERE → alle projecten.

**Scenario 2:** Alleen zoeken → `$where = ["title LIKE ?"]` → `WHERE title LIKE ?`.

**Scenario 3:** Alleen jaar → `$where = ["year = ?"]` → `WHERE year = ?`.

**Scenario 4:** Beide → `$where = ["title LIKE ?", "year = ?"]` → `WHERE title LIKE ? AND year = ?`.

`implode(" AND ", $where)` plakt de array-items aan elkaar met " AND " ertussen. Simpel maar effectief.

> **Vergelijking:** Je bouwt de query op zoals je een broodje bouwt. Zoeken? Doe wat sla erbij. Jaar filteren? Doe wat tomaat erbij. Beide? Lekker alles erbij.

### Waarom werkt `$params` zo?

Omdat je `$params` als array doorgeeft aan `execute()`, worden alle `?`-placeholders in volgorde ingevuld. Scenario 4 → `?` nummer 1 wordt `"%portfolio%"`, `?` nummer 2 wordt `2026`.

---

## Hoofdstuk 14 — Pagination (het engste hoofdstuk)

Oké. Pak koffie. Dit is lastig maar als je het eenmaal snapt, snap je het voor altijd.

### Het probleem

Stel je hebt 50 projecten. Je wil er niet 50 tegelijk tonen. Je wil 5 per pagina. Dan heb je dus 10 pagina's nodig.

### De benodigde variabelen

- `$page` = welke pagina de gebruiker nu bekijkt (1, 2, 3, ...)
- `$perPage` = hoeveel projecten per pagina (bij ons: 5)
- `$offset` = hoeveel projecten we **overslaan** vanaf het begin
- `$totalProjects` = totaal aantal projecten (nodig om te weten hoeveel pagina's er zijn)
- `$totalPages` = totaal aantal pagina's

### De magische formule

```php
$offset = ($page - 1) * $perPage;
```

Let op:
- Pagina 1 → offset = (1-1) × 5 = **0** → sla 0 over → toon project 1-5.
- Pagina 2 → offset = (2-1) × 5 = **5** → sla 5 over → toon project 6-10.
- Pagina 3 → offset = (3-1) × 5 = **10** → sla 10 over → toon project 11-15.

Zie je het patroon? Elke volgende pagina slaan we 5 extra over.

### De SQL

```sql
SELECT * FROM projects LIMIT 5 OFFSET 10
```

- `LIMIT 5` → geef maximaal 5 rijen terug.
- `OFFSET 10` → begin pas vanaf de 11e rij (dus sla de eerste 10 over).

### Hoeveel pagina's zijn er?

```php
$totalProjects = $pdo->query("SELECT COUNT(*) FROM projects")->fetchColumn();
$totalPages    = ceil($totalProjects / $perPage);
```

- `COUNT(*)` → telt het aantal rijen.
- `fetchColumn()` → geeft de eerste kolom van de eerste rij terug. Handig voor COUNT.
- `ceil()` → rondt naar boven af. Als je 13 projecten hebt en 5 per pagina, dan: 13/5 = 2.6 → ceil → 3 pagina's.

### De paginering-knoppen

```php
<ul class="pagination">
    <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
        <a class="page-link" href="?page=<?php echo $page - 1; ?>">Vorige</a>
    </li>

    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
            <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
        </li>
    <?php endfor; ?>

    <li class="page-item <?php echo ($page >= $totalPages) ? 'disabled' : ''; ?>">
        <a class="page-link" href="?page=<?php echo $page + 1; ?>">Volgende</a>
    </li>
</ul>
```

- `for` loopt van 1 tot `$totalPages`. Elke iteratie maakt één nummertje-knop.
- Als `$page == 1`, krijgt "Vorige" de class `disabled` (gegrijsd).
- De huidige pagina krijgt `active` (gemarkeerd).

### Pagination mét zoeken en filter

Dit is het lastige stukje. Als de gebruiker op pagina 2 is én zoekt op "portfolio" én filtert op jaar 2026, dan moet de volgende-knop ook alle drie meenemen.

Daarvoor maakte ik een handige functie:

```php
function buildUrl($page, $search, $year) {
    $params = [];
    if ($search !== '') $params['search'] = $search;
    if ($year !== '')   $params['year']   = $year;
    $params['page'] = $page;
    return 'index.php?' . http_build_query($params);
}
```

`http_build_query()` neemt een associatieve array en maakt er een URL-querystring van. Dus:

```php
['search' => 'portfolio', 'year' => '2026', 'page' => 2]
```

Wordt:

```
search=portfolio&year=2026&page=2
```

Perfect. En dan is de link:

```php
<a href="<?php echo buildUrl($page + 1, $search, $filterYear); ?>">Volgende</a>
```

> **Vergelijking:** Pagination is als een boek. `$perPage` is hoeveel pagina's per hoofdstuk. `$page` is welk hoofdstuk je nu leest. `$offset` is hoeveel pagina's je moet overslaan vanaf het begin om op het goede hoofdstuk te komen. En `$totalPages` is het aantal hoofdstukken. Zonder deze berekening zou je elke keer dat je verder wil lezen opnieuw bij pagina 1 beginnen.

---

## Hoofdstuk 15 — De users-tabel

Tijd voor login! We hebben een plek nodig om gebruikers op te slaan.

### De tabel

```sql
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(255) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

Nieuw hier:
- `NOT NULL` → deze kolom mag niet leeg zijn.
- `UNIQUE` → elke email mag maar één keer voorkomen. Als iemand zich al heeft geregistreerd met rody@example.com, kan niemand anders dat ook doen.

---

## Hoofdstuk 16 — Wachtwoorden veilig opslaan

### De gouden regel

**Sla NOOIT een wachtwoord op als gewone tekst in de database.**

Nooit. Echt niet. Niet "oh maar het is maar voor school". Nee. Niet.

Waarom? Als iemand toegang krijgt tot je database, heeft hij meteen alle wachtwoorden van alle gebruikers. En omdat mensen vaak hetzelfde wachtwoord op meerdere sites gebruiken, kan die hacker nu ook bij hun email, bank, Netflix, enz.

### Hashing

Een **hash** is een eenrichtings-versleuteling. Je kunt een wachtwoord erin stoppen, en er komt een onleesbare brei uit. Maar je kunt de hash niet "ontcijferen" terug naar het originele wachtwoord.

Voorbeeld:
- `admin123` → `$2y$12$Qxm/ew9gGIXt33amTLgIbeWTjy67qHz0Yab.F4KftajU7LkDwuyYe`

### `password_hash()`

```php
$hash = password_hash('admin123', PASSWORD_DEFAULT);
```

Dit maakt een veilige hash. Je slaat `$hash` op in de database, **niet** `'admin123'`.

### `password_verify()`

Bij het inloggen:

```php
if (password_verify($invoerWachtwoord, $hashUitDatabase)) {
    // wachtwoord klopt!
}
```

`password_verify()` neemt het ingevoerde wachtwoord, hasht het, en vergelijkt met de opgeslagen hash. Als ze matchen → correct wachtwoord.

> **Vergelijking:** Een wachtwoord opslaan als tekst is als je pincode op een bord in de etalage zetten. Een hash is als een afdruk van je vingerafdruk. Zelfs als iemand je afdruk steelt, kan hij er geen nieuwe vinger van maken.

### Hoe heb ik de testuser gemaakt?

```bash
php -r "echo password_hash('admin123', PASSWORD_DEFAULT);"
```

Dit printte de hash, en die heb ik in `database.sql` gezet:

```sql
INSERT INTO users (email, password) VALUES
('admin@portfolio.nl', '$2y$12$Qxm/ew9...');
```

Nu kan ik inloggen met `admin@portfolio.nl` + `admin123`.

---

## Hoofdstuk 17 — De loginpagina

### De flow

1. Gebruiker vult email + wachtwoord in.
2. Formulier verstuurt (POST) naar `login.php`.
3. PHP zoekt gebruiker op basis van email.
4. PHP controleert wachtwoord met `password_verify`.
5. Als correct: maak een session en stuur door naar overzicht.
6. Als incorrect: toon foutmelding.

### De code (vereenvoudigd)

```php
<?php
session_start();
require_once 'database.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id']    = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        header("Location: index.php");
        exit;
    } else {
        $error = 'E-mailadres of wachtwoord klopt niet.';
    }
}
?>
```

### `$_SERVER['REQUEST_METHOD']`

Dit vertelt of de pagina geopend is via GET (gewoon de pagina openen) of POST (het formulier is verzonden). We voeren de login-logica alleen uit als het POST is.

### `$_POST`

`$_POST['email']` → de waarde van `<input name="email">` uit het formulier.

Let op dat `name="email"` in de HTML overeenkomt met `$_POST['email']` in PHP. Als je `<input name="emeel">` schrijft (want typefout), krijg je `$_POST['emeel']` en gaat PHP huilen.

### `header("Location: ...")` + `exit`

- `header("Location: index.php")` → stuur de browser door naar een andere pagina.
- `exit` → stop meteen met de rest van de code uitvoeren.

**Belangrijk:** `header()` moet gebeuren vóórdat er HTML wordt geprint. Anders krijg je de beroemde "Headers already sent" error. Daarom staat alle PHP-logica bovenaan het bestand, en pas daarna de HTML.

> **Vergelijking:** `header("Location: ...")` is als een omleidingsbord op de weg. Je zegt tegen de browser: *"Niet rechtdoor, maar linksaf naar index.php."* En `exit` is de verkeersagent die daarna een stopteken geeft zodat je zeker niet rechtdoor rijdt.

---

## Hoofdstuk 18 — Sessions begrijpen

### Wat is een session?

Een **session** is een manier om informatie te onthouden tussen pagina's. Zonder sessions zou PHP bij elke pagina vergeten dat je al was ingelogd, en zou je op elke pagina opnieuw moeten inloggen. Nachtmerrie.

### `session_start()`

Elke pagina die sessions gebruikt moet beginnen met `session_start()`. **Vóór** elke HTML output.

```php
<?php
session_start();
// nu kun je $_SESSION gebruiken
```

### `$_SESSION`

Dit is een speciale array die blijft bestaan tussen pagina's. Alles wat je erin zet, kun je op andere pagina's uitlezen.

```php
$_SESSION['user_id']    = 1;
$_SESSION['user_email'] = 'admin@portfolio.nl';
```

Op een andere pagina:

```php
<?php
session_start();
if (isset($_SESSION['user_id'])) {
    echo "Hoi " . $_SESSION['user_email'];
}
```

> **Vergelijking:** Een session is als een polsbandje bij een festival. Bij de ingang (login) krijg je een bandje. Daarna kun je naar elke stage lopen en de beveiliging ziet aan je bandje: "Hé, deze mag naar binnen." Je hoeft niet steeds opnieuw je kaartje te laten zien.

### Hoe weet PHP wie wie is?

Elke bezoeker krijgt een unieke **session ID** die als cookie in de browser wordt opgeslagen. Bij elk request stuurt de browser die ID mee, en PHP koppelt die aan de juiste `$_SESSION`-data op de server.

Jij hoeft daar niks voor te doen. PHP regelt het allemaal.

### Beveiligde pagina's

```php
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
```

Dit is wat er in `includes/check_login.php` staat. Je zet dit bovenaan elke pagina die alleen voor ingelogde gebruikers is (add, edit, delete).

**LET OP:** HTML-knoppen verstoppen is NIET genoeg. Iemand kan altijd handmatig naar `add.php` surfen. Daarom moet je ook in PHP controleren.

---

## Hoofdstuk 19 — Logout

Dit is simpel.

```php
<?php
session_start();
$_SESSION = [];
session_destroy();
header("Location: index.php");
exit;
```

Wat gebeurt hier?
- `$_SESSION = []` → wis alle sessiedata.
- `session_destroy()` → vernietig de sessie zelf.
- Daarna sturen we de gebruiker terug naar het overzicht.

Polsbandje afgeknipt. Festival verlaten. Tot morgen.

---

## Hoofdstuk 20 — CREATE — project toevoegen

### Het idee

Een pagina `add.php` waar je:
1. Een formulier ziet.
2. Dat formulier invult en verstuurt.
3. PHP het project toevoegt aan de database.
4. Je terugkomt op het overzicht.

### De beveiliging eerst

```php
require_once 'includes/check_login.php';
```

Niet ingelogd? Dan word je meteen naar login gestuurd. Niemand komt verder in dit bestand als hij niet is ingelogd.

### Het formulier

```html
<form method="post" action="add.php" enctype="multipart/form-data">
    <input type="text" name="title" required>
    <input type="text" name="short_description" required>
    <textarea name="description" required></textarea>
    <input type="text" name="type" required>
    <input type="number" name="year" required>
    <input type="file" name="image">
    <button type="submit">Opslaan</button>
</form>
```

- `method="post"` → data gaat via POST (want we veranderen iets).
- `action="add.php"` → het formulier wordt naar `add.php` zelf verstuurd. We vangen hem daar op.
- `enctype="multipart/form-data"` → **nodig** voor file uploads. Zonder dit werkt `$_FILES` niet.

### Verwerking in PHP

```php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title             = trim($_POST['title'] ?? '');
    $short_description = trim($_POST['short_description'] ?? '');
    $description       = trim($_POST['description'] ?? '');
    $type              = trim($_POST['type'] ?? '');
    $year              = trim($_POST['year'] ?? '');

    // (validatie en upload hier)

    $stmt = $pdo->prepare(
        "INSERT INTO projects (title, short_description, description, type, year, image)
         VALUES (?, ?, ?, ?, ?, ?)"
    );
    $stmt->execute([$title, $short_description, $description, $type, $year, $imageName]);

    header("Location: index.php");
    exit;
}
```

### De null-coalescing operator `??`

```php
$title = trim($_POST['title'] ?? '');
```

`??` betekent: *"gebruik de linker waarde als die bestaat, anders de rechter."* Zo voorkomen we een "Undefined array key" waarschuwing als het veld niet is verzonden.

### Validatie

```php
if ($title === '') $errors[] = 'Titel is verplicht.';
```

We verzamelen fouten in een array. Als er aan het eind fouten zijn, voeren we de INSERT **niet** uit en tonen we de fouten boven het formulier.

---

## Hoofdstuk 21 — UPDATE — project aanpassen

Vergelijkbaar met toevoegen, maar met één extra stap: eerst de huidige data in het formulier zetten.

### De flow

1. URL `edit.php?id=5` → haal project 5 op uit database.
2. Vul formulier met huidige data.
3. Gebruiker past aan en verstuurt.
4. PHP voert UPDATE uit.
5. Terug naar detailpagina.

### Huidige data ophalen

```php
$id = (int) $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
$stmt->execute([$id]);
$project = $stmt->fetch();
```

### Formulier met huidige waarden

```html
<input type="text" name="title" value="<?php echo htmlspecialchars($project['title']); ?>">
```

Dankzij het `value`-attribuut staat de huidige titel al in het veld.

### De UPDATE query

```php
$stmt = $pdo->prepare(
    "UPDATE projects
     SET title = ?, short_description = ?, description = ?, type = ?, year = ?, image = ?
     WHERE id = ?"
);
$stmt->execute([$title, $short_description, $description, $type, $year, $newImageName, $id]);
```

Let op `WHERE id = ?` aan het eind! Zonder die update je ALLE projecten tegelijk. Dan ben je echt klaar.

> **Vergelijking:** Een UPDATE zonder WHERE is als een leraar die de hele klas een onvoldoende geeft omdat één leerling vals heeft gespeeld. Niet doen.

---

## Hoofdstuk 22 — DELETE — project verwijderen

### Simpel maar gevaarlijk

```php
require_once 'includes/check_login.php';
require_once 'database.php';

$id = (int) $_GET['id'];

if ($id > 0) {
    $stmt = $pdo->prepare("DELETE FROM projects WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: index.php");
exit;
```

### De bevestiging in de HTML

```html
<a href="delete.php?id=<?php echo $project['id']; ?>"
   onclick="return confirm('Weet je zeker dat je dit project wil verwijderen?');">Delete</a>
```

`onclick="return confirm(...)"` toont een JavaScript-popup. Alleen als de gebruiker op OK klikt, gaat de link door.

**Let op:** Dit is **gebruikersvriendelijkheid**, geen beveiliging. Iemand kan altijd de URL `delete.php?id=5` direct in de browser typen. De échte beveiliging is `check_login.php`.

### Afbeelding ook verwijderen

Als het project een afbeelding had, willen we die ook van de server verwijderen, anders blijven er loze bestanden rondzwerven:

```php
if (!empty($project['image']) && file_exists('uploads/' . $project['image'])) {
    unlink('uploads/' . $project['image']);
}
```

`unlink()` → PHP's manier om een bestand te verwijderen. Rare naam, maar het is wat het is.

---

## Hoofdstuk 23 — CRUD-beveiliging

Al drie keer genoemd, maar nog een keer, want dit is HEEL belangrijk.

### Dubbele beveiliging

**Niveau 1: HTML (gebruikersvriendelijk)**
```php
<?php if ($ingelogd): ?>
    <a href="edit.php?id=5">Edit</a>
<?php endif; ?>
```

De Edit-knop is onzichtbaar voor niet-ingelogde bezoekers.

**Niveau 2: PHP (echte beveiliging)**
```php
<?php require_once 'includes/check_login.php'; ?>
```

Zelfs als iemand de URL `edit.php?id=5` direct intypt, wordt hij naar login gestuurd.

### Alleen HTML is NIET genoeg

Veel beginners denken: "Als de knop onzichtbaar is, kan niemand erbij." Fout. Elke URL is te raden. Elke knop is te vinden met rechtsklik → Inspecteren. Dus beveilig altijd op de serverkant.

> **Vergelijking:** De HTML-check is als een bordje "verboden toegang" op een deur. De PHP-check is het slot op diezelfde deur. Je wil ze allebei, maar het slot is wat écht telt.

---

## Hoofdstuk 24 — File upload

Afbeeldingen uploaden! Dit is iets wat veel beginners spannend vinden.

### HTML eerst

```html
<form method="post" enctype="multipart/form-data">
    <input type="file" name="image" accept="image/*">
</form>
```

- `enctype="multipart/form-data"` → **absoluut noodzakelijk**. Zonder dit krijgt PHP geen bestand. Vergeet dit nooit.
- `accept="image/*"` → de browser filtert alleen afbeeldingen in het bestand-selectie-venster. Dit is UX, geen beveiliging — PHP moet nog steeds controleren.

### `$_FILES`

Als iemand een bestand uploadt, zet PHP de info in `$_FILES['image']`:

```php
$_FILES['image']['name']     // originele bestandsnaam
$_FILES['image']['tmp_name'] // tijdelijke locatie op de server
$_FILES['image']['size']     // grootte in bytes
$_FILES['image']['error']    // 0 als alles goed ging, anders een foutcode
$_FILES['image']['type']     // MIME-type (bijv. 'image/jpeg')
```

### De upload-code

```php
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $allowed = ['jpg', 'jpeg', 'png', 'webp'];
    $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed)) {
        $errors[] = 'Alleen jpg, jpeg, png of webp.';
    } else {
        $imageName = uniqid('project_', true) . '.' . $ext;
        move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $imageName);
    }
}
```

### Regel voor regel

**`UPLOAD_ERR_OK`** → een constante die gelijk is aan 0. Betekent: geen upload-fout.

**`pathinfo(..., PATHINFO_EXTENSION)`** → haalt de bestandsextensie op. Van `vakantie.JPG` → `JPG`.

**`strtolower(...)`** → maakt alles kleine letters. `JPG` → `jpg`.

**`in_array($ext, $allowed)`** → *"zit `$ext` in de array `$allowed`?"* Zo niet, dan weigeren we het bestand.

**`uniqid('project_', true)`** → genereert een unieke string zoals `project_6520f3a81d5e82.12345678`. Zo kunnen twee gebruikers allebei een bestand "vakantie.jpg" uploaden zonder dat de één de ander overschrijft.

**`move_uploaded_file()`** → verplaatst het bestand van de tijdelijke locatie naar jouw `uploads/` map. Gebruik ALTIJD deze functie, niet `rename()`, want deze doet veiligheidschecks.

### Waarom alleen de bestandsnaam in de database?

We slaan de bestandsnaam (`project_abc123.jpg`) op in de database, **niet** de hele afbeelding. Het bestand zelf staat op de server in `uploads/`.

**Waarom?**
- Databases zijn traag voor binaire data.
- Je kunt het bestand niet in `<img src="">` tonen zonder extra PHP-rondjes.
- Je bespaart ruimte in je database.

### Oude afbeelding behouden bij edit

Bij edit:
```php
$newImageName = $currentImage;  // standaard: huidige afbeelding

if (nieuwe afbeelding geüpload) {
    $newImageName = de nieuwe naam;
    unlink('uploads/' . $currentImage);  // oude weggooien
}
```

Zo blijft de bestaande afbeelding gewoon staan als je er geen nieuwe uploadt. Belangrijk voor je gebruikerservaring!

---

## Hoofdstuk 25 — Afbeeldingen weergeven

### Op de overzichtspagina

```php
<?php if (!empty($project['image']) && file_exists('uploads/' . $project['image'])): ?>
    <img src="uploads/<?php echo htmlspecialchars($project['image']); ?>"
         alt="<?php echo htmlspecialchars($project['title']); ?>">
<?php endif; ?>
```

### Wat gebeurt hier?

- `!empty($project['image'])` → controleer dat de kolom gevuld is.
- `file_exists(...)` → controleer dat het bestand ook écht op schijf staat (anders krijg je een gebroken plaatje).
- `src="uploads/..."` → de browser gaat zelf een nieuw request doen naar die URL om de afbeelding op te halen.
- `alt="..."` → tekst voor screenreaders én als de afbeelding niet laadt.

### CSS voor nette afbeeldingen

```css
.project-thumb {
    width: 120px;
    height: 90px;
    object-fit: cover;
    border-radius: 6px;
}
```

`object-fit: cover` → zorgt dat de afbeelding de ruimte volledig vult zonder dat hij uitgerekt wordt. Hij wordt bijgesneden als dat nodig is.

---

## Hoofdstuk 26 — Help, hij doet het niet! (veelvoorkomende fouten)

Oké. Je bent kapot. Niks werkt. Rustig blijven. Hier zijn de meest voorkomende fouten en wat ze betekenen.

### "Undefined variable: $foo"

**Betekenis:** Je gebruikt een variabele die PHP nog nooit heeft gezien.

**Fix:**
- Kijk of je de variabele hebt aangemaakt vóór je hem gebruikt.
- Typfout? `$projetc` vs `$project`.

### "Undefined array key 'id'"

**Betekenis:** Je gebruikt `$_GET['id']` (of `$_POST['...']`), maar die bestaat niet.

**Fix:**
```php
$id = $_GET['id'] ?? 0;  // gebruik ?? of isset()
```

### "Headers already sent by (output started at ...)"

**Betekenis:** Je probeert `header()`, `session_start()`, of `setcookie()` aan te roepen nadat er al HTML/output is geprint.

**Fix:**
- Zet alle PHP-logica BOVENAAN het bestand, vóór de HTML.
- Check op lege regels of spaties vóór `<?php`.
- Geen `echo` of HTML vóór een `header()` call.

### "SQLSTATE[42S02]: Base table or view not found"

**Betekenis:** De tabel bestaat niet.

**Fix:**
- Database geïmporteerd? Check in phpMyAdmin.
- Typefout in de tabelnaam?

### "SQLSTATE[HY000] [1045] Access denied for user 'root'@'localhost'"

**Betekenis:** Verkeerd wachtwoord of username.

**Fix:** Check `database.php` → `$username` en `$password`.

### "SQLSTATE[HY000] [2002] Connection refused"

**Betekenis:** MySQL draait niet, of je host is verkeerd.

**Fix:**
- Draait je Docker/MAMP?
- Is je host `mysql_db` (Docker) of `localhost` (MAMP/XAMPP)?

### "Call to undefined function password_hash()"

**Betekenis:** Je PHP-versie is zó oud dat `password_hash` niet bestaat (pre-PHP 5.5).

**Fix:** Update PHP. Je draait vast ergens iets uit 2013.

### Afbeelding wordt niet geüpload

**Checks:**
- Staat `enctype="multipart/form-data"` in je form?
- Heeft je input `name="image"`?
- Bestaat de `uploads/` map?
- Heeft de `uploads/` map schrijfrechten?

### `$_POST` is leeg

**Checks:**
- Staat `method="post"` in je form?
- Heeft elke input een `name=""` attribuut?
- Spelling van `name=""` moet exact matchen met `$_POST['...']`.

### Je ziet rare karakters zoals "Ã©" in plaats van "é"

**Betekenis:** Character encoding mismatch.

**Fix:**
- Database op `utf8mb4`.
- Verbinding op `charset=utf8mb4`.
- HTML: `<meta charset="UTF-8">`.

### "Project niet gevonden" terwijl het wel bestaat

**Checks:**
- Correct ID in de URL?
- `fetch()` returned false → geen match. Query handmatig testen in phpMyAdmin: `SELECT * FROM projects WHERE id = 1;`

### Pagina is helemaal wit

**Betekenis:** Fatale PHP-fout, maar error reporting staat uit.

**Fix:** Tijdelijk bovenaan je script:
```php
ini_set('display_errors', 1);
error_reporting(E_ALL);
```

Nu zie je de echte fout. Haal dit weer weg als het werkt (zeker in productie).

---

## Hoofdstuk 27 — Git — committen en pushen

### Wat is Git?

Git is een systeem dat de geschiedenis van je code bijhoudt. Elke keer dat je iets wijzigt, kun je een "snapshot" maken (een commit). Je kunt altijd terug naar een oude versie.

### De basics

```bash
git init                         # maak een nieuwe git repository
git add .                        # voeg alle bestanden toe aan de volgende commit
git commit -m "Beschrijving"     # maak de snapshot
git push                         # upload naar GitHub/GitLab
```

### Een goede commit per stap

Voor dit project zouden je commits er zo uit kunnen zien:

```bash
git commit -m "Initial setup: HTML-template toegevoegd"
git commit -m "Database en PDO-verbinding toegevoegd"
git commit -m "Overzichtspagina dynamisch gemaakt"
git commit -m "Detailpagina toegevoegd"
git commit -m "Zoekfunctie toegevoegd"
git commit -m "Filter op jaar toegevoegd"
git commit -m "Pagination toegevoegd"
git commit -m "Users tabel + login + logout toegevoegd"
git commit -m "CRUD toegevoegd (add/edit/delete)"
git commit -m "File upload toegevoegd"
git commit -m "Beveiliging voor CRUD-pagina's"
```

### Tip voor goede commit messages

- **Kort maar duidelijk**: "Zoekfunctie toegevoegd" ✓, niet "stuff" ✗.
- **In de tegenwoordige tijd of imperatief**: "Add search" of "Zoekfunctie toegevoegd".
- **Eén logische wijziging per commit**: niet 15 features in één commit proppen.

### `.gitignore`

Niet alles wil je in Git. Maak een `.gitignore` bestand:

```
uploads/*
!uploads/.gitkeep
.DS_Store
*.log
```

- `uploads/*` → sla geüploade bestanden niet op.
- `!uploads/.gitkeep` → maar hou de lege map wel bij.
- `.DS_Store` → macOS systeembestanden, nee dankje.

---

## Hoofdstuk 28 — Eindcontrole

Voordat je dit inlevert, check alles.

### Functionaliteit

- [ ] Overzichtspagina laat alle projecten zien.
- [ ] Zoeken op titel werkt.
- [ ] Filteren op jaar werkt.
- [ ] Zoeken + filter werkt samen.
- [ ] Pagination werkt (ga naar pagina 2).
- [ ] Pagination behoudt zoekwoord/filter.
- [ ] Detailpagina werkt.
- [ ] Niet-bestaand project toont nette melding (geen crash).
- [ ] Inloggen met correct wachtwoord werkt.
- [ ] Inloggen met verkeerd wachtwoord geeft foutmelding.
- [ ] Uitloggen werkt.
- [ ] Zonder login: Edit/Delete/Toevoegen knoppen onzichtbaar.
- [ ] Zonder login: handmatig naar `add.php` → redirect naar login.
- [ ] Zonder login: handmatig naar `edit.php?id=1` → redirect naar login.
- [ ] Zonder login: handmatig naar `delete.php?id=1` → redirect naar login.
- [ ] Met login: project toevoegen werkt (met en zonder afbeelding).
- [ ] Met login: project aanpassen werkt.
- [ ] Met login: afbeelding behoudt wanneer je geen nieuwe uploadt.
- [ ] Met login: project verwijderen werkt (met bevestiging).

### Code-kwaliteit

- [ ] Alle queries gebruiken PDO (geen `mysql_*`).
- [ ] Alle queries met gebruikersinput gebruiken prepared statements.
- [ ] Wachtwoorden met `password_hash` opgeslagen.
- [ ] Alle output met `htmlspecialchars` tegen XSS.
- [ ] Geen PHP-errors of warnings in de pagina.
- [ ] Code is leesbaar met heldere variabelnamen.
- [ ] Comments waar nodig (niet overdreven).

### Git

- [ ] Project staat in een repository.
- [ ] Logische commits per feature.
- [ ] `.gitignore` zodat er geen rommel in staat.
- [ ] Gepusht naar remote (GitHub/GitLab).

---

## Afsluitend

Zo. Je bent erdoor.

Als je dit allemaal gelezen én begrepen hebt (het mag ook twee keer), dan weet je nu:
- Hoe PHP en MySQL samenwerken.
- Hoe PDO werkt en waarom het veilig is.
- Hoe je CRUD-functionaliteit bouwt.
- Hoe je sessions gebruikt voor login.
- Hoe je afbeeldingen upload.
- Waarom je *altijd* dubbel beveiligt.
- Wat te doen als iets kapot gaat.

Dit project is geen simpele hobby-opdracht. Dit zijn de echte, serieuze bouwstenen van elke webapplicatie. Of je nou later een webshop bouwt, een social media platform of een boekingssysteem — het begint allemaal met deze basics.

En vergeet niet: elke senior developer heeft ooit zitten huilen om een `Headers already sent` error. Jij ook, binnenkort. En dan los je het op. En dan ga je door. Zo leer je programmeren.

Succes met inleveren.

— Je PHP-docent-in-tekstvorm 🧠📚

*(Oké één emoji dan toch.)*
