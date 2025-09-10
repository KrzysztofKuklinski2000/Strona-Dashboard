let menu = document.querySelector('.menu');

let choice = document.querySelectorAll('.choice');
let choice2 = document.querySelectorAll('.choice2');

let contentDiv = document.querySelector('.show-content');
let contentDiv2 = document.querySelector('.show-content2');

choice = [...choice];
choice2 = [...choice2];

let content = [
	// 10 KYU
	[
		[
			'10Kyu', 'pomarańczowy pas', 
			'1. Pozycje (Tachikata): Yoi, Fudo Dachi, Sanchin Dachi, Zenkutsu Dachi.<br>' +
			'2. Uderzenia i cięcia (Tsuki): Seiken Oi Tsuki (J/C/G), Seiken Gyaku Tsuki (J/C/G), Seiken Morote Tsuki (J/C/G), Seiken Ago Uchi.<br>' +
			'3. Bloki (Uke): Seiken/Shuto Jodan Uke, Seiken/Shuto Mae Gedan Barai.<br>' +
			'4. Kopnięcia (Keri): Hiza Geri, Kin Geri, Mae Geri (J/C).<br>' +
			'5. Ruch (Ido): Zenkutsu Dachi, Sanchin Dachi.<br>' +
			'6. Kata: Taikyoku Sono Ichi, Taikyoku Sono Ni.<br>' +
			'7. Kombinacje (Renraku): –<br>' +
			'8. Sprawność (Stamina): 15/40/15 – pompki, brzuszki, przysiady.<br>' +
			'9. Kumite: Ippon Kumite.<br>' +
			'10. Oddychanie (Kokyu Ho): Nogare (Omote, Ura).'
		]
	],

	// 9 KYU
	[
		[
			'9Kyu', 'pomarańczowy pas z <br> niebieskim pagonem', 
			'1. Pozycje (Tachikata): Musubi Dachi, Heiko Dachi, Heisoku Dachi, Kokutsu Dachi.<br>' +
			'2. Uderzenia i cięcia (Tsuki): Seiken Shita Tsuki, Seiken Tate Tsuki (J/C/G), Seiken Kagi Tsuki (J/C/G), Hiji Ate (J/C).<br>' +
			'3. Bloki (Uke): Seiken/Shuto Chudan Soto Uke, Seiken/Shuto Chudan Uchi Uke.<br>' +
			'4. Kopnięcia (Keri): Mae Keage, Yoko Keage, Uchi Mawashi Keage, Soto Mawashi Keage.<br>' +
			'5. Ruch (Ido): Kokutsu Dachi.<br>' +
			'6. Kata: Taikyoku Sono San.<br>' +
			'7. Kombinacje (Renraku): –<br>' +
			'8. Sprawność (Stamina): 20/45/20 – pompki, brzuszki, przysiady.<br>' +
			'9. Kumite: Yakusoku Kumite, Sambon Kumite.<br>' +
			'10. Oddychanie (Kokyu Ho): Kiai.'
		]
	],

	// 8 KYU
	[
		[
			'8Kyu', 'niebieski pas',
			'1. Pozycje (Tachikata): Kiba Dachi, Tsuru Ashi Dachi, Kumite No Kamae.<br>' +
			'2. Uderzenia i cięcia (Tsuki): Uraken Ganmen Uchi, Uraken Sayu Ganmen Uchi, Uraken Hizo Uchi, Uraken Mawashi Uchi, Uraken Oroshi Ganmen Uchi.<br>' +
			'3. Bloki (Uke): Seiken/Shuto Uchi Uke/Gedan Barai, Morote Chudan Uchi Uke.<br>' +
			'4. Kopnięcia (Keri): Kansetsu Geri, Yoko Geri (J/C), Mawashi Geri (J/C/G).<br>' +
			'5. Ruch (Ido): Kiba Dachi.<br>' +
			'6. Kata: Sokugi Taikyoku Sono Ichi, Sokugi Taikyoku Sono Ni, Sokugi Taikyoku Sono San.<br>' +
			'7. Kombinacje (Renraku): Mae Geri, Chudan Gyaku Tsuki; Chudan Soto Uke, Mae Gedan Barai, Chudan Gyaku Tsuki.<br>' +
			'8. Sprawność (Stamina): 30/50/30, Tobi Geri.<br>' +
			'9. Kumite: Jiyu Kumite 2x60s.<br>' +
			'10. Oddychanie (Kokyu Ho): Ibuki Sankai.'
		]
	],

	// 7 KYU
	[
		[
			'7Kyu', 'niebieski pas z <br> żółtym pagonem',
			'1. Pozycje (Tachikata): Uchi Hachiji Dachi, Neko Ashi Dachi, Shiko Dachi.<br>' +
			'2. Uderzenia i cięcia (Tsuki): Tettsui KomiKami, Tettsui Oroshi Ganmen Uchi, Tettsui Hizo Uchi, Tettsui Yoko Uchi, Tettsui Yoko Uchi (J/C/G) Mae.<br>' +
			'3. Bloki (Uke): Shuto Mawashi Uke, Mae Shuto Mawashi Uke.<br>' +
			'4. Kopnięcia (Keri): Jodan Uchi Heisoku Geri, Ago Jodan Geri.<br>' +
			'5. Ruch (Ido): Neko Ashi Dachi.<br>' +
			'6. Kata: Pinan Sono Ichi, Sanchin No Kata.<br>' +
			'7. Kombinacje (Renraku): –<br>' +
			'8. Sprawność (Stamina): 35/55/35, Tobi Geri + 20 cm.<br>' +
			'9. Kumite: Jiyu Kumite 3x60s.<br>' 
		]
	],

	// 6 KYU
	[
		[
			'6Kyu', 'żółty pas',
			'1. Pozycje (Tachikata): Kake Ashi Dachi.<br>' +
			'2. Uderzenia i cięcia (Tsuki): Shuto Yoko Ganmen Uchi, Shuto Sakotsu Uchi, Shuto Hizo Uchi, Shuto Jodan Uchi Uchi, Shuto Sakotsu Uchi Komi, Ushiro Hiji Ate, Yonhon Nukite, Nihon Nukite (J/C).<br>' +
			'3. Bloki (Uke): Enkei Gyaku Tsuki, Mawashi Gedan Barai, Juji Gedan Barai, Hiji Uke, Jodan Shuto Uchi Uke.<br>' +
			'4. Kopnięcia (Keri): Ushiro Geri (J/C/G), 3 methods, Ushiro Mawashi Geri (J/C/G).<br>' +
			'5. Ruch (Ido): Kake Ashi Dachi.<br>' +
			'6. Kata: Pinan Sono Ni, Pinan Sono San.<br>' +
			'7. Kombinacje (Renraku): –<br>' +
			'8. Sprawność (Stamina): 40/60/40, Tobi Geri +15 cm.<br>' +
			'9. Kumite: Jiyu Kumite 4x60s.<br>' +
			'10. Oddychanie (Kokyu Ho): Ibuki Sankai.'
		]
	],

	// 5 KYU
	[
		[
			'5Kyu', 'żółty pas z <br> zielonym pagonem',
			'1. Pozycje (Tachikata): Moro Ashi Dachi.<br>' +
			'2. Uderzenia i cięcia (Tsuki): Shotei Uchi (J/C/G), Age Hiji Ate (J/C), Oroshi Hiji Ate, Jun Tsuki (J/C/G).<br>' +
			'3. Bloki (Uke): Seiken/Shuto Juji Uke (J/G), Shotei Uke (J/C/G).<br>' +
			'4. Kopnięcia (Keri): Oroshi Uchi Kakato Geri, Oroshi Soto Kakato Geri.<br>' +
			'5. Ruch (Ido): Moro Ashi Dachi.<br>' +
			'6. Kata: Pinan Sono Yon.<br>' +
			'7. Kombinacje (Renraku): –<br>' +
			'8. Sprawność (Stamina): 45/65/45, Tobi Geri +15 cm.<br>' +
			'9. Kumite: Jiyu Kumite 5x60s.<br>' 
		]
	],

	// 4 KYU
	[
		[
			'4Kyu', 'zielony',
			'1. Pozycje (Tachikata): –<br>' +
			'2. Uderzenia i cięcia (Tsuki): Koken Uchi (J/C/G), Mae Hiji Ate (J/C), Haishu Uchi (J/C).<br>' +
			'3. Bloki (Uke): Koken Uke (J/C/G).<br>' +
			'4. Kopnięcia (Keri): Kake Geri (J/C/G).<br>' +
			'5. Ruch (Ido): Ura Ido.<br>' +
			'6. Kata: Pinan Sono Go, Taikyoku Sono Ichi Ura, Taikyoku Sono Ni Ura, Taikyoku Sono San Ura.<br>' +
			'7. Kombinacje (Renraku): Mae Geri, Yoko Geri, Ushiro Geri, Chudan Gyaku Tsuki.<br>' +
			'8. Sprawność (Stamina): 50/70/50, Tobi Geri +20 cm.<br>' +
			'9. Kumite: Jiyu Kumite 6x60s.<br>' 
		]
	],

	// 3 KYU
	[
		[
			'3Kyu', 'zielony pas z <br> brązowym pagonem',
			'1. Pozycje (Tachikata): –<br>' +
			'2. Uderzenia i cięcia (Tsuki): Hira Ken Tsuki (J/C), Hira Ken Oroshi Uchi, Hira Ken Mawashi Uchi.<br>' +
			'3. Bloki (Uke): Gedan Shuto Morote Uke, Gedan Shotei Morote Uke.<br>' +
			'4. Kopnięcia (Keri): Mae Kakato Geri (J/C/G), Age Kakato Ushiro Geri.<br>' +
			'5. Ruch (Ido): Yon Ju Go Do Ido.<br>' +
			'6. Kata: Tsuki No Kata.<br>' +
			'7. Kombinacje (Renraku): –<br>' +
			'8. Sprawność (Stamina): 55/75/55, Tobi Geri +20 cm.<br>' +
			'9. Kumite: Jiyu Kumite 10x60s.<br>' 
		]
	],

	// 2 KYU
	[
		[
			'2Kyu', 'brązowy pas',
			'1. Pozycje (Tachikata): –<br>' +
			'2. Uderzenia i cięcia (Tsuki): Ryuto Ken Tsuki (J/C), Nakayubi Ippon Ken (J/C), Oyayubi Ippon Ken (J/C), Hitosashi Yubi Ippon Ken (J/C), Yama-Tsuki.<br>' +
			'3. Bloki (Uke): Kake Uke (J/C), Morote Kake Uke.<br>' +
			'4. Kopnięcia (Keri): Tobi Mae Geri, Tobi Nidan Geri.<br>' +
			'5. Ruch (Ido): Kumite no Kamae – Okuri Ashi, Fumi Ashi, Kosa, Oi Ashi (Mae, Sagari), różne kąty.<br>' +
			'6. Kata: Geki Sai Dai, Tensho.<br>' +
			'7. Kombinacje (Renraku): Back in Gedan Barai, forward with Ago Uchi and Gyaku Tsuki, one step Mae Geri (Oi Ashi), Mawashi Geri, Ushiro Geri, Gedan Barai, Gyaku Tsuki.<br>' +
			'8. Sprawność (Stamina): 60/80/60.<br>' +
			'9. Kumite: Jiyu Kumite 12x60s.<br>' 
		]
	],

	// 1 KYU
	[
		[
			'1Kyu', 'brązowy pas z <br> czarnym pagonem',
			'1. Pozycje (Tachikata): –<br>' +
			'2. Uderzenia i cięcia (Tsuki): Keiko Uchi, Haito Uchi (J/C/G), Morote Haito Uchi (J/C).<br>' +
			'3. Bloki (Uke): Chudan Haito Uchi Uke, Osae Uke.<br>' +
			'4. Kopnięcia (Keri): Yoko Tobi Geri, Mawashi Tobi Geri, Ushiro Tobi Geri, Ushiro Mawashi Tobi Geri.<br>' +
			'5. Kata: Geki Sai Sho, Yantsu.<br>' +
			'6. Kombinacje (Renraku): A: Oi Tsuki, Gyaku Tsuki, Oi Tsuki, Shita Tsuki. B: Mawashi Geri with front leg, Oi Tsuki, Gyaku Tsuki, Mawashi Geri with back leg.<br>' +
			'7. Sprawność (Stamina): 65/100/65, Tobi Geri +30 cm.<br>' +
			'8. Kumite: Jiyu Kumite 15x60s.<br>'
		]
	]
];

