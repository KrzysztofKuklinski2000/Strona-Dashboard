<?php
use App\Privacy\SubscriptionPrivacy;
?>
<article class="subscription-privacy" aria-labelledby="privacy-scope-title">
    <p class="subscription-privacy__version">Wersja zgody na powiadomienia: <?= e(SubscriptionPrivacy::VERSION) ?></p>

    <h2 id="privacy-scope-title">Powiadomienia, pliki cookies i statystyki odwiedzin</h2>
    <p>
        Ta informacja dotyczy formularza powiadomień o zmianach grafiku treningów
        oraz własnych plików cookies i statystyk odwiedzin naszej strony.
        Zapis jest dobrowolny i nie jest warunkiem uczestnictwa w zajęciach.
        Nie wykorzystujemy tej listy do wysyłania reklam ani ofert.
    </p>

    <section aria-labelledby="privacy-controller">
        <h2 id="privacy-controller">Kto odpowiada za dane?</h2>
        <p>
            Administratorem danych jest <?= e(SubscriptionPrivacy::CONTROLLER_NAME) ?>.
            Adres kontaktowy: <?= e(SubscriptionPrivacy::CONTROLLER_ADDRESS) ?>.
            W sprawach danych osobowych napisz na
            <a href="mailto:<?= e(SubscriptionPrivacy::CONTACT_EMAIL) ?>"><?= e(SubscriptionPrivacy::CONTACT_EMAIL) ?></a>
            lub skontaktuj się z nami listownie pod podanym adresem.
        </p>
    </section>

    <section aria-labelledby="privacy-purpose">
        <h2 id="privacy-purpose">Jakie dane wykorzystujemy do powiadomień?</h2>
        <p>
            Korzystamy z podanego adresu e-mail, aby wysłać prośbę o potwierdzenie zapisu,
            a po potwierdzeniu — powiadomienia o zmianach grafiku. Podstawą przetwarzania
            w tym celu jest Twoja zgoda (art. 6 ust. 1 lit. a RODO).
            Bez adresu e-mail i zgody nie możemy uruchomić powiadomień.
        </p>
        <p>
            Z adresem zapisujemy status subskrypcji, datę wyrażenia i potwierdzenia zgody,
            jej treść i wersję oraz identyfikatory techniczne potrzebne do potwierdzenia zapisu
            i wypisania. Treść i daty zgody pozwalają wykazać, na jakich zasadach uruchomiono
            powiadomienia. Podstawą przechowywania zapisu zgody jest obowiązek
            jej wykazania (art. 6 ust. 1 lit. c w związku z art. 7 ust. 1 RODO).
        </p>
        <p>
            Nie wymagamy imienia, nazwiska ani numeru telefonu. Formularz nie służy do
            przekazywania informacji o zdrowiu ani danych uczestników zajęć.
        </p>
    </section>

    <section aria-labelledby="privacy-retention">
        <h2 id="privacy-retention">Jak długo przechowujemy dane powiadomień?</h2>
        <ul>
            <li>
                <strong>Przed potwierdzeniem:</strong> link jest ważny 24 godziny.
                Niepotwierdzone zapisy z wygasłym linkiem usuwamy podczas codziennego
                przeglądu. Ponowna prośba o potwierdzenie przed usunięciem zapisu
                rozpoczyna nowy okres ważności linku.
            </li>
            <li>
                <strong>Po potwierdzeniu:</strong> do cofnięcia zgody lub zakończenia
                usługi powiadomień, zależnie od tego, co nastąpi wcześniej.
                Wypisanie usuwa rekord subskrypcji z bazy używanej do wysyłki.
            </li>
            <li>
                <strong>Kopie zapasowe:</strong> dane mogą pozostać w zabezpieczonych
                kopiach do zakończenia cyklu ich nadpisania lub usunięcia.
                Nie korzystamy z kopii do bieżącej wysyłki. Zasady kopii usługodawcy
                opisuje <a href="https://pomoc.mydevil.net/Backup/">dokumentacja MyDevil.net</a>.
                Dodatkowe eksporty wykonane na potrzeby aktualizacji lub odtworzenia bazy
                usuwamy po zakończeniu tej operacji.
            </li>
        </ul>
    </section>

    <section aria-labelledby="privacy-withdrawal">
        <h2 id="privacy-withdrawal">Jak wyłączyć powiadomienia?</h2>
        <p>
            Zgodę możesz cofnąć w każdej chwili i bez opłat. W każdym powiadomieniu
            znajduje się link „Wypisz się tutaj”. Otwórz go i potwierdź wyłączenie
            powiadomień — nie potrzebujesz konta ani hasła.
            Możesz też poprosić o wypisanie, kontaktując się z klubem.
        </p>
        <p>
            Cofnięcie zgody nie wpływa na zgodność z prawem przetwarzania,
            którego dokonaliśmy na jej podstawie przed cofnięciem.
        </p>
    </section>

    <section aria-labelledby="privacy-recipients">
        <h2 id="privacy-recipients">Kto może mieć dostęp do danych?</h2>
        <p>
            Dostęp mają osoby upoważnione do obsługi strony i powiadomień oraz dostawcy
            usług technicznych w niezbędnym zakresie. Hosting, bazę danych
            i wysyłkę poczty zapewnia MyDevil.net — ADMIN.NET.PL Tomasz Rzepka
            Arkadiusz Nowara S.C. Nie publikujemy listy subskrybentów.
        </p>
        <p>
            Kontaktowy adres Gmail jest obsługiwany przez Google. Jeśli napiszesz
            na ten adres, Twoja korespondencja będzie przetwarzana także w ramach tej usługi.
            Google może przetwarzać dane poza Europejskim Obszarem Gospodarczym.
            Informacje o stosowanych mechanizmach przekazywania danych, w tym decyzjach
            stwierdzających odpowiedni stopień ochrony i standardowych klauzulach umownych,
            oraz o uzyskaniu kopii zabezpieczeń znajdują się w
            <a href="https://policies.google.com/privacy/frameworks?hl=pl">informacji Google o przekazywaniu danych</a>.
        </p>
    </section>

    <section aria-labelledby="privacy-rights">
        <h2 id="privacy-rights">Jakie masz prawa?</h2>
        <p>
            W granicach określonych przez RODO możesz żądać dostępu do danych,
            ich sprostowania, usunięcia, ograniczenia przetwarzania i przeniesienia.
            Możesz również cofnąć zgodę. W sprawie realizacji praw skontaktuj się
            z administratorem pod podanym wyżej adresem.
        </p>
        <p>
            Masz prawo wnieść skargę do
            <a href="https://uodo.gov.pl/">Prezesa Urzędu Ochrony Danych Osobowych</a>,
            jeśli uważasz, że przetwarzanie narusza przepisy.
        </p>
        <p>
            Na podstawie danych subskrypcji nie podejmujemy zautomatyzowanych decyzji
            wywołujących skutki prawne lub podobnie istotnie wpływających na Ciebie
            i nie prowadzimy profilowania.
        </p>
    </section>

    <section aria-labelledby="privacy-consent">
        <h2 id="privacy-consent">Treść zgody w tej wersji formularza</h2>
        <p><?= e(SubscriptionPrivacy::CONSENT_TEXT) ?></p>
        <p>Przed zapisem możesz zapoznać się z tą informacją bez zaznaczania zgody.</p>
    </section>

    <section id="privacy-cookies" aria-labelledby="privacy-cookies-title">
        <h2 id="privacy-cookies-title">Jakich własnych plików cookies używamy?</h2>
        <p>
            Cookies to niewielkie informacje zapisywane przez przeglądarkę.
            Rozróżniamy pliki potrzebne do działania strony i dobrowolne cookies statystyczne.
        </p>
        <ul>
            <li>
                <strong>Cookie sesji:</strong> służy m.in. do zabezpieczenia formularzy,
                obsługi komunikatów i logowania do panelu. Jest plikiem sesyjnym,
                bez ustawionego przez aplikację trwałego terminu ważności.
                Nie jest identyfikatorem naszego licznika statystyk.
            </li>
            <li>
                <strong>analytics_consent:</strong> zapamiętuje akceptację albo odmowę
                cookies statystycznych przez 365 dni od ostatniego zapisu decyzji.
                Nie służy do liczenia odwiedzin. Dzięki niemu nie pytamy o wybór
                przy każdym otwarciu strony.
            </li>
            <li>
                <strong>visitor_id:</strong> zawiera losowy identyfikator przeglądarki
                używany wyłącznie do statystyk. Powstaje dopiero po akceptacji,
                ma ważność do 365 dni od utworzenia i jest usuwany przy odmowie
                lub wycofaniu zgody. Nie zawiera imienia, nazwiska ani adresu e-mail.
            </li>
        </ul>
    </section>

    <section aria-labelledby="privacy-analytics">
        <h2 id="privacy-analytics">Jak działają statystyki odwiedzin?</h2>
        <p>
            Po wybraniu „Akceptuję” mierzymy odwiedziny, zaczynając od aktualnie otwartej
            strony. Celem jest poznanie liczby odwiedzających i popularności podstron.
            Podstawą przetwarzania danych do tego pomiaru jest Twoja dobrowolna zgoda
            (art. 6 ust. 1 lit. a RODO). Odmowa nie blokuje korzystania ze strony.
        </p>
        <p>
            W bazie licznika zapisujemy adres podstrony, dzień wizyty oraz skrót
            kryptograficzny (hash) identyfikatora przeglądarki. Nie zapisujemy w tej tabeli
            surowej wartości cookie, adresu IP ani danych z formularza powiadomień.
            Logi techniczne serwera są odrębne od tego licznika.
        </p>
        <p>
            Hash pozwala nadal łączyć wizyty tej samej przeglądarki, więc nie traktujemy
            tych rekordów jako w pełni anonimowych. Nie łączymy ich z listą subskrybentów.
            Usunięcie cookie albo użycie innej przeglądarki może spowodować policzenie
            kolejnego odwiedzającego — nie jest to pomiar liczby konkretnych osób.
        </p>
        <!-- Przed publikacją należy wdrożyć egzekwowanie wybranego okresu retencji. -->
        <p>
            Rekordy statystyk zawierające hash identyfikatora przechowujemy maksymalnie
            przez 365 dni od dnia wizyty. Ważność cookies w przeglądarce i okres
            przechowywania rekordów w bazie to dwa odrębne terminy.
            Samo wygaśnięcie lub usunięcie cookie nie usuwa historycznych rekordów z bazy.
        </p>
    </section>

    <section aria-labelledby="privacy-cookie-choice">
        <h2 id="privacy-cookie-choice">Jak zmienić decyzję o cookies?</h2>
        <p>
            Przy pierwszym wejściu możesz wybrać „Akceptuję” albo „Odrzucam”.
            Brak wyboru nie oznacza zgody. W każdej chwili możesz otworzyć
            „Ustawienia cookies” w stopce i zmienić decyzję.
        </p>
        <p>
            Wybranie „Odrzucam” zatrzymuje nowe zapisy naszego licznika i usuwa
            cookie visitor_id. Zapamiętujemy odmowę, aby nie pokazywać ponownie pytania
            przy każdym wejściu. Wycofanie zgody nie usuwa automatycznie wcześniejszych
            rekordów statystyk; w sprawie danych i realizacji swoich praw możesz
            skontaktować się z administratorem wskazanym wyżej.
        </p>
        <p>
            Cookies możesz również usuwać lub blokować w ustawieniach przeglądarki.
            Zablokowanie plików niezbędnych może utrudnić działanie formularzy lub logowania.
        </p>
    </section>
</article>
