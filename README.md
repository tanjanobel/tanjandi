# Tanjandi Theme

Ein modernes WordPress Block Theme (Full Site Editing) als Entwicklungsbasis mit Fokus auf Performance, saubere Struktur und Gutenberg-Kompatibilität.

## Features

- **Moderne Build-Pipeline:** Webpack für JS-Bundling und SCSS-Kompilierung.
- **Block Theme / FSE:** Nutzt `templates/` und `parts/` (Full Site Editing) sowie `theme.json` für Styles/Einstellungen.
- **Saubere Struktur:** Klare Trennung von Source (`/src`) und Build-Output (Theme-Root).
- **Vanilla JS:** Kein jQuery-Zwang, moderne ES Modules.
- **Best Practices:** Internationalisierung vorbereitet, Cache-Busting via `filemtime`.

## Installation

1. Navigiere in den Theme-Ordner: `wp-content/themes/tanjandi`
2. Installiere die Abhängigkeiten:
   ```bash
   npm install
   ```

## Development Commands

- **Entwicklung (einmalig):**
  ```bash
  npm run dev
  ```
- **Watcher (für die Entwicklung):**
  ```bash
  npm run watch
  ```
- **Produktions-Build (Minified & Optimiert):**
  ```bash
  npm run build
  ```

## Ordnerstruktur

- `/src`: Quellcode (JS, SCSS, Assets)
  - `/scss`: SCSS-Architektur (Settings, Core, Components)
  - `/js`: Vanilla JS Module
- `/inc`: Ausgelagerte PHP-Logik (z.B. Gutenberg-Settings)
- `/templates`: Block-Templates (z.B. `index.html`, `single.html`, `page.html`, `archive.html`, `404.html`)
- `/parts`: Template Parts (z.B. `header.html`, `footer.html`)
- `/fonts`, `/icons`, `/images`: Assets
- `style.css`: Finales CSS (wird generiert)
- `app.js`: Finales JS (wird generiert)

## Konventionen

- **CSS:** Properties sind alphabetisch sortiert (über Stylelint/Konfiguration).
- **JS:** Nutzt ES Modules und Webpack für den Import von Komponenten.
- **Gutenberg:** Einstellungen erfolgen primär über `theme.json` und `inc/gutenberg.php`.

## Theme Header

Der WordPress Theme-Header in `style.css` wird automatisch über das `BannerPlugin` in der `webpack.config.js` verwaltet. Änderungen am Theme-Namen oder Autor sollten dort angepasst werden.

## Hinweise zur Nutzung als Block Theme

- Navigation erfolgt über den WordPress Navigations-Block (keine klassischen Menüs registriert).
- Globale Styles und Presets werden in `theme.json` gepflegt.
- Eigene CSS-Anpassungen können weiterhin in `style.css` erfolgen; diese ergänzen die `theme.json` Styles.

## Lizenz

Dieses Projekt ist privat und darf von niemandem außer dem Eigentümer genutzt werden. (`UNLICENSED`)
