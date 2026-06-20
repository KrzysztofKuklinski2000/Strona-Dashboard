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

## Instalacja

1. **Sklonuj repozytorium**:
   ```bash
   git clone https://github.com/KrzysztofKuklinski2000/Strona-Dashboard.git
   cd Strona-Dashboard
   ```

2. **Utwórz lokalny plik konfiguracyjny**:
   ```bash
   cp config/config.example.php config/config.php
   ```

   Plik `config/config.php` jest ignorowany przez Git, dlatego trzeba utworzyć go lokalnie po sklonowaniu projektu.

3. **Uruchom projekt w Dockerze**:
   ```bash
   docker compose up --build -d
   ```

   Kontener PHP instaluje zależności Composera automatycznie, jeśli katalog `vendor/` nie istnieje.

4. **Otwórz aplikację w przeglądarce**:
   - strona: http://localhost:8000
   - panel administracyjny: http://localhost:8000/dashboard/start
   - phpMyAdmin: http://localhost:8080
   - Mailpit: http://localhost:8025

5. **Dane bazy danych w Dockerze**:
   - host: `db`
   - baza: `karate`
   - użytkownik: `user_karate`
   - hasło: `haslo`
   - port MySQL na hoście: `3307`

   Baza inicjalizuje się automatycznie z pliku `docker/db/init.sql` przy pierwszym uruchomieniu kontenerów.

6. **Zatrzymanie projektu**:
   ```bash
   docker compose down
   ```

   Jeśli chcesz odtworzyć bazę od zera z pliku `docker/db/init.sql`, usuń również wolumen:
   ```bash
   docker compose down -v
   docker compose up --build -d
   ```

dashboard dane do logowania (http://localhost/dashboard/start)
login: test
hasło: test123
