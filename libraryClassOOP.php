<?php

/* INDEX 
FUNCTIONS 
line xx 
*/
session_start();

include('login.php');
include('connect.php');
include('editLibrary');
include('memebersClassOOP.php');

class LibraryDatabase {

    public $numBooksInCart = 0;
    private $currentlyCheckedOut = [];

// ******** SETTERS ********

    public function setNumInCart() {    
        $id = $_SESSION['userId']; 
        $sql = "SELECT COUNT(*) AS 'count' FROM cart WHERE users_id = '$id'";
        global $mysqli;
        $search = $mysqli->query($sql);
        $result = $search->fetch_assoc();      
        $this->numBooksInCart = $result['count'];
    }
    
// ******** GETTERS ********

    public function getNumInCart(){      
        echo $this->numBooksInCart;  
    }

// ******** METHODS ********  

// This function will search the database for all or a particular author.

    public function searchAuthor(){
        $curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1); 
        echo "<h3>Your author search result is - </h3>";
        $authorName = '%'. $_POST['searchAuthor'] .'%'; 
        $sql = "SELECT * FROM authors  WHERE author_name LIKE '$authorName'";
        global $mysqli;    
        $doesAuthorExist = $mysqli->query($sql);    
            while($author = $doesAuthorExist->fetch_assoc()){;                              
                echo "<table id='searchAuthorContainer'>
                        <tr class='searchTable'>";                        
                        if ($curPageName === 'mainPage.php'){
                            echo "<img class='image' src='assets/authors/" . $author['author_image'] . "'>";
                        }                          
                echo       "<td>" . $author["author_name"]. "</td>
                            <td>" . $author["age"]. "</td>
                            <td>" . $author["genre"]. "</td>                                                                                                                
                            <form method='post'>
                                <button id=" . $author["author_id"] . " type='submit' name='viewBooks' value=" . $author["author_id"] . ">View books</button> ";
                                    if ($curPageName === 'editLibrary.php') {
                                        echo "<button type='submit' name='editAuthor' value=" . $author["author_id"] . ">Edit Author</button>
                                              <button class='delete' id=" . $author["author_id"] . "type='submit' name='deleteAuthor' value=" . $author["author_id"] . ">Delete Author</button>";
                                    } 
                                echo "<button onClick='window.location.href=window.location.href'>Cancel</button>
                            </form>    
                            </td>
                        <tr>     
                    </table>";
                }                             
        $authorDoesNot = $mysqli->query($sql);
        $autDoesNot = $authorDoesNot->fetch_assoc();
            if ($autDoesNot["author_name"] === NULL  &&  $curPageName === 'editLibrary.php') {
            echo '<h4>Author is not in the database.
            create author input</h4>';
            echo "<div id='formContainerAuthor'>
                    <form id='authorFormContainer' method='post' enctype='multipart/form-data'>
                        <label for='authorsName'>Authors Name</label>
                        <input id='authorsName' name='authorsName' type='text' pattern='[a-z A-Z]+' required>

                        <label for='authorsAge'>Authors Age</label>
                        <input id='authorsAge' name='authorsAge' type='text' pattern='[0-9 a-z A-Z]+' required>

                        <label for='mainGenre'>Main Genre</label>
                        <select id='mainGenre' name='mainGenre' required>
                            <option hidden disabled selected value> -- select an option -- </option>
                            <option>Fiction</option>
                            <option>Non-fiction</option>
                        </select>

                        <label for='authorBio'>Add a bio of the author</label>
                        <input name='authorBio' type='textarea' >

                        <label for='authorImage'>Upload Authors Image</label>
                        <input type='file' name='authorImage'>                   

                        <input type='submit' name='submitAuthor' value='submit'> 
                        <button onClick='window.location.href=window.location.href'>Cancel</button>
                    </form>
                </div>";
            } else if ($autDoesNot["author_name"] === NULL  &&  $curPageName === 'mainPage.php'){
                echo "Unfortuntalty the author you are looking for is not in our library";
            };   
    }  
