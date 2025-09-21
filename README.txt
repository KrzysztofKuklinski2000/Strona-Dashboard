# Karate Club CMS

System zarządzania treścią (CMS) dla strony klubu karate.  
Projekt zawiera **publiczną stronę** (aktualności, galeria, grafik, obozy, opłaty, kontakt) oraz **panel administracyjny** dla zarządzania treściami.  

---

## 🚀 Funkcjonalności

- **Panel administracyjny**
  - CRUD dla: aktualności, galerii, grafiku, obozów, ważne postów, postów na stronie głównej
  - Aktualizacja zakładek: opłat, kontaktu
  - Obsługa uploadu plików (zdjęcia w galerii) z walidacją
  - Komunikaty flash dla użytkowników
  - Ochrona CSRF
  - System logowania 

- **Strona publiczna**
  - Wyświetlanie danych na stronie 
  - Sortowanie galerii
  - Responsywny wygląd

- **Bezpieczeństwo**
  - Walidacja danych wejściowych
  - Weryfikacja tokenów CSRF

---

## 🛠️ Technologie

- PHP
- Javascript
- HTML
- CSS
- MySQL
- RWD
- EasyCSRF (obsługa tokenów)  
- Własna architektura MVC  

---

## 📂 Struktura projektu
├── config/ # Konfiguracja (baza danych, ustawienia środowiska)
├── public/ # Pliki publiczne (CSS, JS, obrazy)
├── src/
│ ├── Controller/ # Kontrolery
│ ├── Repository/ # Repozytoria (zapytania SQL)
│ ├── Service/ # Logika biznesowa
│ ├── Middleware/ # Middleware (np. CSRF)
│ ├── Core/ # Klasy bazowe (ControllerFactory, ErrorHandler)
│ └── Exception/ # Własne wyjątki
| └── Traits/ # Pobieranie danych z formularzy
| └── Request.php/ # Klasa obsługująca żądania HTTP (GET, POST, FILES)
| └── Views.php/ # Klasa odpowiedzialna za renderowanie widoków
├── templates/ # Widoki
└── vendor/ # Zależności (Composer)
└── index.php 