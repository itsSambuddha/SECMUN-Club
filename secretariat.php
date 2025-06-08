<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Secretariat Carousel</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="progressbar.css" />
</head>
  <body>
  <?php include 'header.php'; ?>
  <h1> Meet The Secretariat of 2025-26 </h1>
  <div class="carousel-wrapper">
    <div class="carousel-container" id="carousel1">
      <h2 class="carousel-title" id="title1">Senior Secretariat</h2>
      <div class="new-progress-bar" id="progressBar1"><div class="new-progress-bar-fill" id="progressBarFill1"></div></div>
      <div class="carousel" id="carousel">
        <div class="carousel-item">
          <img src="https://cdn.vuetifyjs.com/images/cards/docks.jpg" alt="President" />
          <div class="caption">The President</div>
          <div class="info-placeholder">
            <ul>
              <li>Name: Naphibansabet Byrsat</li>
              <li>Department: Sociology</li>
              <li>Semester: 5th</li>
            </ul>
            <p>Miscellaneous message here.</p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="https://cdn.vuetifyjs.com/images/cards/hotel.jpg" alt="Secretary General" />
          <div class="caption">The Secretary General</div>
          <div class="info-placeholder">
            <ul>
              <li>Name: Sambuddha Das</li>
              <li>Department: Computer Science</li>
              <li>Semester: 5th</li>
            </ul>
            <p>Miscellaneous message here.</p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="https://cdn.vuetifyjs.com/images/cards/sunshine.jpg" alt="Assistant General Secretary" />
          <div class="caption">Assistant General Secretary</div>
          <div class="info-placeholder">
            <ul>
              <li>Name: Sneha Das</li>
              <li>Department: Psychology</li>
              <li>Semester: 3rd</li>
            </ul>
            <p>Miscellaneous message here.</p>
          </div>
        </div>
      </div>
      <button class="carousel-control prev" aria-label="Previous" id="prevBtn">&#10094;</button>
      <button class="carousel-control next" aria-label="Next" id="nextBtn">&#10095;</button>
    </div>
    <div class="carousel-container shrinked" id="carousel2">
      <h2 class="carousel-title" id="title2">Under Secretary General </h2>
      <div class="new-progress-bar" id="progressBar2"><div class="new-progress-bar-fill" id="progressBarFill2"></div></div>
      <div class="carousel" id="carouselCopy">
        <div class="carousel-item">
          <img src="https://cdn.vuetifyjs.com/images/cards/docks.jpg" alt="USG_PR" />
          <div class="caption">Head of Public Relations</div>
          <div class="info-placeholder">
            <ul>
              <li>Name: Naphibansabet Byrsat</li>
              <li>Dept: Sociology</li>
              <li>Sem: 5</li>
            </ul>
            <p>Miscellaneous message here.</p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="https://cdn.vuetifyjs.com/images/cards/hotel.jpg" alt="USG_D_PR" />
          <div class="caption">Deputy Head of Public Relations</div>
          <div class="info-placeholder">
            <ul>
              <li>Name: Sambuddha Das</li>
              <li>Dept: Computer Science</li>
              <li>Sem: 4</li>
            </ul>
            <p>Miscellaneous message here.</p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="https://cdn.vuetifyjs.com/images/cards/sunshine.jpg" alt="Assistant General Secretary" />
          <div class="caption">Assistant General Secretary</div>
          <div class="info-placeholder">
            <ul>
              <li>Name: Sneha Das</li>
              <li>Dept: Psychology</li>
              <li>Sem: 3</li>
            </ul>
            <p>Miscellaneous message here.</p>
          </div>
        </div>
      </div>
      <button class="carousel-control prev" aria-label="Previous" id="prevBtnCopy">&#10094;</button>
      <button class="carousel-control next" aria-label="Next" id="nextBtnCopy">&#10095;</button>
    </div>
  </div>
  <div class="space">
    <p> <p>
  </div>
  <?php include 'footer.php'; ?>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const carousel1 = document.getElementById('carousel');
      const prevBtn1 = document.getElementById('prevBtn');
      const nextBtn1 = document.getElementById('nextBtn');
      const progressBarFill1 = document.getElementById('progressBarFill1');
      const totalItems1 = carousel1.children.length;
      let index1 = 0;

      const carousel2 = document.getElementById('carouselCopy');
      const prevBtn2 = document.getElementById('prevBtnCopy');
      const nextBtn2 = document.getElementById('nextBtnCopy');
      const progressBarFill2 = document.getElementById('progressBarFill2');
      const totalItems2 = carousel2.children.length;
      let index2 = 0;

      function updateProgressBar1(i) {
        const progressPercent = ((i + 1) / totalItems1) * 100;
        progressBarFill1.style.width = progressPercent + '%';
      }

      function updateProgressBar2(i) {
        const progressPercent = ((i + 1) / totalItems2) * 100;
        progressBarFill2.style.width = progressPercent + '%';
      }

      function showSlide1(i) {
        if (i < 0) index1 = totalItems1 - 1;
        else if (i >= totalItems1) index1 = 0;
        else index1 = i;
        carousel1.style.transform = 'translateX(' + (-index1 * 100) + '%)';
        updateProgressBar1(index1);
      }

      function showSlide2(i) {
        if (i < 0) index2 = totalItems2 - 1;
        else if (i >= totalItems2) index2 = 0;
        else index2 = i;
        carousel2.style.transform = 'translateX(' + (-index2 * 100) + '%)';
        updateProgressBar2(index2);
      }

      prevBtn1.addEventListener('click', () => {
        showSlide1(index1 - 1);
        shrinkCarousel2();
      });

      nextBtn1.addEventListener('click', () => {
        showSlide1(index1 + 1);
        shrinkCarousel2();
      });

      showSlide1(index1);

      prevBtn2.addEventListener('click', () => {
        showSlide2(index2 - 1);
        shrinkCarousel1();
      });

      nextBtn2.addEventListener('click', () => {
        showSlide2(index2 + 1);
        shrinkCarousel1();
      });

      showSlide2(index2);

      // Shrink and expand logic
      const carouselContainer1 = document.getElementById('carousel1');
      const carouselContainer2 = document.getElementById('carousel2');
      const title1 = document.getElementById('title1');
      const title2 = document.getElementById('title2');

      function shrinkCarousel1() {
        carouselContainer1.classList.add('shrinked');
        carouselContainer2.classList.remove('shrinked');
        // Titles remain visible
        title1.style.display = 'block';
        title2.style.display = 'block';
      }

      function shrinkCarousel2() {
        carouselContainer2.classList.add('shrinked');
        carouselContainer1.classList.remove('shrinked');
        // Titles remain visible
        title2.style.display = 'block';
        title1.style.display = 'block';
      }

      // Initially show both titles
      title1.style.display = 'block';
      title2.style.display = 'block';

      // Add event listeners to toggle shrink on carousel controls
      let shrinkOnClickDisabled = false;

      prevBtn1.addEventListener('click', () => {
        if (!shrinkOnClickDisabled) {
          shrinkCarousel2();
          shrinkOnClickDisabled = true;
        }
      });
      nextBtn1.addEventListener('click', () => {
        if (!shrinkOnClickDisabled) {
          shrinkCarousel2();
          shrinkOnClickDisabled = true;
        }
      });
      prevBtn2.addEventListener('click', () => {
        if (!shrinkOnClickDisabled) {
          shrinkCarousel1();
          shrinkOnClickDisabled = true;
        }
      });
      nextBtn2.addEventListener('click', () => {
        if (!shrinkOnClickDisabled) {
          shrinkCarousel1();
          shrinkOnClickDisabled = true;
        }
      });

      // Add hover event listeners to toggle shrink on mouse enter/leave
      let hoverTimeout1 = null;
      carouselContainer1.addEventListener('mouseenter', () => {
        if (hoverTimeout1) clearTimeout(hoverTimeout1);
        shrinkCarousel2();
        shrinkOnClickDisabled = false;
      });
      carouselContainer1.addEventListener('mouseleave', () => {
        hoverTimeout1 = setTimeout(() => {
          carouselContainer1.classList.remove('shrinked');
          carouselContainer2.classList.remove('shrinked');
          title1.style.display = 'block';
          title2.style.display = 'block';
        }, 100);
      });

      let hoverTimeout2 = null;
      carouselContainer2.addEventListener('mouseenter', () => {
        if (hoverTimeout2) clearTimeout(hoverTimeout2);
        shrinkCarousel1();
        shrinkOnClickDisabled = false;
      });
      carouselContainer2.addEventListener('mouseleave', () => {
        hoverTimeout2 = setTimeout(() => {
          carouselContainer1.classList.remove('shrinked');
          carouselContainer2.classList.remove('shrinked');
          title1.style.display = 'block';
          title2.style.display = 'block';
        }, 100);
      });
    });
  </script>
</body>
</html>

  </script>
</body>
</html>