let content2 = [
	[
		[
			[
			'10.1Kyu', 'biały pas z <br> czerwonym pagonem',
			'1. Etykieta DOJO.<br>' +
			'2. Pozycje: seiza, fudo dachi, zenkutsu-dachi.<br>' +
			'3. Ćwiczenia: 10 przysiadów na całych stopach, z pozycji stojącej skłon z dotknięciem rękami podłogi.<br>' +
			'4. Pad w przód z przysiadu.<br>' +
			'5. Pchnięcie: morote-seiken-tsuki (jodan, chudan).<br>' +
			'6. Kopnięcia: hiza-geri-chudan.<br>' +
			'7. Ćwiczenie: 10x dotknąć poduszką stopy dłoni partnera nad głową.'
			],

			['10.2Kyu', 'biały pas z <br> dwoma czerwonymi pagonami',
			'1. Pad w tył z przysiadu.<br>' +
			'2. 10 skłonów w przód z leżenia na plecach.<br>' +
			'3. Ćwiczenie: na kolanach i pięściach utrzymać się przez 10 sek.<br>' +
			'4. Seiken-tsuki (jodan, chudan, gedan).<br>' +
			'5. Bloki: seiken-jodan-uke.<br>' +
			'6. Kopnięcia: mae-keage.<br>' +
			'7. Zenkutsu-dachi z seiken-oi-tsuki.<br>' +
			'8. Zenkutsu-dachi z morote-gedan-barai, hiza-geri chudan, 3 kroki do przodu, mawate.<br>' +
			'9. Liczenie do dziesięciu po japońsku.<br>' +
			'10. Wiązanie obi (pasa).'
			],

			[
			'10.3Kyu', 'biały pas z <br> trzema czerwonymi pagonami',
			'1. Składanie karategi.<br>' +
			'2. 10 ugięć rąk na kolanach i dłoniach.<br>' +
			'3. Oddychanie: Nogare I.<br>' +
			'4. Pozycje: heiko-dachi, heisoku-dachi, yoi-dachi.<br>' +
			'5. Bloki: seiken-gedan-barai.<br>' +
			'6. Uderzenie: seiken-ago-uchi.<br>' +
			'7. Kopnięcia: kin-geri.<br>' +
			'8. Zenkutsu-dachi: trzy kroki do przodu/do tyłu z seiken-oi-jodan-tsuki / seiken jodan-uke.<br>' +
			'9. Przysięga DOJO – co najmniej 1 punkt.<br>' +
			'10. Znaczenie słów japońskich.<br>' +
			'11. Renraku: fudo-dachi: morote-seiken-tsuki-chudan, hiza-geri, seiken-gedan-tsuki, zenkutsu-dachi, seiken-gedan-barai / seiken-gyaku-tsuki z kiai.'
			]
		],
		[
			[
			'9.1Kyu', 'biały pas z <br> czerwonym pagonem',
			'1. Przysiadów na całych stopach, wykonanie gwiazdy gimnastycznej.<br>' +
			'2. Pozycja: musubi-dachi.<br>' +
			'3. Bloki: seiken-soto-uke.<br>' +
			'4. Pchnięcie: seiken-tate-tsuki (j/ch/g).<br>' +
			'5. Seiken-gedan-barai/gyaku-tsuki-chudan.<br>' +
			'6. Kopnięcia: mae-geri chudan<br>' +
			'7. Renraku: zenkutsu-dachi seiken-gedan-barai, 3 kroki z hiza-geri/seiken-chudan-oi-tsuki mawate z gedan-barai, 3 kroki z mae-keage/seiken-jodan-oi-tsuki, mawate z gedan-barai/ seiken-giaku-tsuki z kiai.'
			],

			['9.2Kyu', 'biały pas z <br> dwoma czerwonymi pagonami',
			'1. Przewrót w przód i w tył z przysiadu.<br>' +
			'2. Stanie na rękach, dotknąć stopami drabinek lub dłoni partnera.<br>' +
			'3. Pozycja: uchi-hachiji-dachi, sanchin-dachi.<br>' +
			'4. Bloki: seiken-uchi-uke.<br>' +
			'5. Kopnięcia: soto-mawashi-keage, uchi-mawashi-keage.<br>' +
			'6. W pozycji zenkutsu-dachi z atak seiken-chudan-tsuki, obrona seiken-gedan-barai.<br>' +
			'7. Kata: kihon kata I.<br>' +
			'8. Nogare ura.<br>' 
			],

			[
			'9.3Kyu', 'biały pas z <br> trzema czerwonymi pagonami',
			'1. W podporze przodem na pięściach i kolanach 10 tzw. pompek.<br>' +
			'2. Mostek w tył z leżenia na plecach.<br>' +
			'3. Siedząc nogi proste maksymalnie w bok i dotknąć głową kolana lewego/prawego.<br>' +
			'4. Pozycja kokutsu-dachi.<br>' +
			'5. Pchnięcie: seiken-shita-tsuki.<br>' +
			'6. Kopnięcia: teisoku/haisoku-mawashi-soto/uchi-geri.<br>' +
			'7. Z partnerem w pozycji zenkutsu-dachi: atak seiken-chudan-tsuki, obrona seiken-soto-uke.<br>' +
			'8. Kata: taikyoku kata sono-ichi, taikyoku kata sono-ni.<br>' 
			]
		],[
			[
			'8.1Kyu', 'biały pas z <br> czerwonym pagonem',
			'1. Stojąc na rękach pod drabinkami lub przed partnerem utrzymać się przez 5 sec.<br>' +
			'2. Mostek w tył z leżenia na plecach – utrzymanie się przez 10 sec.<br>' +
			'3. Pozycja kumite-no-kamaete.<br>' +
			'4. Bloki: shuto-jodan-uke, mae-shuto-gedan-barai.<br>' +
			'5. Pchnięcie: seiken-kagi-tsuki).<br>' +
			'6. Z partnerem w zenkutsu-dachi: trzy kroki atak z mae-geri, obrona z gedan-barai.<br>' +
			'7. Kopnięcia: mawashi-geri-gedan, mawashi-geri-chudan.'+
			'8. W pozycji kokutsu-dachi 3 kroki z seiken-uchi-uke, mawate'+
			'9. Kata: juji-kata'+
			'10. Przysięga DOJO'
			],

			['8.2Kyu', 'biały pas z <br> dwoma czerwonymi pagonami',
			'1. 20 przysiadów na całych stopach.<br>' +
			'2. Siedząc nogi proste w kolanach maksymalnie w bok dotknąć głową podłogi.<br>' +
			'3. Pozycja kiba-dachi.<br>' +
			'4. Bloki: shuto-chudan-soto-uke, shutu-chudan-uchi-uke.<br>' +
			'5. Uderzenia/cięcia: shuto-sakotsu-uchi.<br>' +
			'6. W zenkutsu-dachi trzy kroki z oi-tsuki/giaku-tsuki/gedan-barai.<br>' +
			'7. Kopnięcia: yoko-keage, kansetsu-geri.<br>' +
			'8. Sambon kumite: atak i obrona na tempa.<br>' +
			'9. Kata: taikyoku kata sono-san.<br>' 
			],

			[
			'8.3Kyu', 'biały pas z <br> trzema czerwonymi pagonami',
			'1. 10 przeskoków nad klęczącym na kolanach i rękach partnerem, z przysiadu.<br>' +
			'2. Pozycja tsuru-ashi-dachi.<br>' +
			'3. Bloki: morote-seiken-chudan-uchi-uke.<br>' +
			'4. Uderzenia: uraken-shomen-uchi, uraken-sayu-uchi, uraken-hizo-uchi.<br>' +
			'5. Kopnięcia: mawashi-geri-chudan trzy kroki w pozycji walki.<br>' +
			'6. Kroki w pozycji kiba-dachi z kansetsu-gedan-barai.<br>' +
			'7. W pozycji walki poruszanie się, stosowanie kroków.<br>' +
			'8. Kata: taikyoku-sakugi-sono-ichi.<br>'
			]
		],
		[
			[
			'7.1Kyu', 'biały pas z <br> czerwonym pagonem',
			'1. umiejętność stania na głowie.<br>' +
			'2. Bloki seiken-uchi-uke/gedan-barai.<br>' +
			'3. Kroki w pozycji kokutsu-dachi z shuto-sakotsu-uchi, mawate.<br>' +
			'4. Kopnięcia: yoko-geri chudan.<br>' +
			'5. W pozycji sanchin-dachi trzy kroki w przód z seiken-tsuki, mawatte z uchi-uke.<br>' +
			'6. Sambon kumite z partnerem.<br>' +
			'7. Poruszanie się w pozycji walki z ago-uchi, seiken-tsuki i geri.'+
			'8. Kata: taikyoku-sakugi-sono-ni.'
			],

			['7.2Kyu', 'biały pas z <br> dwoma czerwonymi pagonami',
			'1. Stojąc na rękach utrzymać się przez 5 sec.<br>' +
			'2. Pozycja: neko-ashi-dachi.<br>' +
			'3. Bloki: shuto-mawashi-uke.<br>' +
			'4. Uderzenia: tetsui-oroshi-ganmen-uchi, tetsui-kome-kami-uchi, tetsui-yoko-uchi.<br>' +
			'5. Kopnięcia: mawashi-geri-jodan.<br>' +
			'6. W pozycji zenkutsu-dachi 3 kroki z mawashi-geri/seiken-oi-tsuki.<br>' +
			'7. Renraku: 1.mae-geri-chudan chudan-gyaku-tsuki. 2.chudan-soto-uke gedan-barai chudan-giaku-tsuki.<br>' +
			'8. Poruszanie się w pozycji walki z partnerem, 1-szy atak, drugi obrona (system punktowy.<br>' +
			'9. Kata: taikyoku-sakugi-sono-san.<br>' 
			],

			[
			'7.3Kyu', 'biały pas z <br> trzema czerwonymi pagonami',
			'1. W podporze na pięściach i kolanach 20 tzw. pompek.<br>' +
			'2. Leżąc na plecach, 20 skłonów w przód.<br>' +
			'3. Pozycja shiko-dachi.<br>' +
			'4. Shuto-sakotsu-uchi-komi, shuto-ganmen-uchi, shuto-hizo-uchi, shuto uch-uchi.<br>' +
			'5. Kopnięcia: jodan-uchi-heisoku-geri.<br>' +
			'6. Kroki w zenkutsu-dachi z mae-geri-chudan/mawashi-geri-chudan/yoko-geri.<br>' +
			'7. Kata: taikyoku sono-ichi-ura.<br>' +
			'8. Kumite: system punktowy (lekki kontakt) 2 x 60 sec.<br>' 
			]
		],
		[
			[
			'6.1Kyu', 'biały pas z <br> czerwonym pagonem',
			'1. Przejście na rękach 3 metrów.<br>' +
			'2. Pozycja kake-ashi-dachi.<br>' +
			'3. Pchnięcia: seiken-jun-tsuki, nihon-nukite, yonhon-nukite.<br>' +
			'4. Kopnięcia: yoko-geri jodan.<br>' +
			'5. 1-szy Ippon kumite: atak seiken-jodan-tski, obrona seiken-jodan-uke/giaku-tsuki, jiyu-ippon-kumite, jiyu-ippon-kumite/samoobrona.<br>' +
			'6. Kata: pinian-sono-ichi.<br>' +
			'7. Kumite: semi kontakt 4 x 60 sec.'
			],

			['6.2Kyu', 'biały pas z <br> dwoma czerwonymi pagonami',
			'1. Historia Kyokushin Karate.<br>' +
			'2. Pozycja kake-ashi-dachi-oi/giaku-tsuki.<br>' +
			'3. Uderzenia: uraken-mawashi-uchi, uraken-oroshi-ganmen-uchi.<br>' +
			'4. Kopnięcie: ushiro-geri.<br>' +
			'5. Poruszanie się w poszczególnych pozycjach z seiken-tsuki, seiken-uke, shuto-uke i geri.<br>' +
			'6. 2-gi Ippon: kumite atak: seiken-chudan-tsuki, obrona seiken-soto-uke/giaku-tsuki, jiyu-ippon-kumite, jiyu-ippon-kumite/samoobrona.<br>' +
			'7. Kata: kihon-kata-sono-ni, pinian-sono-ni.<br>' +
			'8. Kumite semi kontakt: 4 x 60 sec.<br>' 
			],
		]
	]
];