// This function will add a new author to the database

    public function addAuthorToDatabase(){
        $authorsName = $_POST['authorsName'];
        $authorsAge = $_POST['authorsAge'];
        $mainGenre = $_POST['mainGenre'];
        $authorBio = $_POST['authorBio'];
        $authorImage = $_FILES['authorImage'];

                    if ($_FILES['authorImage']['error'] === 0){
                        $fileName = $_FILES['authorImage']['name'];
                        $fileTmpName = $_FILES['authorImage']['tmp_name'];
                        $fileSize = $_FILES['authorImage']['size'];
                        $fileError = $_FILES['authorImage']['error'];
                        $fileType = $_FILES['authorImage']['type'];           
                        $fileExt = explode('.', $fileName);
                        $fileActualExt = strtolower(end($fileExt));                    
                        $allowed = array('jpg', 'jpeg', 'png');

                        if (in_array($fileActualExt, $allowed)) {
                            if ($fileError === 0){
                                if ($fileSize < 5000000){
                                    $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                                    $fileDestination = 'assets/authors/' . $fileNameNew;
                                    move_uploaded_file($fileTmpName, $fileDestination);
                                    $author = "INSERT INTO authors (author_name, age, genre, author_bio, author_image) VALUE ('$authorsName', '$authorsAge', '$mainGenre', '$authorBio', '$fileNameNew')";
                                    global $mysqli;
                                                
                                        if ($mysqli->query($author) === TRUE) {
                                            echo "New record created successfully";
                                            } else {
                                                echo "Error <br>" .  $mysqli->error;
                                            }                
                                } else {
                                    echo "Your file is too big, image must be less then 5mb";
                                }
                            } else {
                                echo 'There was an error uploading your file';
                            }
                        } else {
                            echo 'You cannot upload files of this type, file must be either jpeg, jpg or png';
                        };  
                    } else {
                        $sql = "INSERT INTO authors (author_name, age, genre, author_bio) VALUE ('$authorsName', '$authorsAge', '$mainGenre', '$authorBio')";
                        global $mysqli;                               
                        if ($mysqli->query($sql) === TRUE) {
                            echo "New author added to database";
                            } else {
                                echo "Error: " . $authorName . "<br>" .  $mysqli->error;
                                }    
                    }       
    }
    public function editAuthor(){
        $id = $_POST['editAuthor'];
        echo $id;
        
        $sql = "SELECT * FROM authors WHERE author_id = '$id'"; 
        global $mysqli;                               
        $author = $mysqli->query($sql);                                           
        $rows = $author->fetch_assoc();

        echo "<div id='formContainerAuthor'>
                    <form id='authorFormContainer' method='post' enctype='multipart/form-data'>
                        <label for='authorsName'>Authors Name</label>
                        <input id='authorsName' name='authorsNameEdit' type='text' pattern='[a-z A-Z]+' value='" . $rows['author_name'] . "' required>

                        <label for='authorsAge'>Authors Age</label>
                        <input id='authorsAge' name='authorsAgeEdit' type='text' min='0' max='150' pattern='[0-9 a-z A-Z]+' value='" . $rows['age'] . "' required>

                        <label for='mainGenre'>Main Genre</label>
                        <select id='mainGenre' name='mainGenreEdit' required>
                            <option>" . $rows['genre'] . "</option>
                            <option>Fiction</option>
                            <option>Non-fiction</option>
                        </select>

                        <label for='editAuthorBio'>Edit the Author Bio</label>
                        <input type='textarea' name='editAuthorBio'>

                        <label for='authorImageEdit'>Change Image</label>
                        <input type='file' name='authorImageEdit'>

                        <button type='submit' name='submitAuthorEdit' value='" . $id . "'>Submit Edit</button>
                        <button onClick='window.location.href=window.location.href'>Cancel</button>
                    </form>
                </div>";
    }
    public function submitAuthorEdit(){
        $id = $_POST['submitAuthorEdit'];    
        $authorName = $_POST['authorsNameEdit'];        
        $age = $_POST['authorsAgeEdit'];
        $genre = $_POST['mainGenreEdit'];   
        $authorBio = $_POST['editAuthorBio'];   
        $sql = "UPDATE authors
                SET author_name = '$authorName', age = '$age', genre = '$genre', author_bio = '$authorBio'
                WHERE author_id = '$id'";   
        global $mysqli;    
            if ($mysqli->query($sql) === TRUE) {
                echo "Record '" . $authorName . "' updated successfully";
            } else {
                echo "Error editing record: " . $mysqli->error;
        }


        if ($_FILES['authorImageEdit']['error'] === 0) {  
            echo "yes"    ;      
            $sqlImage = "SELECT author_image FROM authors WHERE author_id = '$id'";          
            global $mysqli;
            $mysqli->query($sqlImage);
            $fetch = $mysqli->query($sqlImage);    
            $getImage = $fetch->fetch_assoc();
            $oldImage = $getImage['author_image'];             
            $path = "assets/authors/" . $oldImage;
                if (file_exists($path)){
                    unlink($path);
                    $sqlImage = "UPDATE authors SET author_image = NULL WHERE author_id = '$id'";
                        global $mysqli;
                        $mysqli->query($sqlImage);
                }                                     
                
                $fileName = $_FILES['authorImageEdit']['name'];
                $fileTmpName = $_FILES['authorImageEdit']['tmp_name'];
                $fileSize = $_FILES['authorImageEdit']['size'];
                $fileError = $_FILES['authorImageEdit']['error'];
                $fileType = $_FILES['authorImageEdit']['type'];
                $fileExt = explode('.', $fileName);
                $fileActualExt = strtolower(end($fileExt));       
                $allowed = array('jpg', 'jpeg', 'png');

                    if (in_array($fileActualExt, $allowed)) {
                        if ($fileError === 0){
                            if ($fileSize < 5000000){
                                $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                                $fileDestination = 'assets/authors/' . $fileNameNew;
                                    move_uploaded_file($fileTmpName, $fileDestination);                              
                                $sql= "UPDATE authors SET author_image = '$fileNameNew' WHERE author_id = '$id'";

                                global $mysqli;
                                    if ($mysqli->query($sql) === TRUE) {
                                        echo "New record created successfully";
                                        } else {
                                            echo "Error: " .  $mysqli->error;
                                        }                
                            } else {
                                echo "Your file is too big, image should be less the 5mb";
                            }
                        } else {
                            echo 'There was an error uploading your file';
                        }
                    } else {
                        echo 'You cannot upload files of this type, file must be either jpeg, jpg or png';
                    };                         
        } else { 
            echo "image not edited";
        };
    }

