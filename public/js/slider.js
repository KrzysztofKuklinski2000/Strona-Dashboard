let img = document.querySelectorAll('.img')
let left = document.querySelector('.left-arrow')
let right = document.querySelector('.right-arrow')
let dots = document.querySelectorAll('.dots p')
let counter = 0

img = [...img]
dots = [...dots]


dots.forEach(dot => {
	dot.addEventListener('click', changeSlide, false)
})

left.addEventListener('click', ()=>{
	counter--
	if(counter == 0 ) left.style.visibility = 'hidden'
	else right.style.visibility = 'visible'
	changeImage(counter)
	changeOpacity(counter)
},false)

right.addEventListener('click', ()=>{
	counter++
	if(counter == 3 ) right.style.visibility = 'hidden'
	else left.style.visibility = 'visible'
	changeImage(counter)
	changeOpacity(counter)
},false)


function changeSlide() {
	let  i = dots.indexOf(this);
	counter = i
	if(i==3)  {
		right.style.visibility = 'hidden'
		left.style.visibility = 'visible'
	}
	else if (i == 0) {
		left.style.visibility = 'hidden'
		right.style.visibility = 'visible'
	}
	else {
		left.style.visibility = 'visible'
		right.style.visibility = 'visible'
	}
	changeImage(i)
	changeOpacity(i)
}

function changeImage(number) {
	img.forEach(el => {
		el.style.transform = `translate(-${number * 100}%, -25%)`
	})
}

function changeOpacity(i) {

	dots.forEach(dot => dot.style.opacity = '.5')
	dots[i].style.opacity = '1'
}