document.querySelector('.nav-bar-icon')
.addEventListener('click', ()=>{
	menu.style.display = 'block';
}, false);

document.querySelector('#times-icon')
.addEventListener('click', () => {
	menu.style.display = 'none';
}, false)


document.addEventListener("DOMContentLoaded", ()=>{
    // Nowa, oddzielna zmienna dla pierwszej sekcji
    let text1 = "";
    content[0].forEach(el => {
        text1 += `<div class='content'><h3>${el[0]}</h3><p>${el[1]}</p><p class="content-justify">${el[2]}</p></div>`
    });
    choice[0].style.color = "white";
    contentDiv.innerHTML = text1;

    // Nowa, oddzielna zmienna dla drugiej sekcji
    let text2 = "";
    content2[0][0].forEach(el => {
        text2 += `<div class='content'><h3>${el[0]}</h3><p>${el[1]}</p><p class="content-justify">${el[2]}</p></div>`
    });
    choice2[0].style.color = "white";
    contentDiv2.innerHTML = text2;
});

choice.forEach((el) => el.addEventListener('click', changeContent, false))
choice2.forEach((el) => el.addEventListener('click', changeContent2, false))

function changeContent(){
	choice.forEach(el => el.style.color = "#BDBDBD");
	this.style.color = 'white';
	let i = choice.indexOf(this);
	let text = '';
	content[i].forEach(el => {
		text += `<div class='content'><h3>${el[0]}</h3><p>${el[1]}</p><p class="content-justify">${el[2]}</p></div>`
	})
	contentDiv.innerHTML = text;
}

function changeContent2(){
	choice2.forEach(el => el.style.color = "#BDBDBD");
	this.style.color = 'white';
	let i = choice2.indexOf(this);
	let text = '';
	content2[0][i].forEach(el => {
		text += `<div class='content'><h3>${el[0]}</h3><p>${el[1]}</p><p class="content-justify">${el[2]}</p></div>`
	})
	contentDiv2.innerHTML = text;
}