// This function allows you to view all the authors books after searching for the author.

    public function viewAuthorsBooks(){
        $curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1); 
        $id = $_POST['viewBooks'];
        $sql = "SELECT * FROM books WHERE author_id = '$id'";
        global $mysqli;
        $viewBooks = $mysqli->query($sql);        
            while($author = $viewBooks->fetch_assoc()){
                    echo 
                    "<table> 
                        <tr>
                            <td>" . $author["book_title"] . "</td>
                            <td>" . $author["year_released"] . "</td>
                            <td>" . $author["book_genre"] . "</td> 
                            <td>" . $author["age_group"] . "</td>                               
                        </tr>                              
                    </table>"; 
            }; 
        if($curPageName === 'editLibrary.php'){
            echo "<form method='post'>
                    <button id=" . $id . " type='submit' name='addBookToDatabase' value=" . $id . ">add book</button>
                </form>";
        }
    }
    public function addBookForm() {
        $id = $_POST['addBookToDatabase'];
        echo    "<div id='formContainerBook'>      
                    <form id='bookFormContainer' method='post'  enctype='multipart/form-data'>
                        <h2>Create a new book or author entry into the libraries database</h2>
                        <label for='bookTitle'>Book Title</label>
                        <input id='bookTitle' name='bookTitle' type='text' required>
                    
                        <label for='yearReleased'>Year released</label>
                        <input id='yearReleased' name='yearReleased' type='text' pattern='[0-9]+' required>

                        <label for='genre'>Genre</label>
                        <select id='genre' name='genre' required>
                            <option hidden disabled selected value> -- select an option -- </option>
                            <option value='action_and_adventure'>Action and Adventure</option>
                            <option value='art_and_photography'>Art and Photography</option>
                            <option value='biography'>Biography</option>
                            <option value='childrens'>Children's</option>
                            <option value='dystopian'>Dystopian</option>
                            <option value='fantasy'>Fantasy</option>
                            <option value='food_and_drink'>Food and Drink</option>
                            <option value='graphic_novel'>Graphic Novel</option>
                            <option value='historical_fiction'>Historical Fiction</option>
                            <option value='history'>History</option>
                            <option value='horror'>Horror</option>
                            <option value='humanities_and_social_sciences'>Humanities & Social Sciences</option>
                            <option value='humor'>Humor</option>
                            <option value='memoir_and_autobiography'>Memoir and Autobiography</option>
                            <option value='mystery'>Mystery</option>
                            <option value='new_adult'>New Adult</option>
                            <option value='novel'>Novel</option>
                            <option value='parenting_and_families'>Parenting & Families</option>
                            <option value='poetry'>Poetry</option>
                            <option value='psychology'>Psychology</option>
                            <option value='religion_and_spirituality'>Religion & Spirituality</option>
                            <option value='romance'>Romance</option>
                            <option value='science_and_technology'>Science & Technology</option>
                            <option value='science_fiction'>Science Fiction</option>
                            <option value='self_help'>Self Help</option>
                            <option value='short_story'>Short Story</option>
                            <option value='thriller_and_suspence'>Thriller and Suspence</option>
                            <option value='travel'>Travel</option>
                            <option value='true_crime'>True Crime</option>
                            <option value='young_adult'>Young Adult</option>
                        </select>

                        <label for='ageGroup'>Age Group</label>
                        <select id='ageGroup' name='ageGroup' required>
                            <option hidden disabled selected value> -- select an option -- </option>
                            <option value='all ages'>All ages</option>
                            <option value='childrenFiction'>Childrens Fiction</option>
                            <option value='teenageFiction'>Teenage Fiction</option>
                            <option value='adultFiction'>Adult Fiction</option>
                            <option value='0-1'>0 - 1</option>
                            <option value='0-2'>1 - 2</option>
                            <option value='3-5'>3 - 4</option>
                            <option value='5'>5</option>
                            <option value='6-7'>6 - 7</option>
                            <option value='8-10'>8 - 10</option>
                            <option value='12-15'>11 - 13</option>
                            <option value='12-17'>12 - 17</option>
                            <option value='12+'>12 and above</option>
                            <option value='14+'>14 and above</option>
                            <option value='16+'>16 and above</option>
                            <option value='18+'>18 and above</option>
                        </select>

                        <label for='file'>Upload Book Image</label>
                        <input type='file' name='file'>

                        <button type='submit' name='submitBook' value=" . $id . ">Submit</button>  
                        <button onClick='window.location.href=window.location.href'>Cancel</button>   
                    </form>
                </div>";
    }
    public function addBookToDatabase(){
        $id = ($_POST['submitBook']);
        $bookTitle = $_POST['bookTitle'];                   
        $yearReleased = $_POST['yearReleased'];
        $genre = $_POST['genre'];
        $ageGroup = $_POST['ageGroup'];    

        if ($_FILES['file']['error'] === 0){
            $fileName = $_FILES['file']['name'];
            $fileTmpName = $_FILES['file']['tmp_name'];
            $fileSize = $_FILES['file']['size'];
            $fileError = $_FILES['file']['error'];
            $fileType = $_FILES['file']['type'];

            $fileExt = explode('.', $fileName);
            $fileActualExt = strtolower(end($fileExt));

            $allowed = array('jpg', 'jpeg', 'png');
            if (in_array($fileActualExt, $allowed)) {
                if ($fileError === 0){
                    if ($fileSize < 5000000){
                        $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                        $fileDestination = 'assets/books/' . $fileNameNew;
                        move_uploaded_file($fileTmpName, $fileDestination);

                        $book = "INSERT INTO books (book_title, year_released, book_genre, age_group, author_id, images)
                        VALUES ('$bookTitle', '$yearReleased', '$genre', '$ageGroup', '$id', '$fileNameNew')";
                        global $mysqli;

                            if ($mysqli->query($book) === TRUE) {
                                echo "New record created successfully";
                                } else {
                                    echo "Error: " . $bookTitle . "<br>" .  $mysqli->error;
                                }                
                    } else {
                        echo "Your file is too big, image must be less then 5mb";
                    }
                } else {
                    echo 'There was an error uploading your file';
                }
            } else {
                echo 'You cannot upload files of this type, file must be either jpeg, jpg or png';
            };  
        } else {
            $sql = "INSERT INTO books (book_title, year_released, book_genre, age_group, author_id)
            VALUES ('$bookTitle', '$yearReleased', '$genre', '$ageGroup', '$id')";
            global $mysqli;

                if ($mysqli->query($sql) === TRUE) {
                    echo "New record created successfully";
                    } else {
                        echo "Error: " . $bookTitle . "<br>" .  $mysqli->error;
                    } 
        } 
    }  
    public function searchBook(){        
        $result = '%'. $_POST['searchDatabase'] .'%';  
        $_SESSION['search'] = $result;           
        echo "<h2 class='searchResultTitle'>Your search result is - </h2>";
        $sqls = "SELECT * FROM books LEFT OUTER JOIN authors ON books.author_id = authors.author_id 
        WHERE book_title LIKE '$result'";
        global $mysqli;
        $searchResult = $mysqli->query($sqls); 
                echo "<div class='orgnaiseSearchContainer'>               
                        <form class='organiseSearch' method='post'>                       
                            <h3 class='sortHeading sortTitle'>Title</h3>
                            <div id='sortByTitle' class='sortButtons'>
                                <button type='submit' name='sortByTitleAsc' value='sortByTitle'>Asc</button>
                                <button type='submit' name='sortByTitleDesc' value='sortByTitle'>Desc</button>
                            </div>
                            <h3 class='sortHeading sortAuthor'>Author</h3>
                            <div id='sortByAuthor' class='sortButtons'>
                                <button  type='submit' name='sortByAuthorAsc' value='sortByAuthor'>Asc</button>
                                <button  type='submit' name='sortByAuthorDesc' value='sortByAuthor'>Desc</button>
                            </div>                            
                            <h3 class='sortHeading sortYear'>Year</h3>
                            <div id='sortByYear' class='sortButtons'>
                                <button  type='submit' name='sortByYearAsc' value='sortByYear'>Asc</button>
                                <button  type='submit' name='sortByYearDesc' value='sortByYear'>Desc</button>  
                            </div>
                            <h3 class='sortHeading sortGenre'>Genre</h3>   
                            <div id='sortByGenre' class='sortButtons'>                 
                                <button type='submit' name='sortByGenreAsc' value='sortByGenre'>Asc</button>   
                                <button type='submit' name='sortByGenreDesc' value='sortByGenre'>Desc</button> 
                            </div>
                            <h3 class='sortHeading sortAge'>Age Group</h3>
                            <div id='sortByAge' class='sortButtons'> 
                                <button type='submit' name='sortByAgeAsc' value='sortByAge'>Asc</button>
                                <button type='submit' name='sortByAgeDesc' value='sortByAge'>Desc</button>
                            </div>
                            <h3 class='sortHeading sortChecked'>Checked Out</h3>
                            <div id='isCheckedOut' class='sortButtons'> 
                                <button type='submit' name='sortByCheckedOutAsc' value='isCheckedOut'>Asc</button>
                                <button type='submit' name='sortByCheckedOutDesc' value='isCheckedOut'>Desc</button>
                            </div>
                        </form>
                    </div>";          
                    while($rows = $searchResult->fetch_assoc()){                          
                        echo "<table class='searchContainer'> 
                                <tr class='searchTable'>
                                    <td><img class='bookImage' src='assets/books/" . $rows['images'] . "'></td>
                                    <td class='bookSearchTitle'><h2>" . $rows["book_title"]. "</h2><h4> by " . $rows["author_name"] . " (" .  $rows["year_released"] . ")</h4></td>
                                    <td class='bookSearchAbout'>" . $rows["about_book"] . "</td>
                                    <td class='bookSearchGenre'>Genre - " . $rows["book_genre"]. "</td>
                                    <td class='bookSearchAge'>Age Group -" . $rows["age_group"]. "</td>
                                    <td class='bookSearchCheckedin'>Available - ";
                                        if($rows["is_checked_out"] === "1"){                            
                                            echo 'yes';
                                        } else {
                                            echo 'no';
                                        };                                                     
                                    echo "</td>  
                                    <td class='bookSearchButton'>";
        
                                    if ($_SESSION['isStaff'] === TRUE){
                                        echo    
                                        "<form   method='post'>
                                            <button id=" . $rows["book_id"] . " type='submit' name='edit' value=" . $rows["book_id"] . ">Edit</button>";
                                            if ($rows["is_checked_out"] != 1) {
                                                echo "<button type='submit' name='checkIn' value=" . $rows["book_id"] . " disabled>Checkin Book</button>";
                                            }else {
                                                echo "<button type='submit' name='checkIn' value=" . $rows["book_id"] . " >Checkin Book</button>";
                                            }
                                            
                                            echo "<button>Cancel</button>
                                        </form>"; 
                                    } else if ($rows["is_checked_out"] === "1" && $_SESSION['isStaff'] != TRUE) {
                                        echo     
                                        "<form method='post' action='mainPage.php#" . $rows["book_id"] . "'>                               
                                            <button id=" . $rows["book_id"] . " type='submit' name='addToCart' value=" . $rows["book_id"] . " disabled>Currently Unavailable</button> 
                                            <button >Cancel</button>
                                        </form>";                                  
                                    } else {
                                        echo     
                                        "<form method='post' action='mainPage.php#" . $rows["book_id"] . "'>                               
                                            <button id=" . $rows["book_id"] . " type='submit' name='addToCart' value=" . $rows["book_id"] . ">Add to Cart</button> 
                                            <button>Cancel</button>
                                        </form>";   
        
                                    }
                                    echo "</td>
                                <tr>     
                            </table>
                            <hr class='horzontalBreak'>";
                }
    }
    public function addToCart(){  
        $this->searchBook();  
        $bookId = $_POST['addToCart'];
        $id = $_SESSION['userId'];       
        $sql = "INSERT INTO cart (book_id, users_id) VALUES ('$bookId', '$id')";
        $sqlTwo = "SELECT * FROM cart WHERE book_id = '$bookId' AND users_id = '$id'";
        global $mysqli;
        $search = $mysqli->query($sqlTwo);
        $result = $search->fetch_assoc();
            if($result === NULL){               
                $mysqli->query($sql);
                echo "<div>
                        <p>book added to cart</p>";
                    
                        $this->setNumInCart();         
            } else {
                echo "<p>Book already added to the cart</p>";
                $this->setNumInCart(); 
            }    

        echo $this->numBooksInCart . " items in cart";   
        echo  "</div>";      
    } 
    public function availableAllowance() {
        $id = $_SESSION['userId'];
        $sql = "SELECT COUNT(book_id) AS 'count' FROM cart WHERE users_id = '$id'";
        $sqlCheck = "SELECT COUNT(book_id) AS 'currentlyCheckedOut' FROM checkedOut WHERE users_id = '$id'";
        global $mysqli;       
        $toCheckOut = $mysqli->query($sql);        
        $prevCheckedOut =  $mysqli->query($sqlCheck);
        $resultToCheckout = $toCheckOut->fetch_assoc();
        $resultPrevCheckout = $prevCheckedOut->fetch_assoc();
        $calculation = $resultToCheckout['count'] + $resultPrevCheckout['currentlyCheckedOut'];
        $canCheckOut = 6 - $resultPrevCheckout['currentlyCheckedOut'];

        echo   "<p>You currently have " . $resultPrevCheckout['currentlyCheckedOut'] . " books checked out.</p>
                <p> You may check out up to " . $canCheckOut . " books on this occation</p>";
    }
    public function currentCheckOut(){
        $id = $_SESSION['userId']; 
        $sql= "SELECT * FROM checkedOut LEFT OUTER JOIN books ON checkedOut.book_id = books.book_id WHERE users_id = '$id'";
        global $mysqli; 
        $checkedOut = $mysqli->query($sql);  
        $book = $checkedOut->fetch_assoc();       
        if($book['book_id']=== NULL){
            echo "<h2>You currently have nothing checked out</h2>";
        } else {
        Echo "<h2>You currently have the following checked out</h2>";           
        }
        $check = $mysqli->query($sql);
        while($books = $check->fetch_assoc()){
            echo "<div>
                    <p>" . $books['book_title'] . "</p>
                    <p>Due " . $books['due_date'] . "</p>              
                </div>";
        }
    }
    public function cart(){
        $id = $_SESSION['userId']; 
        $sql = "SELECT * FROM cart LEFT OUTER JOIN books ON cart.book_id = books.book_id WHERE users_id = '$id'";
        global $mysqli;
        $result = $mysqli->query($sql);
            while($rows = $result->fetch_assoc()){  
                echo    "<table id='cartContainer'> 
                            <tr class='searchTable'>
                                <td>
                                    <img class='image' src='assets/books/" . $rows['images'] . "'>
                                </td>
                                <td>" . $rows["book_title"]. "</td>
                               
                                <td>
                                <form method='post'>
                                    <button type='submit' name='removeFromCart' value='" . $rows['book_id'] . "'>Remove from cart</button>
                                </form>
                                </td>
                            </tr>
                            
                        </table>";
            }
    }
    public function removeFromCart () {
        $id = $_POST['removeFromCart'];      
        $sql = "DELETE FROM cart WHERE book_id = '$id'";
        global $mysqli;
        $mysqli->query($sql);
    }      
    public function checkout(){
        $id = $_SESSION['userId'];
        $sql = "SELECT COUNT(book_id) AS 'count' FROM cart WHERE users_id = '$id'";
        $sqlCheck = "SELECT COUNT(book_id) AS 'currentlyCheckedOut' FROM checkedOut WHERE users_id = '$id'";
        global $mysqli;       
        $toCheckOut = $mysqli->query($sql);        
        $prevCheckedOut =  $mysqli->query($sqlCheck);
        $resultToCheckout = $toCheckOut->fetch_assoc();
        $resultPrevCheckout = $prevCheckedOut->fetch_assoc();
        $calculation = $resultToCheckout['count'] + $resultPrevCheckout['currentlyCheckedOut'];
        $canCheckOut = 6 - $resultPrevCheckout['currentlyCheckedOut'];

            if($calculation <= 6){
                $cart = "SELECT * FROM cart WHERE users_id = $id";
                global $mysqli;
                $fetch = $mysqli->query($cart);

                while($books = $fetch->fetch_assoc()){ 
                    $book = $books['book_id'];
                    $checkOut = new DateTime();
                    $today = $checkOut->format('y-m-d');
                    $return = new DateTime();
                    $return->modify('+28 day');
                    $dueDate = $return->format('y-m-d');

                    $updateCheckedOut = "INSERT INTO checkedOut (book_id, users_id, check_out_date, due_date) VALUES ('$book', '$id', '$today', '$dueDate')";
                    $updateCart = "DELETE FROM cart WHERE book_id = '$book'";
                    $updateBooks = "UPDATE books SET is_checked_out = 1, user_checked_out = '$id' WHERE book_id = $book";
                    global $mysqli;
                    $mysqli->query($updateCheckedOut);
                    $mysqli->query($updateCart);
                    $mysqli->query($updateBooks);
                }    
            } else {
                echo "A maximum of 6 books are allowed to be checked out. You may check out up to " . $canCheckOut . " books on this occation</p>";
                // back to cart button
                die;
            } 
            echo "<script>window.location = 'confirmCheckOut.php'</script>";
    }
    public function confirmedCheckOut() {
        $id = $_SESSION['userId'];
        $sql= "SELECT * FROM checkedOut LEFT OUTER JOIN books ON checkedOut.book_id = books.book_id WHERE users_id = '$id'";
        global $mysqli;
        $check = $mysqli->query($sql);
        echo "<div>";
        while ($fetch = $check->fetch_assoc()){
            echo "<p>" . $fetch['book_title'] . "</p>";
        };
        echo "</div>";
    }
    public function bookCheckin() {
        $bookId = $_POST['checkIn'];    
        $fine = "SELECT * FROM checkedOut WHERE book_id = '$bookId'";
        echo "test";
        global $mysqli;
        $send = $mysqli->query($fine);
        $fetch = $send->fetch_assoc();
        $id = $fetch['users_id'];
        $fineOnBook = $fetch['fine'];
        $sqlFine = "SELECT fineTotal FROM users WHERE id =  '$id'";
        echo "test";
        $queryFine = $mysqli->query($sqlFine);
        $getFine = $queryFine->fetch_assoc();     
        $existingFines = $getFine['fine'];     
        $updatedFine = $existingFines +  $fineOnBook;

        $updateUserFine = "UPDATE users SET fine = '$updatedFine' WHERE id = '$id'";
        $checkIn = "UPDATE books SET is_checked_out = 0, user_checked_out = 0 WHERE book_id = '$bookId'";
        $removeFromUser = "DELETE FROM checkedOut WHERE book_id = '$bookId'";
        $mysqli->query($updateUserFine);

            if ($mysqli->query($checkIn) && $mysqli->query($removeFromUser)){
                $sql = "SELECT * FROM books WHERE book_id = '$bookId'";
                global $mysqli;
                $confirm = $mysqli->query($sql);
                $confirmBook = $confirm->fetch_assoc();
                echo "<div>
                        <p>" . $confirmBook['book_title'] . " has been checked back in</p>
                    </div>";
            } else {
                echo "<div>
                        <p>There was an error checking the book back in</p>
                    </div>";
            }
    }
    public function fine() {
        $sql = "SELECT * FROM checkedOut";
        $checkDate = new DateTime ();      
        $today = 20 . $checkDate->format('y-m-d');     
        global $mysqli;
        $fine = $mysqli->query($sql);
        while ($check = $fine->fetch_assoc()){
            $id = $check['users_id'];
            $dueDate = $check['due_date'];
            $book = $check['book_id'];
            $numOne = explode("-", $dueDate);
            $numOne = implode('', $numOne);
            $numOne = intval($numOne);      
            $numTwo = explode("-", $today);
            $numTwo = implode ('', $numTwo);
            $numTwo = intval($numTwo);         
            $fineDue = $numOne - $numTwo;          
            if ($fineDue < 0){
                $sqlFine = "UPDATE checkedOut SET fine = 10 WHERE book_id = '$book'";
                global $mysqli;
                $mysqli->query($sqlFine);
            }          
        }
    }
    public function payFine() {
        $id = $_POST['payFine'];
        $newCheckin = new DateTime();
        $newCheckin->modify('+28 day');
        $dueDate = $newCheckin->format('y-m-d');
        $sql = "UPDATE users SET fineTotal = 0  WHERE id = '$id'";
        global $mysqli;
        if($mysqli->query($sql)){
            echo "<div>
                    <p>The fine has been paid</p>          
                  </div>";
        };
    }

