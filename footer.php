
<section id='footerInfoContainer'>
    <div class='footerInfo'>
        <h3>Opening Hours</h3>
        <div id='timesContainer'>
            <p class='openTimes'><span>Monday:</span></p><p class='times'>9am - 6pm</p>
            <p class='openTimes'><span>Tuesday:</span></p><p class='times'> 9am - 6pm</p>
            <p class='openTimes'><span>Wednesday:</span></p><p class='times'> 9am - 6pm </p>
            <p class='openTimes'><span>Thursday:</span></p><p class='times'> 9am - 9pm </p>
            <p class='openTimes'><span>Friday:</span></p><p class='times'> 9am - 6pm</p>
            <p class='openTimes'><span>Saturday:</span></p><p class='times'>9am - 6pm</p>
            <p class='openTimes'><span>Sunday:</span></p><p class='times'> 9am - 1pm</p>
        </div>
    </div>  
    <div class='verticalBreak'></div>
    <div class='footerInfo'>
        <h3>Location</h3>
        <p>143</p>
        <p>Trafalger Street</p>
        <p>Greenwich</p>
        <p>london</p>
        <p>SE10 7PQ</p>
    </div>
    <div class='verticalBreak'></div>
    <div class='footerInfo'>
        <h3>Menu</h3>
        <a href='mainPage.php'><p>Home</p></a>
        <?php  if($_SESSION['isStaff'] === TRUE){
            echo "<a href='editLibrary.php'><p>Edit Library</p></a>
                <a href='searchUser.php'><p>Search User</p></a>";
        }else {
            echo "<a href='profile.php'><p>profile</p></a>
                <a href='cart'><p>Cart</p></a>";
        } ?>
    </div>
    <div class='verticalBreak'></div>
    <div class='footerInfo'>
        <h3>Contact</h3>
        <p><span>Phone:</span> 0203 445 2881</p>
        <p><span>Email:</span> info@innercitylibrary.co.uk</p>
        <p id='social'><span>Social</p>
        <div>
            <a href='https://www.instagram.com/'><img id='instagram' src='assets/header-logos/instagram.png' alt='instagram icon'></a>
            <a href='https://www.facebook.com/'><img id='facebook' src='assets/header-logos/facebook.png' alt='facebook icon'></a>
            <a href='https://www.twitter.com'><img id='twitter' src='assets/header-logos/twitter.png' alt='twitter icon'></a>
        </div>
    </div>   
</section>

