document.addEventListener('DOMContentLoaded', function () {
  const aboutSections = document.querySelectorAll('.about-section');

  aboutSections.forEach(section => {
    section.addEventListener('mouseenter', function () {
      section.style.backgroundColor = '#e5e5e5';
    });

    section.addEventListener('mouseleave', function () {
      section.style.backgroundColor = '';
    });
  });
});


const sliderWrapper = document.querySelector('.slider-wrapper');
  const dotsContainer = document.getElementById('dots-container');
  let currentIndex = 0;

  function showSlide(index) {
    const slides = document.querySelectorAll('.slide');
    const slideWidth = slides[0].offsetWidth;
    const newPosition = -index * slideWidth;
    sliderWrapper.style.transform = `translateX(${newPosition}px)`;

    // Actualizar estado de los puntos indicadores
    const dots = document.querySelectorAll('.dot');
    dots.forEach((dot, i) => {
      dot.classList.toggle('active', i === index);
    });
  }

  function nextSlide() {
    currentIndex = (currentIndex + 1) % document.querySelectorAll('.slide').length;
    showSlide(currentIndex);
  }

  function prevSlide() {
    currentIndex = (currentIndex - 1 + document.querySelectorAll('.slide').length) % document.querySelectorAll('.slide').length;
    showSlide(currentIndex);
  }

  function createDots() {
    const slidesCount = document.querySelectorAll('.slide').length;
    for (let i = 0; i < slidesCount; i++) {
      const dot = document.createElement('span');
      dot.classList.add('dot');
      dot.addEventListener('click', () => showSlide(i));
      dotsContainer.appendChild(dot);
    }
    showSlide(currentIndex); // Mostrar el estado inicial
  }

  createDots();

  setInterval(nextSlide, 3000); // Cambia de s
