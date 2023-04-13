# Dokumentace aplikace pro generování tabulek ASEP

Tento dokument obsahuje informace o aplikaci pro generování tabulek ASEP. Aplikace slouží k zobrazování dat z Google Sheets tabulek na webové stránce ASEP (`https://asep-portal.lib.cas.cz/pro-zpracovatele/riv/konecne-soubory/`).

## Adresářová struktura

Aplikace se nachází v následujícím adresáři na serveru: `https://asep-portal.lib.cas.cz/wp/tabulky-asep/`.

V tomto adresáři se nachází soubor `generate.php`, který slouží k vygenerování tabulek.

## Spuštění generování tabulek

Generování tabulek lze spustit pomocí CRON jobu, který se spouští na adrese `https://asep-portal.lib.cas.cz/wp/tabulky-asep/generate.php?id=<document-id>`.

Pokud se adresa zavolá bez parametru id, server vrátí chybovou hlášku s HTTP status kódem 404.

## Přístup k tabulkám Google Sheets

Pro použití této aplikace je nutné mít přístup k Google Sheets tabulkám.

Je nutné vytvořit Google API klíč v Google Cloud Platform pro Google Drive a ten použít pro ověření přístupu k tabulkám.

API klíč se vytvoří následovně:

1. Otevřete Google Cloud Console: `https://console.cloud.google.com/`;
2. Vytvořte projekt a pojmenujte ho;
3. Klikněte na tlačítko "CREATE CREDENTIALS";
4. Vyplňte formulář pro službu "Google Drive API".

## Konfigurace aplikace

Konfigurace aplikace se provádí pomocí souboru documents.json, který se nachází v adresáři `/wp/tabulky-asep/documents.json`.

V tomto souboru je nutné vytvořit položku pro každou tabulku, která se má zobrazovat na webu. Položka musí obsahovat název tabulky, identifikátor tabulky a název shortcode, který se bude používat pro zobrazení tabulky. Dále je nutné určit, zda se má tabulka zobrazovat na webu.

Konkrétně se jedná o následující strukturu (`/wp/tabulky-asep/documents.json`):

`
{
    "title": "<název tabulky>", 
    "id": "<identifikátor tabulky>" 
    "shortcode": "<název shortcodu>", 
    "active": true //true nebo false. 
}
`

Spustit generování souboru .html návštěvou https://asep-portal.lib.cas.cz/wp/tabulky-asep/generate.php?id=<document-id> pro generování a získání názvu souboru .html.

A vložit kód pro vytvoření zkráceného kódu do souboru functions.php:

`
add_shortcode('<název shortcodu>', function () {
    ob_start();
    require ABSPATH . 'tabulky-asep/output/<název souboru>.html';  
    return ob_get_clean();
});
`

## Šablony

Pro stránku `https://asep-portal.lib.cas.cz/pro-zpracovatele/riv/konecne-soubory/` používáme šablonu s názvem "Table" (`table-template.php`), která se nachází v adresáři `/wp/wp-content/themes/knav3/`. V této šabloně je umístěn zkrácený kód `<název shortcodu>`.
