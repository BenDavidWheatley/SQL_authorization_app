<?php 
session_start();
include('membersClassOOP.php');
include('libraryClassOOP.php');
include('login.php');


?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="style/style.css" type="text/css">
        <title>Library App</title>
    </head>
    <body id=body class='bodyImage'>
        <div class='pageContainer'>          
            <div class='mainContainer'>  
                <header>
                    <?php include('header.php')?>
                <header>                        
                <section id='searchLibrary'>
                    <div class='searchDatabaseContainer'>
                        <form class='searchDatabase' method='post' >
                            <input  name='searchDatabase' type='text' placeholder='Enter a the book and click the icon'>
                            <button type='submit' name='searchBook' ><img src='assets/header-logos/searchIcon.png'></button>
                        </form>
                        <?php  if($_SESSION['isStaff'] === TRUE){                          
                    echo "
                            <div class='spacer'>
                            </div>
                        <form class='searchDatabase' method='post'>   
                            <input id='searchAuthor' name='searchAuthor' type='text' placeholder='Enter an author and click the icon'>
                            <button type='submit' name='searchAuthorSubmit' value='search'><img src='assets/header-logos/searchIcon.png'></button>     
                        </form>                                         
                    ";
                    }?>
                    </div>
                </section>
                <?php include('search.php'); ?>
                <section class='eventsContainer'>
                    <section class='innerContainers' id='eventsAndInfoContainer'>
                        <h1>Welcome to the Inner City Library, London</h1>
                        <?php if($_SESSION['isStaff'] === TRUE) {
                            echo "<p> Use the search bar above to look for a book or an author within the library</p>
                            <p>To edit the book or author, head over to the edits page</p>"; 
                        }
                        else {
                            echo "<p> Use the search bar above to look for and check out a book  within the library</p>"; 
                        }?>
                        <h1>Upcoming Events</h1>
                        <div id='eventsContainer'>                          
                            <div class='events'> 
                                <img class='eventsImage' src='assets/events/eventOne.png' alt='Young girl peeking over the top of a book'>
                                <h2>Childrens Reading day</h2>
                                <h3>3rd August 2021</h3>
                                <p>Aenean finibus, massa non lacinia dictum, nisl lacus tristique risus, gravida tristique neque tellus eget nulla. Pellentesque a sem eu elit maximus fermentum vel quis odio. Aliquam erat volutpat. Phasellus ultrices est nec elit imperdiet fringilla. In sed hendrerit diam. Curabitur venenatis velit a lacinia mollis. Vestibulum massa dolor, sollicitudin ut turpis sed, facilisis pellentesque est.
                                <br><br>Ut sem eros, maximus suscipit libero eu, vestibulum hendrerit metus. Quisque dignissim arcu in ultrices egestas. Nulla lectus lectus, auctor at aliquet eu, pulvinar eu lectus. Praesent quis bibendum leo. Suspendisse sed pharetra magna. Duis lacinia neque a turpis bibendum, nec rutrum purus venenatis. Etiam neque orci, vestibulum nec ornare eget, blandit non massa. Praesent elementum, tortor a eleifend dignissim, lectus est commodo ipsum, vitae aliquet turpis ex ac tortor.</p>
                            </div>
                            <hr class='eventsHr'>
                            <div class='events'> 
                                <img class='eventsImage' src='assets/events/eventTwo.png' alt='a man and a women reading books, unable to see faces'>
                                <h2>Reading challange</h2>
                                <h3>14th August 2021</h3>
                                <p>In pretium lacus a rhoncus interdum. Nunc in ligula at urna sollicitudin imperdiet. Pellentesque imperdiet consequat augue. Ut in rhoncus diam. Phasellus maximus elit quis velit auctor auctor quis vitae dui. Aliquam eu tristique nisl. Aenean scelerisque tellus tempor tortor facilisis lobortis. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Maecenas id lorem ultrices, facilisis est vel, hendrerit elit. Sed lacus nunc, lobortis ut porttitor ut, mattis et ex. Nulla convallis enim at neque porttitor, laoreet venenatis mauris auctor.
                                <br><br>Aenean finibus, massa non lacinia dictum, nisl lacus tristique risus, gravida tristique neque tellus eget nulla. Pellentesque a sem eu elit maximus fermentum vel quis odio. Aliquam erat volutpat. Phasellus ultrices est nec elit imperdiet fringilla. In sed hendrerit diam. Curabitur venenatis velit a lacinia mollis. Vestibulum massa dolor, sollicitudin ut turpis sed, facilisis pellentesque est.</p>
                            </div>
                            <hr class='eventsHr'>
                            <div class='events'> 
                                <img class='eventsImage' src='assets/events/eventThree.png' alt='typewriter on green background'>
                                <h2>Short Story Competition</h2>
                                <h3>29th August 2021</h3>
                                <p>Ut sem eros, maximus suscipit libero eu, vestibulum hendrerit metus. Quisque dignissim arcu in ultrices egestas. Nulla lectus lectus, auctor at aliquet eu, pulvinar eu lectus. Praesent quis bibendum leo. Suspendisse sed pharetra magna. Duis lacinia neque a turpis bibendum, nec rutrum purus venenatis. Etiam neque orci, vestibulum nec ornare eget, blandit non massa. Praesent elementum, tortor a eleifend dignissim, lectus est commodo ipsum, vitae aliquet turpis ex ac tortor.
                                <br><br>Aliquam condimentum purus non tortor mattis ultricies. Duis sed neque nec lacus sodales pulvinar non vestibulum enim. Sed fermentum purus et libero ullamcorper congue a eu magna. Aliquam vulputate egestas massa, a posuere mauris varius id. Integer in aliquet nibh. Mauris finibus, urna id ornare posuere, mauris leo malesuada felis, vel sagittis ex nunc vitae tellus. Praesent mauris augue, dignissim eu fringilla non, gravida sed dui. Interdum et malesuada fames ac ante ipsum primis in faucibus.</p>
                            </div>
                            <hr class='eventsHr'>
                            <div class='events'> 
                                <img class='eventsImage' src='assets/events/eventFour.png' alt='three eldery ladies reading a books together'>
                                <h2>Benefits of reading - a talk</h2>
                                <h3>1st September 2021</h3>
                                <p>In pretium lacus a rhoncus interdum. Nunc in ligula at urna sollicitudin imperdiet. Pellentesque imperdiet consequat augue. Ut in rhoncus diam. Phasellus maximus elit quis velit auctor auctor quis vitae dui. Aliquam eu tristique nisl. Aenean scelerisque tellus tempor tortor facilisis lobortis. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Maecenas id lorem ultrices, facilisis est vel, hendrerit elit. Sed lacus nunc, lobortis ut porttitor ut, mattis et ex. Nulla convallis enim at neque porttitor, laoreet venenatis mauris auctor.
                                <br><br>   Aenean finibus, massa non lacinia dictum, nisl lacus tristique risus, gravida tristique neque tellus eget nulla. Pellentesque a sem eu elit maximus fermentum vel quis odio. Aliquam erat volutpat. Phasellus ultrices est nec elit imperdiet fringilla. In sed hendrerit diam. Curabitur venenatis velit a lacinia mollis. Vestibulum massa dolor, sollicitudin ut turpis sed, facilisis pellentesque est.</p>
                            </div>
                            <hr class='eventsHr'>
                            <div class='events'> 
                                <img class='eventsImage' src='assets/events/eventFive.png' alt='Young girl holding a book and smiling'>
                                <h2>Best childrens books 2021 awards</h2>
                                <h3>4th September 2021</h3>
                                <p>Aenean finibus, massa non lacinia dictum, nisl lacus tristique risus, gravida tristique neque tellus eget nulla. Pellentesque a sem eu elit maximus fermentum vel quis odio. Aliquam erat volutpat. Phasellus ultrices est nec elit imperdiet fringilla. In sed hendrerit diam. Curabitur venenatis velit a lacinia mollis. Vestibulum massa dolor, sollicitudin ut turpis sed, facilisis pellentesque est.
                                <br><br>Aliquam condimentum purus non tortor mattis ultricies. Duis sed neque nec lacus sodales pulvinar non vestibulum enim. Sed fermentum purus et libero ullamcorper congue a eu magna. Aliquam vulputate egestas massa, a posuere mauris varius id. Integer in aliquet nibh. Mauris finibus, urna id ornare posuere, mauris leo malesuada felis, vel sagittis ex nunc vitae tellus. Praesent mauris augue, dignissim eu fringilla non, gravida sed dui. Interdum et malesuada fames ac ante ipsum primis in faucibus.</p>
                            </div>
                            <hr class='eventsHr'>
                        </div>
                    </section>
                    
                </section>            
            </div>
            
            <footer class='footer' id='footerContainer'>
                <?php include('footer.php') ?>
            </footer>  
                  
        </div>
        <script src='script/script.js'></script> 
    </body> 
    
</html>