// The following functions sort the information

    public function sortAscending(){
        $result = $_SESSION['search'];
        $sortBy = $_SESSION['sortBy'];               
        echo "<h3>Your search result is - </h3>";
        $sqls = "SELECT * FROM books LEFT OUTER JOIN authors ON books.author_id = authors.author_id 
        WHERE book_title LIKE '$result' ORDER BY `{$sortBy}` ASC";
        global $mysqli;
        $searchResult = $mysqli->query($sqls); 
                echo "<form method='post'>                      
                        <h5>Title</h5>
                        <button id='sortByTitle' type='submit' name='sortByTitleAsc' value='sortByTitle'>Asc</button>
                        <button id='sortByTitle' type='submit' name='sortByTitleDesc' value='sortByTitle'>Desc</button>
                        <h5>Author</h5>
                        <button id='sortByAuthor' type='submit' name='sortByAuthorAsc' value='sortByAuthor'>Asc</button>
                        <button id='sortByAuthor' type='submit' name='sortByAuthorDesc' value='sortByAuthor'>Desc</button>
                        <h5>Year</h5>
                        <button id='sortBuYear' type='submit' name='sortByYearAsc' value='sortByYear'>Asc</button>
                        <button id='sortBuYear' type='submit' name='sortByYearDesc' value='sortByYear'>Desc</button>  
                        <h5>Genre</h5>                     
                        <button id='sortByGenre' type='submit' name='sortByGenreAsc' value='sortByGenre'>Asc</button>   
                        <button id='sortByGenre' type='submit' name='sortByGenreDesc' value='sortByGenre'>Desc</button> 
                        <h5>Age Group</h5>
                        <button id='sortByAge' type='submit' name='sortByAgeAsc' value='sortByAge'>Asc</button>
                        <button id='sortByAge' type='submit' name='sortByAgeDesc' value='sortByAge'>Desc</button>
                        <h5>Checked Out</h5>
                        <button id='isCheckedOut' type='submit' name='sortByCheckedOutAsc' value='isCheckedOut'>Asc</button>
                        <button id='isCheckedOut' type='submit' name='sortByCheckedOutDesc' value='isCheckedOut'>Desc</button>
                    </form>";          
                    while($rows = $searchResult->fetch_assoc()){                          
                        echo "<table class='searchContainer'> 
                                <tr class='searchTable'>
                                    <td><img class='bookImage' src='assets/books/" . $rows['images'] . "'></td>
                                    <td class='bookSearchTitle'><h2>" . $rows["book_title"]. "</h2><h4> by " . $rows["author_name"] . " (" .  $rows["year_released"] . ")</h4></td>
                                    <td class='bookSearchAbout'>" . $rows["about_book"] . "</td>
                                    <td class='bookSearchGenre'>Genre - " . $rows["book_genre"]. "</td>
                                    <td class='bookSearchAge'>Age Group -" . $rows["age_group"]. "</td>
                                    <td class='bookSearchCheckedin'>Available - ";
                                        if($rows["is_checked_out"] === "1"){                            
                                            echo 'yes';
                                        } else {
                                            echo 'no';
                                        };                                                     
                                    echo "</td>  
                                    <td>";
        
                                    if ($_SESSION['isStaff'] === TRUE){
                                        echo    
                                        "<form method='post'>
                                            <button id=" . $rows["book_id"] . " type='submit' name='edit' value=" . $rows["book_id"] . ">Edit</button>";
                                            if ($rows["is_checked_out"] != 1) {
                                                echo "<button type='submit' name='checkIn' value=" . $rows["book_id"] . " disabled>Checkin Book</button>";
                                            }else {
                                                echo "<button type='submit' name='checkIn' value=" . $rows["book_id"] . " >Checkin Book</button>";
                                            }
                                            
                                            echo "<button>Cancel</button>
                                        </form>"; 
                                    } else if ($rows["is_checked_out"] === "1" && $_SESSION['isStaff'] != TRUE) {
                                        echo     
                                        "<form method='post' action='mainPage.php#" . $rows["book_id"] . "'>                               
                                            <button id=" . $rows["book_id"] . " type='submit' name='addToCart' value=" . $rows["book_id"] . " disabled>Currently Unavailable</button> 
                                            <button>Cancel</button>
                                        </form>";                                  
                                    } else {
                                        echo     
                                        "<form method='post' action='mainPage.php#" . $rows["book_id"] . "'>                               
                                            <button id=" . $rows["book_id"] . " type='submit' name='addToCart' value=" . $rows["book_id"] . ">Add to Cart</button> 
                                            <button>Cancel</button>
                                        </form>";   
        
                                    }
                                    echo "</td>
                                <tr>     
                            </table>";
                }
    }
    public function sortDescending(){
        $result = $_SESSION['search'];
        $sortBy = $_SESSION['sortBy'];               
        echo "<h3>Your search result is - </h3>";
        $sqls = "SELECT * FROM books LEFT OUTER JOIN authors ON books.author_id = authors.author_id 
        WHERE book_title LIKE '$result' ORDER BY `{$sortBy}` DESC";
        global $mysqli;
        $searchResult = $mysqli->query($sqls); 
                echo "<form method='post'>                      
                        <h5>Title</h5>
                        <button id='sortByTitle' type='submit' name='sortByTitleAsc' value='sortByTitle'>Asc</button>
                        <button id='sortByTitle' type='submit' name='sortByTitleDesc' value='sortByTitle'>Desc</button>
                        <h5>Author</h5>
                        <button id='sortByAuthor' type='submit' name='sortByAuthorAsc' value='sortByAuthor'>Asc</button>
                        <button id='sortByAuthor' type='submit' name='sortByAuthorDesc' value='sortByAuthor'>Desc</button>
                        <h5>Year</h5>
                        <button id='sortBuYear' type='submit' name='sortByYearAsc' value='sortByYear'>Asc</button>
                        <button id='sortBuYear' type='submit' name='sortByYearDesc' value='sortByYear'>Desc</button>  
                        <h5>Genre</h5>                     
                        <button id='sortByGenre' type='submit' name='sortByGenreAsc' value='sortByGenre'>Asc</button>   
                        <button id='sortByGenre' type='submit' name='sortByGenreDesc' value='sortByGenre'>Desc</button> 
                        <h5>Age Group</h5>
                        <button id='sortByAge' type='submit' name='sortByAgeAsc' value='sortByAge'>Asc</button>
                        <button id='sortByAge' type='submit' name='sortByAgeDesc' value='sortByAge'>Desc</button>
                        <h5>Checked Out</h5>
                        <button id='isCheckedOut' type='submit' name='sortByCheckedOutAsc' value='isCheckedOut'>Asc</button>
                        <button id='isCheckedOut' type='submit' name='sortByCheckedOutDesc' value='isCheckedOut'>Desc</button>
                    </form>";           
                    while($rows = $searchResult->fetch_assoc()){                          
                        echo "<table class='searchContainer'> 
                                <tr class='searchTable'>
                                    <td><img class='bookImage' src='assets/books/" . $rows['images'] . "'></td>
                                    <td class='bookSearchTitle'><h2>" . $rows["book_title"]. "</h2><h4> by " . $rows["author_name"] . " (" .  $rows["year_released"] . ")</h4></td>
                                    <td class='bookSearchAbout'>" . $rows["about_book"] . "</td>
                                    <td class='bookSearchGenre'>Genre - " . $rows["book_genre"]. "</td>
                                    <td class='bookSearchAge'>Age Group -" . $rows["age_group"]. "</td>
                                    <td class='bookSearchCheckedin'>Available - ";
                                        if($rows["is_checked_out"] === "1"){                            
                                            echo 'yes';
                                        } else {
                                            echo 'no';
                                        };                                                     
                                    echo "</td>  
                                    <td>";
        
                                    if ($_SESSION['isStaff'] === TRUE){
                                        echo    
                                        "<form method='post'>
                                            <button id=" . $rows["book_id"] . " type='submit' name='edit' value=" . $rows["book_id"] . ">Edit</button>";
                                            if ($rows["is_checked_out"] != 1) {
                                                echo "<button type='submit' name='checkIn' value=" . $rows["book_id"] . " disabled>Checkin Book</button>";
                                            }else {
                                                echo "<button type='submit' name='checkIn' value=" . $rows["book_id"] . " >Checkin Book</button>";
                                            }
                                            
                                            echo "<button>Cancel</button>
                                        </form>"; 
                                    } else if ($rows["is_checked_out"] === "1" && $_SESSION['isStaff'] != TRUE) {
                                        echo     
                                        "<form method='post' action='mainPage.php#" . $rows["book_id"] . "'>                               
                                            <button id=" . $rows["book_id"] . " type='submit' name='addToCart' value=" . $rows["book_id"] . " disabled>Currently Unavailable</button> 
                                            <button>Cancel</button>
                                        </form>";                                  
                                    } else {
                                        echo     
                                        "<form method='post' action='mainPage.php#" . $rows["book_id"] . "'>                               
                                            <button id=" . $rows["book_id"] . " type='submit' name='addToCart' value=" . $rows["book_id"] . ">Add to Cart</button> 
                                            <button>Cancel</button>
                                        </form>";   
        
                                    }
                                    echo "</td>
                                <tr>     
                            </table>";
                }
    }

