let menu = document.querySelector('.menu');

let choice = document.querySelectorAll('.choice');
let contentDiv = document.querySelector('.show-content');
choice = [...choice];
let content = [
		[
			['10.1Kyu', 'pomarańczowy pas z <br> czerwonym pagonem', '1.   Teoria i komendy: zasady bezpieczeństwa - sala, szatnia, ubiór itp. Strefy: jodan, chudan, gedan. Znaczenie słowa kiai - okrzyk. <br>2.   Pozycje: fudo - dachi. <br> 3.   Uderzenia/cięcia: morote - tsuki (jodan, chudan, gedan). <br>4.   Kopnięcia: hiza - geri (chudan). <br>5.   Test sprawności: <br>-  50 razy zaciskanie pięści. <br>- 10 przysiadów: obciążone całe stopy, ręce dowolnie.'],
			['10.2Kyu', 'pomarańczowy pas z <br> dwoma czerwonymi pagonami', '1.   Teoria i komendy: zasady bezpieczeństwa - sala, szatnia, ubiór itp. Strefy: jodan, chudan, gedan. Znaczenie słowa kiai - okrzyk. <br>2.   Pozycje: fudo - dachi. <br> 3.   Uderzenia/cięcia: morote - tsuki (jodan, chudan, gedan). <br>4.   Kopnięcia: hiza - geri (chudan). <br>5.   Test sprawności: <br>-  50 razy zaciskanie pięści. <br>- 10 przysiadów: obciążone całe stopy, ręce dowolnie.']
		],
		[
			['9.1Kyu', 'pomarańczowy pas z <br> czerwonym pagonem', '1.   Teoria i komendy: zasady bezpieczeństwa - sala, szatnia, ubiór itp. Strefy: jodan, chudan, gedan. Znaczenie słowa kiai - okrzyk. <br>2.   Pozycje: fudo - dachi. <br> 3.   Uderzenia/cięcia: morote - tsuki (jodan, chudan, gedan). <br>4.   Kopnięcia: hiza - geri (chudan). <br>5.   Test sprawności: <br>-  50 razy zaciskanie pięści. <br>- 10 przysiadów: obciążone całe stopy, ręce dowolnie.'],
			['9.2Kyu', 'pomarańczowy pas z <br> dwoma czerwonymi pagonami', '1.   Teoria i komendy: zasady bezpieczeństwa - sala, szatnia, ubiór itp. Strefy: jodan, chudan, gedan. Znaczenie słowa kiai - okrzyk. <br>2.   Pozycje: fudo - dachi. <br> 3.   Uderzenia/cięcia: morote - tsuki (jodan, chudan, gedan). <br>4.   Kopnięcia: hiza - geri (chudan). <br>5.   Test sprawności: <br>-  50 razy zaciskanie pięści. <br>- 10 przysiadów: obciążone całe stopy, ręce dowolnie.'],
			['9.3Kyu', 'pomarańczowy pas z <br> dwoma czerwonymi pagonami', '1.   Teoria i komendy: zasady bezpieczeństwa - sala, szatnia, ubiór itp. Strefy: jodan, chudan, gedan. Znaczenie słowa kiai - okrzyk. <br>2.   Pozycje: fudo - dachi. <br> 3.   Uderzenia/cięcia: morote - tsuki (jodan, chudan, gedan). <br>4.   Kopnięcia: hiza - geri (chudan). <br>5.   Test sprawności: <br>-  50 razy zaciskanie pięści. <br>- 10 przysiadów: obciążone całe stopy, ręce dowolnie.']
		],
		[
			['8.1Kyu', 'pomarańczowy pas z <br> czerwonym pagonem', '1.   Teoria i komendy: zasady bezpieczeństwa - sala, szatnia, ubiór itp. Strefy: jodan, chudan, gedan. Znaczenie słowa kiai - okrzyk. <br>2.   Pozycje: fudo - dachi. <br> 3.   Uderzenia/cięcia: morote - tsuki (jodan, chudan, gedan). <br>4.   Kopnięcia: hiza - geri (chudan). <br>5.   Test sprawności: <br>-  50 razy zaciskanie pięści. <br>- 10 przysiadów: obciążone całe stopy, ręce dowolnie.'],
			['8.2Kyu', 'pomarańczowy pas z <br> dwoma czerwonymi pagonami', '1.   Teoria i komendy: zasady bezpieczeństwa - sala, szatnia, ubiór itp. Strefy: jodan, chudan, gedan. Znaczenie słowa kiai - okrzyk. <br>2.   Pozycje: fudo - dachi. <br> 3.   Uderzenia/cięcia: morote - tsuki (jodan, chudan, gedan). <br>4.   Kopnięcia: hiza - geri (chudan). <br>5.   Test sprawności: <br>-  50 razy zaciskanie pięści. <br>- 10 przysiadów: obciążone całe stopy, ręce dowolnie.']
		],
		[
			['7.1Kyu', 'pomarańczowy pas z <br> czerwonym pagonem', '1.   Teoria i komendy: zasady bezpieczeństwa - sala, szatnia, ubiór itp. Strefy: jodan, chudan, gedan. Znaczenie słowa kiai - okrzyk. <br>2.   Pozycje: fudo - dachi. <br> 3.   Uderzenia/cięcia: morote - tsuki (jodan, chudan, gedan). <br>4.   Kopnięcia: hiza - geri (chudan). <br>5.   Test sprawności: <br>-  50 razy zaciskanie pięści. <br>- 10 przysiadów: obciążone całe stopy, ręce dowolnie.'],
			['7.2Kyu', 'pomarańczowy pas z <br> dwoma czerwonymi pagonami', '1.   Teoria i komendy: zasady bezpieczeństwa - sala, szatnia, ubiór itp. Strefy: jodan, chudan, gedan. Znaczenie słowa kiai - okrzyk. <br>2.   Pozycje: fudo - dachi. <br> 3.   Uderzenia/cięcia: morote - tsuki (jodan, chudan, gedan). <br>4.   Kopnięcia: hiza - geri (chudan). <br>5.   Test sprawności: <br>-  50 razy zaciskanie pięści. <br>- 10 przysiadów: obciążone całe stopy, ręce dowolnie.']
		],
		[
			['6.1Kyu', 'pomarańczowy pas z <br> czerwonym pagonem', '1.   Teoria i komendy: zasady bezpieczeństwa - sala, szatnia, ubiór itp. Strefy: jodan, chudan, gedan. Znaczenie słowa kiai - okrzyk. <br>2.   Pozycje: fudo - dachi. <br> 3.   Uderzenia/cięcia: morote - tsuki (jodan, chudan, gedan). <br>4.   Kopnięcia: hiza - geri (chudan). <br>5.   Test sprawności: <br>-  50 razy zaciskanie pięści. <br>- 10 przysiadów: obciążone całe stopy, ręce dowolnie.'],
			['6.2Kyu', 'pomarańczowy pas z <br> dwoma czerwonymi pagonami', '1.   Teoria i komendy: zasady bezpieczeństwa - sala, szatnia, ubiór itp. Strefy: jodan, chudan, gedan. Znaczenie słowa kiai - okrzyk. <br>2.   Pozycje: fudo - dachi. <br> 3.   Uderzenia/cięcia: morote - tsuki (jodan, chudan, gedan). <br>4.   Kopnięcia: hiza - geri (chudan). <br>5.   Test sprawności: <br>-  50 razy zaciskanie pięści. <br>- 10 przysiadów: obciążone całe stopy, ręce dowolnie.']
		],
		[
			['5.1Kyu', 'pomarańczowy pas z <br> czerwonym pagonem', '1.   Teoria i komendy: zasady bezpieczeństwa - sala, szatnia, ubiór itp. Strefy: jodan, chudan, gedan. Znaczenie słowa kiai - okrzyk. <br>2.   Pozycje: fudo - dachi. <br> 3.   Uderzenia/cięcia: morote - tsuki (jodan, chudan, gedan). <br>4.   Kopnięcia: hiza - geri (chudan). <br>5.   Test sprawności: <br>-  50 razy zaciskanie pięści. <br>- 10 przysiadów: obciążone całe stopy, ręce dowolnie.'],
			['5.2Kyu', 'pomarańczowy pas z <br> dwoma czerwonymi pagonami', '1.   Teoria i komendy: zasady bezpieczeństwa - sala, szatnia, ubiór itp. Strefy: jodan, chudan, gedan. Znaczenie słowa kiai - okrzyk. <br>2.   Pozycje: fudo - dachi. <br> 3.   Uderzenia/cięcia: morote - tsuki (jodan, chudan, gedan). <br>4.   Kopnięcia: hiza - geri (chudan). <br>5.   Test sprawności: <br>-  50 razy zaciskanie pięści. <br>- 10 przysiadów: obciążone całe stopy, ręce dowolnie.']
		],
	]

document.querySelector('.nav-bar-icon')
.addEventListener('click', ()=>{
	menu.style.display = 'block';
}, false);

document.querySelector('#times-icon')
.addEventListener('click', () => {
	menu.style.display = 'none';
}, false)


choice.forEach((el) => el.addEventListener('click', changeContent, false))

function changeContent(){
	choice.forEach(el => el.style.color = "#BDBDBD");
	this.style.color = 'red';
	let i = choice.indexOf(this);
	let text = '';
	content[i].forEach(el => {
		text += `<div class='content'><h3>${el[0]}</h3><p>${el[1]}</p><p class="content-justify">${el[2]}</p></div>`
	})
	contentDiv.innerHTML = text;
}