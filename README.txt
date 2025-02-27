Lista rzeczy do zrobienia (dashboard)
	- Przygotować routing pod dashoard (create/edit/delete/list/show/login)
	- Przygotować view tak żeby wyświetlał odpowiedni layout do routingu
	- Stworzyć layout podstron(create/edit/delete/list/show/login)
	- Przygotwać style
	- Wersji mobilnej nie ma 

	- Stworzyć obiekt Modelu (bazydanych)
	- Stworzyć plik config do połączenia sie z bazą danych
	- Stworzyć obiekt Request
	- Escapowanie danych
	- Utworzenia stystemu logowania dla admina

	- Listing postów przygotować paginacje / wyszukiwarkę postów

	I) PodStrony i co trzeba na nich zrobić
		- Create 
			* Miejsce na tytuł formularza (Formularz do stworzenia nowego postu)
			* Stworzyć formularz 
				- pole na tytuł
				- pole na treść posta
				- przycisk dodania
			* Pole na wyświetlanie komunikatów o błędach w formularzu
		- Edit
			* Miejsce na tytuł formularza (Formularz do stworzenia nowego postu)
			* Stworzyć formularz 
				- pole na tytuł wraz z treścią
				- pole na treść posta wraz z teścią
				- przycisk dodania
				- komuniakt o tym czy na pewno chcemy zapisać zmiany
			* Pole na wyświetlanie komunikatów o błędach w formularzu
			* Wyświtlenie informacji o tym kiedy post został utworzony lub edytowany
		- Delete 
			* Wyświetlenie tytułu i treści posta
			* Stworzenie formularza
				- pole typu hide w którym będzie id usówanego posta
				- przycisk do usuwania
				- komunikat o tym czy na pewno chce się usunąć posta
			* Wyświtlenie informacji o tym kiedy post został utworzony lub edytowany
		- Show 
			* Wyświetlenie tytułu, treści posta i daty edycji/powstania
			* Wyświetlanie linków do edycji/usuwania
			* Wyświetlanie pól do chowania i publikowania posta na stronie
			* Przycisk do akceptacji pól
		-Listing
			* Wyświtlenie w tabeli wszystkich postów (nr pola | tytuł posta | data | iconki do edycji usuwania | status publiczny/niepubliczny)
			* Wyświetlanie paginacji na samym dole
		- Dashboard 
			https://www.geeksforgeeks.org/how-to-create-responsive-admin-dashboard-using-html-css-javascript/
			* pasek górny ikonka admina/ logo karate / wyszukiwarka postów po tytule
			* menu boczne - (Posts/Grafik/Galeria/Logout)

		- Przygotwanie na dashboardzie podstron do edytowania grafiku/galeri



Lista rzeczy do zrobienia (Bazy danych)
	- Stworzyć tabele (users/posts/galeria/grafik/)

- Używać namespaców
- Do bazy danych używać PDO
- Baza danych mysql
- Wszystko piszemy w classach
- Używać try/catch - douczyć się
- Refactoring kodu - dbać o jakość kodu 
- Do stylów używamy flexbox
- Używać MVC
- Utworzyć i utrzymywać poprawną strukture katalogów
- Pilnować typów zmienych declare(strict_types=1);
- Zabezpieczyć strone 
- Walidacja danych
- Utrzywanie jednolitego sposobu nazewnistwa metod/zmienych/class
- Nazewnictwo w języku angielskim
