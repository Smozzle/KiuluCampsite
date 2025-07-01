<?php
session_start();
include("user/config/user_config.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <link rel="stylesheet" href="./user/css/user_style.css">
  <title>KIULU CAMPSITE</title>
</head>
<body>

	<?php include("./user/includes/usernav.php"); ?>
	<?php include './user/includes/topNav.php';?>
	<?php include './user/userAuth/login_popup.php'; ?> 
	<?php include './user/userAuth/register_popup.php'; ?> 

	<?php
    if (isset($_GET['logout']) && $_GET['logout'] == 'success') {
      echo '<script type="text/javascript">alert("Logout successful!");</script>';
    }
  ?>

  <div id="topnav"></div>
  <header id="home">
    <div class="header__container">
      <div class="header__content">
        <h1>Experience the Magic of Nature</h1>
        <div class="header__btns">
          <button class="btn">Booking</button>
          <a href="#">
            <span><i class="ri-play-circle-fill"></i></span>
          </a>
        </div>
      </div>
    </div>
  </header>

  <section class="section__container destination__container" id="about">
    <h2 class="section__header">Popular Nature Enthusiast</h2>
    <p class="section__description">
		Discover the Most Beautiful Nature Destinations 
    </p>
    <div class="destination__grid">
      <div class="destination__card">
        <img src="user/img/tradisional.jpg" alt="traditional" />
        <div class="destination__card__details">
          <div>
            <h4>Traditional</h4>
			<p>Experience the charm of traditional accommodation at Kiulu Campsite – where 
				rustic comfort meets the serenity of nature</p>
          </div>
        </div>
      </div>
      <div class="destination__card">
        <img src="user/img/nature.jpg" alt="nature" />
        <div class="destination__card__details">
          <div>
            <h4>Nature</h4>
			<p> Immerse yourself in the beauty of nature at Kiulu Campsite, where the tranquility of the outdoors awaits.</p>
          </div>
        </div>
      </div>
      <div class="destination__card">
        <img src="user/img/fresh.jpg" alt="fresh" />
        <div class="destination__card__details">
          <div>
            <h4>Fresh</h4>
			<p>Enjoy the fresh air and serene landscapes at Kiulu Campsite, a perfect escape into nature's embrace.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="section__container journey__container" id="tour">
    <h2 class="section__header">Journey To The Nature!</h2>
    <p class="section__description">
      Effortless Planning for Your Next Adventure
    </p>
    <div class="journey__grid">
      <div class="journey__card">
        <div class="journey__card__bg">
          <span><i class="ri-bookmark-3-line"></i></span>
          <h4>Seamless Booking Process</h4>
        </div>
        <div class="journey__card__content">
          <span><i class="ri-bookmark-3-line"></i></span>
          <h4>Easy Reservations, One Click Away</h4>
          <p>
            From accommodations to activities and transfers,
            everything you need is available at your fingertips, making holiday
            planning effortless.
          </p>
        </div>
      </div>
      <div class="journey__card">
        <div class="journey__card__bg">
          <span><i class="ri-landscape-fill"></i></span>
          <h4>Nature Activities</h4>
        </div>
        <div class="journey__card__content">
          <span><i class="ri-landscape-fill"></i></span>
          <h4>Customized Activities for You</h4>
          <p>
            Enjoy personalized travel plans designed to match your preferences
            and interests. Whether you seek adventure ensure your journey is uniquely yours.
          </p>
        </div>
      </div>
      <div class="journey__card">
        <div class="journey__card__bg">
          <span><i class="ri-map-2-line"></i></span>
          <h4>Expert Local Insights</h4>
        </div>
        <div class="journey__card__content">
          <span><i class="ri-map-2-line"></i></span>
          <h4>Insider Tips and Recommendations</h4>
          <p>
            We provide curated recommendations for dining, sightseeing, and
            hidden gems, so you can experience each destination like a local.
          </p>
        </div>
      </div>
    </div>
  </section>

  <section class="section__container showcase__container" id="package">
    <div class="showcase__image">
      <img src="user/img/showcase.jpg" alt="showcase" />
    </div>
    <div class="showcase__content">
      <h4>UNLEASH NATURE ADVENTURES WITH KIULU CAMPSITE</h4>
      <p>
	  Embark on a journey like no other with Kiulu Campsite, where your adventure dreams come to life.
	  Our mission is to inspire and facilitate your outdoor experiences, 
	  whether you seek the tranquil beauty of lush forests, the serenity of clear waters, or the thrill of exploring nature's wonders. 
	  At Kiulu Campsite, we offer expertly curated nature escapes and personalized itineraries, ensuring every trip is tailored to your unique preferences. 
	  Discover hidden gems in the wilderness, immerse yourself in peaceful surroundings, and create unforgettable memories in the heart of nature
      </p>
      <p>
	  With Kiulu Campsite as your ultimate nature companion, 
	  exploring the beauty of the outdoors has never been easier. 
	  Our expert advice and local knowledge provide you with the tools to navigate the wilderness with confidence and excitement. 
	  From the moment you start planning your adventure to the day you return, 
	  we are dedicated to making your camping experience seamless and unforgettable
      </p>
    </div>
  </section>

  <section class="section__container discover__container">
    <h2 class="section__header">Discover The World Of Nature</h2>
    <p class="section__description">
	Experience Breathtaking Landscapes and Unique Perspectives
    </p>
    <div class="discover__grid">
      <div class="discover__card">
        <span><i class="ri-camera-lens-line"></i></span>
        <h4>Wilderness Views</h4>
        <p>
		Witness the majestic landscapes and serene beauty of nature from 
		a bird's-eye view, offering a unique perspective of Kiulu Campsite.
        </p>
      </div>
      <div class="discover__card">
        <span><i class="ri-ship-line"></i></span>
        <h4>River Wonders</h4>
        <p>
		Glide over the tranquil river waters at Kiulu Campsite, uncovering hidden streams, 
		lush surroundings, and the natural beauty of the landscape.
        </p>
      </div>
      <div class="discover__card">
        <span><i class="ri-landscape-line"></i></span>
        <h4>Traditional Accommodations</h4>
        <p>
		Experience the charm and heritage of time-honored lodgings at Kiulu Campsite, 
		offering a unique perspective of the past that regular stays can't provide.
        </p>
      </div>
    </div>
  </section>

  <!-- Lucky Draw Section -->
  <section class="section__container lucky_draw__container" id="lucky_draw">
  <h2 class="section__header" style="font-size: 2.5em; color: #fff; text-align: center; margin-bottom: 20px;">🍀 Try Your Luck! 🍀</h2>
  <p class="section__description" style="font-size: 1.2em; color: #fff; text-align: center; margin-bottom: 30px;">Participate in our lucky draw and win amazing prizes!</p>
  
  <div class="lucky-draw-box" style="background-color: #eaf6f0; border-radius: 25px; padding: 40px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1); margin: 0 auto; max-width: 600px; display: flex; flex-direction: column; align-items: center; justify-content: center;">
    <div class="prize-display" style="text-align: center; margin-bottom: 30px;">
      <img src="img/lucky draw.png" alt="Lucky Draw Icon" style="width: 120px; height: 120px; margin-bottom: 20px; display: block; margin-left: auto; margin-right: auto;">
      <h3 style="color: #1b8c46; font-size: 1.8em;">Win Prizes Like Never Before!</h3>
      <p style="color: #333; font-size: 1.1em;">Join our lucky draw and grab your chance to win amazing prizes. The more you participate, the higher your chances to win!</p>
    </div>
    <a href="voucher/luckyprize.php" class="btn" style="background-color: #1b8c46; color: white; padding: 18px 30px; font-size: 1.3em; border-radius: 50px; text-transform: uppercase; box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15); transition: all 0.3s ease;">
      <span>Join the Lucky Draw</span>
    </a>
  </div>

  <div class="prize-info" style="margin-top: 30px; text-align: center;">
    <p style="font-size: 1.1em; color: #fff; margin-bottom: 10px;">Only <strong>10 prizes</strong> left to win! Don't miss out!</p>
    <p style="font-size: 1.1em; color: #fff;">Hurry up, the clock is ticking! ⏳</p>
  </div>
</section>

<style>
  #lucky_draw {
    background: linear-gradient(135deg, rgba(144, 238, 144, 1) 0%, rgba(34, 193, 195, 1) 100%);
    padding: 50px 0;
    text-align: center;
  }
  
  .btn:hover {
    transform: scale(1.1);
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.1);
  }

  .section__header {
    font-weight: bold;
    letter-spacing: 1.2px;
    color: #fff;
  }

  .prize-info p {
    color: #fff;
    font-weight: bold;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
  }

  .lucky-draw-box {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
  }
</style>

  <section class="section__container client__container">
    <h2 class="section__header">Beloved by Over a Thousand Nature Seekers</h2>
    <p class="section__description">
	"Discover the tales of adventure 
	and cherished memories through the eyes of our valued nature explorers.".
    </p>
  </section>

   <?php include './user/includes/user_Footer.php';?>
  <script src="./user/js/user_Script.js"></script>

</body>
</html>