// The following functions allow edits to the datebase tables

    public function editBook(){
        $editId = strtolower($_POST['edit']);
        $sqls = "SELECT * FROM books WHERE book_id = '$editId'"; 
        global $mysqli;                               
        $bookToEdit = $mysqli->query($sqls);                                           
        $rows = $bookToEdit->fetch_assoc();

        echo "<div id='editFormContainer'>
                <form method='post' id=editForm enctype='multipart/form-data'>
                    <h2>Edit A Book Entry</h2>
                    <h4>You about to edit book ID " . $rows["book_id"] . " - " . $rows['book_title'] . " by " . "placeholderAuthor" . ".</h4>
                    <label for='editBookTitle'>Edit Book Title</label>
                    <input id='editBookTitle' name='editBookTitle' type='text' value='" . $rows['book_title'] . "'>

                    <label for='editGenre'>Edit Year Released</label>
                    <input id='editYearReleased' name='editYearReleased' type='text' value='" . $rows['year_released'] . "'>

                    <label for='editGenre'>Edit Genre</label>
                    <select id='editGenre' name='editGenre' type='text'>
                        <option>" . $rows['book_genre'] . "</option>
                        <option value='action_and_adventure'>Action and Adventure</option>
                        <option value='art_and_photography'>Art and Photography</option>
                        <option value='biography'>Biography</option>
                        <option value='childrens'>Children's</option>
                        <option value='dystopian'>Dystopian</option>
                        <option value='fantasy'>Fantasy</option>
                        <option value='food_and_drink'>Food and Drink</option>
                        <option value='graphic_novel'>Graphic Novel</option>
                        <option value='historical_fiction'>Historical Fiction</option>
                        <option value='history'>History</option>
                        <option value='horror'>Horror</option>
                        <option value='humanities_and_social_sciences'>Humanities & Social Sciences</option>
                        <option value='humor'>Humor</option>
                        <option value='memoir_and_autobiography'>Memoir and Autobiography</option>
                        <option value='mystery'>Mystery</option>
                        <option value='new_adult'>New Adult</option>
                        <option value='parenting_and_families'>Parenting & Families</option>
                        <option value='religion_and_spirituality'>Religion & Spirituality</option>
                        <option value='romance'>Romance</option>
                        <option value='science_and_technology'>Science & Technology</option>
                        <option value='science_fiction'>Science Fiction</option>
                        <option value='self_help'>Self Help</option>
                        <option value='short_story'>Short Story</option>
                        <option value='thriller_and_suspence'>Thriller and Suspence</option>
                        <option value='travel'>Travel</option>
                        <option value='true_crime'>True Crime</option>
                        <option value='young_adult'>Young Adult</option>
                    </select> 

                    <label for='editAgeGroup'>Edit Age Group</label>
                    <select id='editAgeGroup' name='editAgeGroup' type='text'> 
                        <option>" . $rows['age_group'] . "</option>
                        <option value='0-1'>0 - 1</option>
                        <option value='0-2'>1 - 2</option>
                        <option value='3-5'>3 - 4</option>
                        <option value='5'>5</option>
                        <option value='6-7'>6 - 7</option>
                        <option value='8-10'>8 - 10</option>
                        <option value='11-13'>11 - 13</option>
                        <option value='14-18'>14 - 18</option>
                        <option value='18+'>18 +</option>
                    </select>
                    
                    <label for='imageEdit'>Change Image</label>
                    <input type='file' name='imageEdit'>

                    <button type='submit' name='editSubmit' value=" . $editId . ">Edit task</button>     
                    <button onclick='cancelEdit()'>Cancel</button>
                </form>
                <form method='post'>
                    <button type='submit' name='deleteBook' value=" . $editId . ">Delete from database</button>
                </form>
                
            </div>";
    }
    public function submitEdit(){
        $bookId = $_POST['editSubmit'];
        $bookTitleEdit = strtolower($_POST['editBookTitle']);
        $yearReleasedEdit = $_POST['editYearReleased'];
        $genreEdit = $_POST['editGenre'];
        $ageGroupEdit = $_POST['editAgeGroup'];
    
        $sql = "UPDATE books
                SET book_title = '$bookTitleEdit', year_released = '$yearReleasedEdit', book_genre = '$genreEdit', age_group = '$ageGroupEdit'
                WHERE book_id = '$bookId' ";   
                global $mysqli; 
        if ($mysqli->query($sql) === TRUE) {
            echo "Record '" . $bookTitleEdit . "' updated successfully";
        } else {
            echo "Error deleting record: " . $mysqli->error;
        }  

        if ($_FILES['imageEdit']['error'] === 0) {            
            $sqlImage = "SELECT images FROM books WHERE book_id = '$bookId'";          
            global $mysqli;
            $mysqli->query($sqlImage);
            $fetch = $mysqli->query($sqlImage);    
            $getImage = $fetch->fetch_assoc();
            $oldImage = $getImage['images'];             
            $path = "assets/books/" . $oldImage;
                if (file_exists($path)){
                    unlink($path);
                    $sqlImage = "UPDATE books SET images = NULL WHERE book_id = '$bookId'";
                        global $mysqli;
                        $mysqli->query($sqlImage);
                }                                     
                
                $fileName = $_FILES['imageEdit']['name'];
                $fileTmpName = $_FILES['imageEdit']['tmp_name'];
                $fileSize = $_FILES['imageEdit']['size'];
                $fileError = $_FILES['imageEdit']['error'];
                $fileType = $_FILES['imageEdit']['type'];
                $fileExt = explode('.', $fileName);
                $fileActualExt = strtolower(end($fileExt));       
                $allowed = array('jpg', 'jpeg', 'png');

                    if (in_array($fileActualExt, $allowed)) {
                        if ($fileError === 0){
                            if ($fileSize < 5000000){
                                $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                                $fileDestination = 'assets/books/' . $fileNameNew;
                                    move_uploaded_file($fileTmpName, $fileDestination);                              
                                $sql= "UPDATE books SET images = '$fileNameNew' WHERE book_id = '$bookId'";

                                global $mysqli;
                                    if ($mysqli->query($sql) === TRUE) {
                                        echo "New record created successfully";
                                        } else {
                                            echo "Error: " . $bookTitle . "<br>" .  $mysqli->error;
                                        }                
                            } else {
                                echo "Your file is too big, image should be less the 5mb";
                            }
                        } else {
                            echo 'There was an error uploading your file';
                        }
                    } else {
                        echo 'You cannot upload files of this type, file must be either jpeg, jpg or png';
                    };                         
        } else { 
            echo "image not edited";
        };
    }
    public function deleteBookWarning(){
        $id = $_POST['deleteBook'];
        $sql = "SELECT book_title FROM books WHERE book_id = '$id'";
        global $mysqli;
        
        $book = $mysqli->query($sql);
        $bookToDelete = $book->fetch_assoc();

        echo "<h3 id='warning'> WARNING - You about to permanently delete " . $bookToDelete['book_title']. " from the database? </h3>

        <form method='post'>
            <button type='submit' name='confirmDeleteBook' value=" . $id . ">Delete Book</button>
            <button onclick='cancelEdit()'>Cancel</button>
        </form>";
    }
    public function deleteBookFromDatabase(){
        $id = $_POST['confirmDeleteBook'];
        $book = "SELECT * FROM books WHERE book_id = '$id'";        
        global $mysqli;    
        $bookToDelete = $mysqli->query($book);
        $deleteBook = $bookToDelete->fetch_assoc();
        $sql = "DELETE FROM books WHERE book_id = '$id'";
            if($mysqli->query($sql) === TRUE){
                echo $deleteBook['book_title'] . " has been succesfully deleted from the database";
            }
    }
    public function deleteAuthorWarning() {
        $id = $_POST['deleteAuthor'];
        $sql = "SELECT author_name FROM authors WHERE author_id = '$id'";
        global $mysqli;
        $author = $mysqli->query($sql);
        $authorToDelete = $author->fetch_assoc();

        echo "<h3 id='warning'> WARNING - You about to permanently delete " . $authorToDelete['author_name']. " from the database, and all associated books! </h3>

        <form method='post'>
            <button type='submit' name='confirmDeleteAuthor' value=" . $id . ">Delete Author</button>
            <button onclick='cancelEdit()'>Cancel</button>
        </form>";
    }
    public function deleteAuthorFromDatabase() {
        $id = $_POST['confirmDeleteAuthor'];

        $author = "SELECT * FROM authors WHERE author_id = '$id'";
        global $mysqli;
        echo $id;
        $authorToDelete = $mysqli->query($author);
        $deleteAuthor = $authorToDelete->fetch_assoc();
        $author = $deleteAuthor['author_name'];
        $sql = "DELETE FROM books WHERE author_id = '$id'";
        $mysqli->query($sql);
        $sqled = "DELETE FROM authors WHERE author_id = '$id'";
            if ($mysqli->query($sqled) === TRUE) {
                echo $author . " has been succesfully deleted from the database";
            }

    }
}

$newEntry = new LibraryDatabase;

    //$newEntry->setNumInCart();

?>