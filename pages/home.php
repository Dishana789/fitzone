<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   
    <link rel="stylesheet" href="customer.css" />
    <title>Home Page</title>
  </head>
  <body>
  <?php
    include('customer_nav.php');
    ?>

    <header class="header" id="header">
  <div class="section__container header__container">
    <div class="header__content">
      <h1>HARD WORK</h1>
      <h2>IS FOR EVERY SUCCESS</h2>
      <p>Start by taking inspirations, continue it to give inspirations</p>
      <div class="header__btn">
        <a href="registerpage.php" class="btn btn__primary">GET STARTED</a>
      </div>
    </div>
  </div>
</header>

    <section class="section__container about__container" id="about">
      <div class="about__header">
       
        <p class="section__description">
        <center>  Our mission is to be the best gym in Sri Lanka by offering a world-class fitness experience, a welcoming environment, and personalized services tailored to every member’s needs. </center>  
        </p>
      </div>
      <div class="about__grid">
  <div class="about__card">
    <h1 class="section__header">WE HAVE</h1>
    <h4>WINNER COACHES</h4>
    <p>
      We pride ourselves on having a team of dedicated and experienced
      coaches who are committed to helping you succeed.
    </p>
  </div>
  <div class="about__card">
    <h4>AFFORDABLE PRICE</h4>
    <p>
      We believe that everyone should have access to high-quality fitness
      facilities without breaking the bank.
    </p>
  </div>
  <div class="about__card">
    <h4>MODERN EQUIPMENTS</h4>
    <p>
      Stay ahead of the curve with our state-of-the-art equipment designed
      to elevate your workout experience.
    </p>
  </div>
</div>

<section class="session">
  <div class="session__card">
    <h4>BODY BUILDING</h4>
    <p>
      Sculpt your physique and build muscle mass with our specialized
      bodybuilding programs at Fitzone.
    </p>
    <a href="class.php" class="btn btn__secondary">
      MORE DETAILS <i class="ri-arrow-right-line"></i>
    </a>
  </div>
  <div class="session__card">
    <h4>CARDIO</h4>
    <p>
      Elevate your heart rate and boost your endurance with our dynamic
      cardio workouts at Fitzone.
    </p>
    <a href="class.php" class="btn btn__secondary">
      MORE DETAILS <i class="ri-arrow-right-line"></i>
    </a>
  </div>
  <div class="session__card">
    <h4>FITNESS</h4>
    <p>
      Embrace a holistic approach to fitness with our comprehensive fitness
      programs at Fitzone.
    </p>
    <a href="blogpage.php" class="btn btn__secondary">
      MORE DETAILS<i class="ri-arrow-right-line"></i>
    </a>
  </div>
  <div class="session__card">
    <h4>CROSSFIT</h4>
    <p>
      Experience the ultimate full-body workout with our intense CrossFit
      classes at Fitzone.
    </p>
    <a href="class.php" class="btn btn__secondary">
      MORE DETAILS <i class="ri-arrow-right-line"></i>
    </a>
  </div>
</section>

    <?php
    include('customer_footer.php');
    ?>

    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="main.js"></script>
  </body>
</html>
