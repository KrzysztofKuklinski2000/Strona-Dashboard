let scrollElement = document.querySelector('.important-info')
let leftArrow = document.querySelector('.left-arrow')
let rightArrow = document.querySelector('.right-arrow')

let counter = 0;

leftArrow.addEventListener('click', ()=>{
	scrollElement.scrollBy({top:0, left:-330, behavior:'smooth'})
})

rightArrow.addEventListener('click', ()=>{
	scrollElement.scrollBy({top:0, left:+330, behavior:'smooth'})
})
