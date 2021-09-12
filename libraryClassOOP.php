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

class LibraryDatabase{
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
        
        $authorName = '%'. $_POST['searchAuthor'] .'%'; 
        $sql = "SELECT * FROM authors  WHERE author_name LIKE '$authorName'";
            global $mysqli;    
        $doesAuthorExist = $mysqli->query($sql); 
        $exist = $doesAuthorExist->fetch_assoc(); 

        if ($exist['author_name']) {
        echo "
            <section class='show' id='searchAuthorContainer'>
                 <h2 class='authorSearchTitle'>Here are your search results : </h2>";
                 $displayAuthor = $mysqli->query($sql); 
                while($author = $displayAuthor->fetch_assoc()){;                              
                    echo "
                        <table class='searchAuthorTableContainer'>
                            <tr class='authorSearchTable'>                                          
                                <td class='authorImageConatainer'><img class='authorImage' src='assets/authors/" . $author['author_image'] . "'></td>                                             
                                <td class='authorName'><span>Author - </span>" . $author["author_name"] . "</td>
                                <td class='authorAge'><span>Age - </span>" . $author["age"] . "</td>
                                <td class='authorGenre'><span>Main Genre - </span>" . $author["genre"] . "</td>  
                                <td class='authorBio'><span>About - </span>" . $author["author_bio"] .  "</td>                                                                                                              
                                <td class='authorButtons'>
                                    <form method='post'>
                                        <button class='loginButtons' id=" . $author["author_id"] . " type='submit' name='viewBooks' value=" . $author["author_id"] . ">View books</button>";

                                            if ($curPageName === 'editLibrary.php') {
                                                echo "
                                                    <button class='loginButtons' type='submit' name='editAuthor' value=" . $author["author_id"] . ">Edit Author</button>
                                                    <button class='delete loginButtons' id=" . $author["author_id"] . "type='submit' name='deleteAuthor' value=" . $author["author_id"] . ">Delete Author</button>";
                                            } 

                                    echo "
                                        <button class='loginButtons' onClick='window.location.href=window.location.href'>Cancel</button>
                                    </form>    
                                </td>
                                <td class='authorHrBreak'><hr></hd>
                            <tr>     
                        </table>";
                    } 
                echo "
            </section>";   
        }                        
        $authorDoesNot = $mysqli->query($sql);
        $autDoesNot = $authorDoesNot->fetch_assoc();
            if ($autDoesNot["author_name"] === NULL  &&  $curPageName === 'editLibrary.php') {
                echo "
                    <section class='container show'>
                        <h2>Author is not in the database. create a new author entry</h2>
                        <div id='formContainerAuthor'>
                            <form id='authorFormContainer' method='post' enctype='multipart/form-data'>
                                <label class='labelEdit' for='authorsName'>Authors Name</label>
                                <input class='inputEdit' id='authorsName' name='authorsName' type='text' pattern='[a-z A-Z]+' required>

                                <label class='labelEdit' for='authorsAge'>Authors Age</label>
                                <input class='inputEdit' id='authorsAge' name='authorsAge' type='text' pattern='[0-9 a-z A-Z]+' required>

                                <label class='labelEdit' for='mainGenre'>Main Genre</label>
                                <select class='inputEdit' id='mainGenre' name='mainGenre' required>
                                    <option hidden disabled selected value> -- select an option -- </option>
                                    <option>Fiction</option>
                                    <option>Non-fiction</option>
                                </select>

                                <label class='labelEdit' for='authorBio'>Add a bio of the author</label>
                                <input class='inputEdit' name='authorBio' type='textarea' >

                                <label class='labelEdit' for='authorImage'>Upload Authors Image</label>
                                <input class='newAuthor' type='file' name='authorImage'>                   

                                <input class='loginButtons newAuthor' type='submit' name='submitAuthor' value='submit'> 
                                <button class='loginButtons' onClick='window.location.href=window.location.href'>Cancel</button>
                            </form>
                        </div>
                    </section>";

                } else if ($autDoesNot["author_name"] === NULL  &&  $curPageName === 'mainPage.php'){
                    echo "
                        <div id='authorDoesNotExist' class='show'>
                            <h3>Unfortunately the author you are looking for is not in our library</h3>
                            <form>
                                <button class='loginButtons' type='submit'>Back to search</button>
                            </form>
                        </div>";
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
                            echo "
                                <div class='container show'>
                                        <h3></p>New record created successfully</h3>
                                </div>";
                        } else {
                            echo "
                                <div class='container show'>
                                    <h3>Error <br>" .  $mysqli->error . "</h3>
                                </div>";
                            }   
                    } else {
                        echo "
                            <div class='container show'>
                                <h3>Your file is too big, image must be less then 5mb</h3>
                            </div>";
                    }
                } else {
                    echo "
                        <div class='container show'>
                            <h3>There was an error uploading your file</h3>
                        </div>";
                }
            } else {
                echo "
                    <div class='container show'>
                        <h3>You cannot upload files of this type, file must be either jpeg, jpg or png</h3>
                    </div>";
            };  
        } else {
            $sql = "INSERT INTO authors (author_name, age, genre, author_bio) VALUE ('$authorsName', '$authorsAge', '$mainGenre', '$authorBio')";
            global $mysqli;                               
            if ($mysqli->query($sql) === TRUE) {
                echo "
                    <div class='container show'>
                        <h3>New author added to database</h3>
                    </div>";
                } else {
                    echo "
                        <div class='container show'> 
                            <h3>Error: " . $authorName . "<br>" .  $mysqli->error . "</h3>
                        </div>";
                    }    
        }       
    }
    public function editAuthor(){
        $id = $_POST['editAuthor'];        
        $sql = "SELECT * FROM authors WHERE author_id = '$id'"; 
        global $mysqli;                               
        $author = $mysqli->query($sql);                                           
        $rows = $author->fetch_assoc();

        echo "
            <div class='container show' id='formContainerAuthor'>
                <h2>You are about to edit " . $rows['author_name'] . ":</h2>
                <form id='authorFormContainer' method='post' enctype='multipart/form-data'>
                    <label class='labelEdit' for='authorsName'>Authors Name</label>
                    <input class='inputEdit' id='authorsName' name='authorsNameEdit' type='text' pattern='[a-z A-Z]+' value='" . $rows['author_name'] . "' required>

                    <label class='labelEdit' for='authorsAge'>Authors Age</label>
                    <input class='inputEdit' id='authorsAge' name='authorsAgeEdit' type='text' min='0' max='150' pattern='[0-9 a-z A-Z]+' value='" . $rows['age'] . "' required>

                    <label class='labelEdit' for='mainGenre'>Main Genre</label>
                    <select class='inputEdit' id='mainGenre' name='mainGenreEdit' required>
                        <option>" . $rows['genre'] . "</option>
                        <option>Fiction</option>
                        <option>Non-fiction</option>
                    </select>

                    <label class='labelEdit' for='editAuthorBio' >Edit the Author Bio</label>
                    <input class='inputEdit' type='textarea' name='editAuthorBio' value='" . $rows['author_bio'] . "'>

                    <label class='labelEdit' for='authorImageEdit'>Change Image</label>
                    <input class='inputUpload'  type='file' name='authorImageEdit'>

                    <button class='loginButtons' type='submit' name='submitAuthorEdit' value='" . $id . "'>Submit Edit</button>
                    <button class='loginButtons' onClick='window.location.href=window.location.href'>Cancel</button>
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
                echo "
                    <div class='container show'>
                        <h2>Record for " . $authorName . " updated successfully";
            } else {
                echo "<
                    div class='container show'>
                        <h2>Error editing record: " . $mysqli->error . "</h2>
                    </div>";
        }
        if ($_FILES['authorImageEdit']['error'] === 0) {        
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
                                        echo "
                                            <div class='container'>
                                                <h2>New record created successfully</h2>
                                            </div>";
                                        } else {
                                            echo "
                                                <div class='container'>
                                                    <h2>Error: " .  $mysqli->error . "</h2>
                                                </div>";
                                        }                
                            } else {
                                echo "
                                    <div class='container'>
                                        <h2>Your file is too big, image should be less the 5mb</h2>
                                    </div>";
                            }
                        } else {
                            echo "
                                <div class='container'>
                                    <h2>There was an error uploading your file</h2>
                                </div>";
                        }
                    } else {
                        echo "
                            <div class='container'>
                                    <h2>You cannot upload files of this type, file must be either jpeg, jpg or png</h2>
                            </div>";
                    };                         
        } else { 
            echo "<h2>image not edited</h2>
            </div>";
        };
    }

// This function allows you to view all the authors books after searching for the author.

    public function viewAuthorsBooks(){
        $curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1); 
        $id = $_POST['viewBooks'];
        $sql = "SELECT * FROM books WHERE author_id = '$id' ORDER BY book_title ASC";
        $sqlAuthor = "SELECT * FROM authors WHERE author_id = '$id'";
        global $mysqli;
        $viewBooks = $mysqli->query($sql); 
        $author = $mysqli->query($sqlAuthor);
        $authors = $author->fetch_assoc();
        echo "
            <div id='authorBooks' class='container show'>
                <h2 class='authorsBookContainerTitle'>We currently have the following books by " . $authors['author_name'] . " in the library</h2>
                <table class='authorsBookContainer'> 
                        <tr class='titles'>
                            <th class='authorBookTitles'><h4>Book</h4></th>
                            <th class='authorBookInfo authorBookTitles'><h4>Year released</h4></th>
                            <th class='authorBookInfo authorBookTitles'><h4>Genre</h4></th>
                            <th class='authorBookInfo authorBookTitles'><h4>Age group</h4></th>
                        </tr>";
                        while($author = $viewBooks->fetch_assoc()){               
                            echo "
                                <tr class='authorBookInfoRow'>
                                    <td>" . $author["book_title"] . "</td>
                                    <td class='authorBookInfo'>" . $author["year_released"] . "</td>
                                    <td class='authorBookInfo'>" . $author["book_genre"] . "</td> 
                                    <td class='authorBookInfo'>" . $author["age_group"] . "</td>                          
                                </tr>
                                <tr>
                                    <td><hr></td>
                                </tr>";                                                                    
                        }; 
            echo "
                </table>
                <form class='addButtonForm' method='post'>";

                if($curPageName === 'editLibrary.php'){
                    echo "
                        <button class='loginButtons' id=" . $id . " type='submit' name='addBookToDatabase' value=" . $id . ">add book</button>";
                }
            echo "
                        <button class='loginButtons'>Back</button>
                </form>
            </div>";
    }
    public function addBookForm() {
        $id = $_POST['addBookToDatabase'];
        $sql = "SELECT * FROM authors WHERE author_id = '$id'";
        global $mysqli;
        $author = $mysqli->query($sql);
        $author = $author->fetch_assoc();
            echo "
                <div class='container show'' id='formContainerBook'>      
                    <form id='addBookFormContainer' method='post'  enctype='multipart/form-data'>
                        <h2>Create a new book entry for <span>" . $author['author_name'] .  "</span>:</h2>
                        <label class='labelEdit' for='bookTitle'>Book Title</label>
                        <input class='inputEdit' id='bookTitle' name='bookTitle' type='text' required>
                    
                        <label class='labelEdit'  for='yearReleased'>Year released</label>
                        <input class='inputEdit'  id='yearReleased' name='yearReleased' type='text' pattern='[0-9]+' required>

                        <label class='labelEdit'  for='genre'>Genre</label>
                        <select class='inputEdit' id='genre' name='genre' required>
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

                        <label class='labelEdit'  for='ageGroup'>Age Group</label>
                        <select class='inputEdit' id='ageGroup' name='ageGroup' required>
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

                        <label class='labelEdit'  for='file'>Upload Book Image</label>
                        <input class='inputUpload' type='file' name='file'>

                        <button class='loginButtons' type='submit' name='submitBook' value=" . $id . ">Submit</button>  
                        <button class='loginButtons' onClick='window.location.href=window.location.href'>Cancel</button>   
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
                                echo "
                                    <div class='container show'>
                                        <h2>New record created successfully</h2>
                                    </div>";
                                } else {
                                    echo "
                                        <div class='container show'>
                                            <h2>Error: " . $bookTitle . "<br>" .  $mysqli->error . "</h2>
                                        </div>";
                                }                
                    } else {
                        echo "
                            <div class='container show'>
                                <h2>Your file is too big, image must be less then 5mb</h2>
                            </div>";
                    }
                } else {
                    echo "
                        <div class='container show'>
                            <h2>There was an error uploading your file</h2>
                        </div>";
                }
            } else {
                echo "
                    <div class='container show'>
                        <h2>You cannot upload files of this type, file must be either jpeg, jpg or png</h2>
                    </div>";
            };  
        } else {
            $sql = "INSERT INTO books (book_title, year_released, book_genre, age_group, author_id)
                    VALUES ('$bookTitle', '$yearReleased', '$genre', '$ageGroup', '$id')";
            global $mysqli;
                if ($mysqli->query($sql) === TRUE) {
                    echo "
                        <div class='container'>
                            <h2>New record created successfully<h2>
                        </div>";
                    } else {
                        echo "  
                            <div class='container'>
                                <h2>Error: " . $bookTitle . "<br>" .  $mysqli->error . "</h2>
                            </div>";
                    } 
        } 
    }  
    public function searchBook(){    
        $curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);     
        $result = $_SESSION['search'];  
        $sqls = "SELECT * FROM books LEFT OUTER JOIN authors ON books.author_id = authors.author_id 
                 WHERE book_title LIKE '$result'";
        global $mysqli;
        $searchResult = $mysqli->query($sqls); 
        $exists = $mysqli->query($sqls);

            if (!$exists->fetch_assoc()){
                echo "
                    <div id='bookSearchResult' class='fullHeight show'>
                        <p>Sorry, the book is not part of our library</p>
                        <form method='post'>
                            <button class='loginButtons bookButtons'>Back</button>
                        </form>
                    </div>";
            }else {
                echo "
                    <div id='bookSearchResult' class='show'>
                        <div class='orgnaiseSearchContainer'>  
                            <h2 class='searchResultTitle'>Here are your search results : </h2>  
                            <h4>Sort By - </h4>           
                            <form class='organiseSearch' method='post'>                       
                                
                                <div id='sortByTitle' class='sortContainer'>  
                                    <h5 class='sortHeading sortTitle'>Title</h5>                         
                                    <button type='submit' name='sortByTitleAsc' value='sortByTitle'><img class='sortImage' src='assets/header-logos/sortUp.png'></button>
                                    <button type='submit' name='sortByTitleDesc' value='sortByTitle'><img class='sortImage' src='assets/header-logos/sortDown.png'></button>
                                </div>                           
                                <div id='sortByAuthor' class='sortContainer'>
                                    <h5 class='sortHeading sortAuthor'>Author</h5>
                                    <button  type='submit' name='sortByAuthorAsc' value='sortByAuthor'><img class='sortImage' src='assets/header-logos/sortUp.png'></button>
                                    <button type='submit' name='sortByAuthorDesc' value='sortByAuthor'><img class='sortImage' src='assets/header-logos/sortDown.png'></button>
                                </div>                            
                                <div id='sortByYear' class='sortContainer'>
                                    <h5 class='sortHeading sortYear'>Year</h5>
                                    <button  type='submit' name='sortByYearAsc' value='sortByYear'><img class='sortImage' src='assets/header-logos/sortUp.png'></button>
                                    <button  type='submit' name='sortByYearDesc' value='sortByYear'><img class='sortImage' src='assets/header-logos/sortDown.png'></button>  
                                </div>
                                
                                <div id='sortByGenre' class='sortContainer'>  
                                    <h5 class='sortHeading sortGenre'>Genre</h5>                
                                    <button type='submit' name='sortByGenreAsc' value='sortByGenre'><img class='sortImage' src='assets/header-logos/sortUp.png'></button>   
                                    <button type='submit' name='sortByGenreDesc' value='sortByGenre'><img class='sortImage' src='assets/header-logos/sortDown.png'></button> 
                                </div>
                                <div id='sortByAge' class='sortContainer'> 
                                    <h5 class='sortHeading sortAge'>Age Group</h5>
                                    <button type='submit' name='sortByAgeAsc' value='sortByAge'><img class='sortImage' src='assets/header-logos/sortUp.png'></button>
                                    <button  type='submit' name='sortByAgeDesc' value='sortByAgeDesc'><img class='sortImage' src='assets/header-logos/sortDown.png'></button>
                                </div>
                                
                                <div id='isCheckedOut' class='sortContainer'> 
                                    <h5 class='sortHeading sortChecked'>Checked Out</h5>
                                    <button type='submit' name='sortByCheckedOutAsc' value='isCheckedOut'><img class='sortImage' src='assets/header-logos/sortUp.png'></button>
                                    <button type='submit' name='sortByCheckedOutDesc' value='isCheckedOut'><img class='sortImage' src='assets/header-logos/sortDown.png'></button>
                                </div>
                            </form>
                        </div>
                    <div id='searchLibraryContainer'>";   

                    while($rows = $searchResult->fetch_assoc()){                          
                        echo "
                            <table class='searchContainer'> 
                                <tr class='searchTable'>
                                    <td><img class='bookImage' src='assets/books/" . $rows['images'] . "'></td>
                                    <td class='bookSearchTitle'><h2>" . $rows["book_title"]. "</h2><h4> by " . $rows["author_name"] . " (" .  $rows["year_released"] . ")</h4></td>
                                    <td class='bookSearchAbout'><span><h3 class='bookInfoTitle'>About the Book -</h3></span><br>" . $rows["about_book"] . "</td>
                                    <div class='bookInfoContainer'>
                                        <td class='bookSearchGenre'><span class='bookInfoTitle'>Genre - </span>" . $rows["book_genre"]. "</td>
                                        <td class='bookSearchAge'><span class='bookInfoTitle'>Age Group - </span>" . $rows["age_group"]. "</td>
                                        <td class='bookSearchCheckedin'><span class='bookInfoTitle'>Available -</span> ";
                                            if($rows["is_checked_out"] != 1){                       
                                                echo 'yes';
                                            } else {
                                                echo 'no';
                                            };                                                     
                                        echo "
                                        </td><td class='bookSearchButton'>";
            
                                        if ($_SESSION['isStaff'] === TRUE){
                                            echo "
                                                <form method='post'>";
                                                    if ($curPageName === 'editLibrary.php') {
                                                        echo "<button class='loginButtons bookButtons' id=" . $rows["book_id"] . " type='submit' name='edit' value=" . $rows["book_id"] . ">Edit</button>";
                                                    }
                                                    if ($rows["is_checked_out"] != 0) {
                                                        echo "<button class='loginButtons bookButtons' type='submit' name='checkIn' value=" . $rows["book_id"] . ">Checkin Book</button>";
                                                    }                                 
                                                    echo "<button class='loginButtons bookButtons'>Back</button>
                                                </form>"; 
                                        } else if ($rows["is_checked_out"] === "1" && $_SESSION['isStaff'] != TRUE) {
                                            echo "
                                                <form method='post'" . $rows["book_id"] . "'>                               
                                                    <button class='loginButtons bookButtons' id=" . $rows["book_id"] . " type='submit' name='addToCart' value=" . $rows["book_id"] . " disabled>Currently Unavailable</button> 
                                                    <button class='loginButtons bookButtons' >Back</button>
                                                </form>";                                  
                                        } else {
                                            echo "     
                                                <form method='post'" . $rows["book_id"] . "'>                               
                                                    <button class='loginButtons bookButtons' id=" . $rows["book_id"] . " type='submit' name='addToCart' value=" . $rows["book_id"] . ">Add to Cart</button> 
                                                    <button class='loginButtons bookButtons'>Back</button>
                                                </form>";                                           
                                        }
                                        echo "</td>
                                    </div>
                                <tr>     
                            </table>
                            <hr class='horzontalBreak'>";                          
                    }
                echo '</div>
                </div>'; 
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
                echo "
                    <div>
                        <p>book added to cart</p>";                   
                        $this->setNumInCart();         
                        } else {
                            echo "<p>Book already added to the cart</p>";
                            $this->setNumInCart(); 
                        }    
                        echo $this->numBooksInCart . " items in cart  
                    </div>";      
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
        echo "
            <p> You currently have <span class='alloawnceFigure'>" . $resultPrevCheckout['currentlyCheckedOut'] . "</span> books checked out.</p>
            <p> You may check out up to <span class='alloawnceFigure'>" . $canCheckOut . "</span> books on this occation</p>";
    }
    public function currentCheckOut(){
        $id = $_SESSION['userId']; 
        $sql= "SELECT * FROM checkedOut LEFT OUTER JOIN books ON checkedOut.book_id = books.book_id WHERE users_id = '$id'";
        global $mysqli; 
        $checkedOut = $mysqli->query($sql);  
        $book = $checkedOut->fetch_assoc();       
        if($book['book_id']=== NULL){
            echo "<h2 class='checkedOutTitle' >You currently have nothing checked out - </h2>";
        } else {
            echo "<h2 class='checkedOutTitle'>You currently have the following checked out - </h2>"; 
            
            $check = $mysqli->query($sql);

            echo "
                <div id='accountsBookContainer'>
                    <h3 class='profileBookTitle subtitle'>Title</h3>
                    <h3 class='profileBookDue subtitle''>Due date</h3>";
            while($books = $check->fetch_assoc()){
                echo "
                    <p id='bookTitleOwn' class='profileBookTitle'>" . $books['book_title'] . "</p>  
                    <p id='due' class='profileBookDue'>" . $books['due_date'] . "</p>
                    <form method='post>
                        <button class='loginButtons bookButtons' type='submit' name='checkIn' value=" . $rows["book_id"] . ">Checkin Book</button>
                    </form> ";                      
            }          
        }  
            echo "</div>";
    }
    public function cart(){
        $id = $_SESSION['userId']; 
        $sql = "SELECT * FROM cart LEFT OUTER JOIN books ON cart.book_id = books.book_id WHERE users_id = '$id'";
        global $mysqli;
        $result = $mysqli->query($sql);
        $sqlTwo = "SELECT * FROM cart WHERE users_id = '$id'";  
            $emptyCart = $mysqli->query($sqlTwo);
            $isEmtpy = $emptyCart->fetch_assoc();
        if ($isEmtpy['book_id'] != NULL){
            echo "
                <section id='viewCartContainer show'>
                    <h1>Welcome to your cart</h1>";  
                    while($rows = $result->fetch_assoc()){
                        echo "
                            <table id='cartContainer'> 
                                <tr class='cartTable'>
                                    <td>
                                        <img class='image' src='assets/books/" . $rows['images'] . "'>
                                    </td>
                                    <td>" . $rows["book_title"]. "</td>                               
                                    <td>
                                    <form class='cartTableForm' method='post'>
                                        <button class='loginButtons' type='submit' name='removeFromCart' value='" . $rows['book_id'] . "'>Remove from cart</button>
                                    </form>
                                    </td>
                                </tr>                                                    
                            </table>
                            <hr>   ";
                    }            
                    echo "
                    <form id='checkout' method='POST' >
                        <h3>Proceed to Checkout</h3>
                        <button class='loginButtons' name='checkout' >Checkout</button>
                    </form>
                </section>";
        }  else {
            echo "
            <section id='emptyCartContainer show'>
                <div id='emtpyMessage'>
                    <h1>Your cart is emtpy</h1>
                    <p>Head back to the main age to add books to your cart</p>
                    <button class='loginButtons' onclick='mainPage()'>Main page</button>
                </div>
            </section>";
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
                echo 
                    "<section id='fullCartContainer show'>
                        <div id='fullCartMessage'>
                            <h1>Unfortunately your check out capacity is maxed</h1>
                            <p>A maximum of 6 books are allowed to be checked out. You may check out up to " . $canCheckOut . " books on this occation</p>
                            <button class='loginButtons' onclick='cart()'>Back to Cart</button>
                        </div>
                    </section>";   
                    die;    
            } 
            echo "<script>window.location = 'confirmCheckOut.php'</script>";
    }
    public function confirmedCheckOut() {
        $id = $_SESSION['userId'];
        $sql= "SELECT * FROM checkedOut LEFT OUTER JOIN books ON checkedOut.book_id = books.book_id WHERE users_id = '$id'";
        global $mysqli;
        $check = $mysqli->query($sql);
        echo "
            <div class='container checkedoutBooks show'>
                <h2>We hope you enjoy your read.</h2>
                <h3>You now currently have the following checked out:</h3>";
                while ($fetch = $check->fetch_assoc()){
                    echo "
                        <p>" . $fetch['book_title'] . "</p>";
                };
                    echo "
            </div>";
    }
    public function bookCheckin() {
        $bookId = $_POST['checkIn'];    
        $fine = "SELECT * FROM checkedOut WHERE book_id = '$bookId'";
        global $mysqli;
        $send = $mysqli->query($fine);
        $fetch = $send->fetch_assoc();
        $id = $fetch['users_id'];
        $fineOnBook = $fetch['fine'];
        $sqlFine = "SELECT fineTotal FROM users WHERE id =  '$id'";
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
                echo "
                    <div class='container show'>
                        <h2>" . $confirmBook['book_title'] . " has been checked back in</h2>
                        <button class='loginButtons' onclick='mainPage()'>Main page</button>
                    </div>";
            } else {
                echo "
                    <div class='container show'>
                        <h2>There was an error checking the book back in</h2>
                        <button class='loginButtons' onclick='mainPage()'>Main page</button>
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
            echo "
                <div id='userSearch' class='container show'>
                    <h2>The fine has been paid</h2>   
                    <button class='loginButtons' onclick='mainPage()'>Main page</button>       
                </div>";
        };
    }

// The following functions sort the information

    public function sortAscending(){
        $result = $_SESSION['search'];
        $sortBy = $_SESSION['sortBy'];               
        $sqls = "SELECT * FROM books LEFT OUTER JOIN authors ON books.author_id = authors.author_id 
        WHERE book_title LIKE '$result' ORDER BY `{$sortBy}` ASC";
        global $mysqli;
        $searchResult = $mysqli->query($sqls); 
        echo "
        <div class='show'>
            <div class='orgnaiseSearchContainer'>  
                <h2 class='searchResultTitle'>Here are your search results : </h2>  
                <h4>Sort By - </h4>           
                <form class='organiseSearch' method='post'>                       
                    
                    <div id='sortByTitle' class='sortContainer'>  
                        <h5 class='sortHeading sortTitle'>Title</h5>                         
                        <button type='submit' name='sortByTitleAsc' value='sortByTitle'><img class='sortImage' src='assets/header-logos/sortUp.png'></button>
                        <button type='submit' name='sortByTitleDesc' value='sortByTitle'><img class='sortImage' src='assets/header-logos/sortDown.png'></button>
                    </div>                           
                    <div id='sortByAuthor' class='sortContainer'>
                        <h5 class='sortHeading sortAuthor'>Author</h5>
                        <button  type='submit' name='sortByAuthorAsc' value='sortByAuthor'><img class='sortImage' src='assets/header-logos/sortUp.png'></button>
                        <button type='submit' name='sortByAuthorDesc' value='sortByAuthor'><img class='sortImage' src='assets/header-logos/sortDown.png'></button>
                    </div>                            
                    <div id='sortByYear' class='sortContainer'>
                        <h5 class='sortHeading sortYear'>Year</h5>
                        <button  type='submit' name='sortByYearAsc' value='sortByYear'><img class='sortImage' src='assets/header-logos/sortUp.png'></button>
                        <button  type='submit' name='sortByYearDesc' value='sortByYear'><img class='sortImage' src='assets/header-logos/sortDown.png'></button>  
                    </div>
                    
                    <div id='sortByGenre' class='sortContainer'>  
                        <h5 class='sortHeading sortGenre'>Genre</h5>                
                        <button type='submit' name='sortByGenreAsc' value='sortByGenre'><img class='sortImage' src='assets/header-logos/sortUp.png'></button>   
                        <button type='submit' name='sortByGenreDesc' value='sortByGenre'><img class='sortImage' src='assets/header-logos/sortDown.png'></button> 
                    </div>
                    <div id='sortByAge' class='sortContainer'> 
                        <h5 class='sortHeading sortAge'>Age Group</h5>
                        <button type='submit' name='sortByAgeAsc' value='sortByAge'><img class='sortImage' src='assets/header-logos/sortUp.png'></button>
                        <button  type='submit' name='sortByAgeDesc' value='sortByAgeDesc'><img class='sortImage' src='assets/header-logos/sortDown.png'></button>
                    </div>
                    
                    <div id='isCheckedOut' class='sortContainer'> 
                        <h5 class='sortHeading sortChecked'>Checked Out</h5>
                        <button type='submit' name='sortByCheckedOutAsc' value='isCheckedOut'><img class='sortImage' src='assets/header-logos/sortUp.png'></button>
                        <button type='submit' name='sortByCheckedOutDesc' value='isCheckedOut'><img class='sortImage' src='assets/header-logos/sortDown.png'></button>
                    </div>
                </form>
            </div>
        <div id='searchLibraryContainer'>";                                               
        while($rows = $searchResult->fetch_assoc()){                          
            echo "
                <table class='searchContainer'> 
                    <tr class='searchTable'>
                        <td><img class='bookImage' src='assets/books/" . $rows['images'] . "'></td>
                        <td class='bookSearchTitle'><h2>" . $rows["book_title"]. "</h2><h4> by " . $rows["author_name"] . " (" .  $rows["year_released"] . ")</h4></td>
                        <td class='bookSearchAbout'><span><h3 class='bookInfoTitle'>About the Book -</h3></span><br>" . $rows["about_book"] . "</td>
                        <div class='bookInfoContainer'>
                            <td class='bookSearchGenre'><span class='bookInfoTitle'>Genre - </span>" . $rows["book_genre"]. "</td>
                            <td class='bookSearchAge'><span class='bookInfoTitle'>Age Group - </span>" . $rows["age_group"]. "</td>
                            <td class='bookSearchCheckedin'><span class='bookInfoTitle'>Available -</span> ";
                                if($rows["is_checked_out"] != 1){                       
                                    echo 'yes';
                                } else {
                                    echo 'no';
                                };                                                     
                            echo "</td>  
                            <td class='bookSearchButton'>";
                            if ($_SESSION['isStaff'] === TRUE){
                                echo "
                                    <form method='post'>";
                                        if ($curPageName === 'editLibrary.php') {
                                            echo "<button class='loginButtons bookButtons' id=" . $rows["book_id"] . " type='submit' name='edit' value=" . $rows["book_id"] . ">Edit</button>";
                                        }
                                        if ($rows["is_checked_out"] != 0) {
                                            echo "<button class='loginButtons bookButtons' type='submit' name='checkIn' value=" . $rows["book_id"] . ">Checkin Book</button>";
                                        }                                 
                                        echo "<button class='loginButtons bookButtons'>Cancel</button>
                                    </form>"; 
                            } else if ($rows["is_checked_out"] === "1" && $_SESSION['isStaff'] != TRUE) {
                                echo "
                                    <form method='post' action='mainPage.php#" . $rows["book_id"] . "'>                               
                                        <button class='login searchButton bookButtons' id=" . $rows["book_id"] . " type='submit' name='addToCart' value=" . $rows["book_id"] . " disabled>Currently Unavailable</button> 
                                        <button class='login searchButton bookButtons' >Cancel</button>
                                    </form>";                                  
                            } else {
                                echo "
                                    <form method='post' action='mainPage.php#" . $rows["book_id"] . "'>                               
                                        <button class='login searchButton bookButtons' id=" . $rows["book_id"] . " type='submit' name='addToCart' value=" . $rows["book_id"] . ">Add to Cart</button> 
                                        <button class='login searchButton bookButtons'>Cancel</button>
                                    </form>";                                           
                            }
                            echo "</td>
                        </div>
                    <tr>     
                </table>
                <hr class='horzontalBreak'>";                          
        }
        echo '</div>
        </div>'; 
    }
    public function sortDescending(){
        $result = $_SESSION['search'];
        $sortBy = $_SESSION['sortBy'];               
        $sqls = "SELECT * FROM books LEFT OUTER JOIN authors ON books.author_id = authors.author_id 
        WHERE book_title LIKE '$result' ORDER BY `{$sortBy}` DESC";
        global $mysqli;
        $searchResult = $mysqli->query($sqls); 
        echo "
        <div class='show'>
            <div class='orgnaiseSearchContainer'>  
                <h2 class='searchResultTitle'>Here are your search results : </h2>  
                <h4>Sort By - </h4>           
                <form class='organiseSearch' method='post'>                       
                    
                    <div id='sortByTitle' class='sortContainer'>  
                        <h5 class='sortHeading sortTitle'>Title</h5>                         
                        <button type='submit' name='sortByTitleAsc' value='sortByTitle'><img class='sortImage' src='assets/header-logos/sortUp.png'></button>
                        <button type='submit' name='sortByTitleDesc' value='sortByTitle'><img class='sortImage' src='assets/header-logos/sortDown.png'></button>
                    </div>                           
                    <div id='sortByAuthor' class='sortContainer'>
                        <h5 class='sortHeading sortAuthor'>Author</h5>
                        <button  type='submit' name='sortByAuthorAsc' value='sortByAuthor'><img class='sortImage' src='assets/header-logos/sortUp.png'></button>
                        <button type='submit' name='sortByAuthorDesc' value='sortByAuthor'><img class='sortImage' src='assets/header-logos/sortDown.png'></button>
                    </div>                            
                    <div id='sortByYear' class='sortContainer'>
                        <h5 class='sortHeading sortYear'>Year</h5>
                        <button  type='submit' name='sortByYearAsc' value='sortByYear'><img class='sortImage' src='assets/header-logos/sortUp.png'></button>
                        <button  type='submit' name='sortByYearDesc' value='sortByYear'><img class='sortImage' src='assets/header-logos/sortDown.png'></button>  
                    </div>
                    
                    <div id='sortByGenre' class='sortContainer'>  
                        <h5 class='sortHeading sortGenre'>Genre</h5>                
                        <button type='submit' name='sortByGenreAsc' value='sortByGenre'><img class='sortImage' src='assets/header-logos/sortUp.png'></button>   
                        <button type='submit' name='sortByGenreDesc' value='sortByGenre'><img class='sortImage' src='assets/header-logos/sortDown.png'></button> 
                    </div>
                    <div id='sortByAge' class='sortContainer'> 
                        <h5 class='sortHeading sortAge'>Age Group</h5>
                        <button type='submit' name='sortByAgeAsc' value='sortByAge'><img class='sortImage' src='assets/header-logos/sortUp.png'></button>
                        <button  type='submit' name='sortByAgeDesc' value='sortByAgeDesc'><img class='sortImage' src='assets/header-logos/sortDown.png'></button>
                    </div>
                    
                    <div id='isCheckedOut' class='sortContainer'> 
                        <h5 class='sortHeading sortChecked'>Checked Out</h5>
                        <button type='submit' name='sortByCheckedOutAsc' value='isCheckedOut'><img class='sortImage' src='assets/header-logos/sortUp.png'></button>
                        <button type='submit' name='sortByCheckedOutDesc' value='isCheckedOut'><img class='sortImage' src='assets/header-logos/sortDown.png'></button>
                    </div>
                </form>
            </div>
        <div id='searchLibraryContainer'>";                                               
        while($rows = $searchResult->fetch_assoc()){                          
            echo "
                <table class='searchContainer'> 
                    <tr class='searchTable'>
                        <td><img class='bookImage' src='assets/books/" . $rows['images'] . "'></td>
                        <td class='bookSearchTitle'><h2>" . $rows["book_title"]. "</h2><h4> by " . $rows["author_name"] . " (" .  $rows["year_released"] . ")</h4></td>
                        <td class='bookSearchAbout'><span><h3 class='bookInfoTitle'>About the Book -</h3></span><br>" . $rows["about_book"] . "</td>
                        <div class='bookInfoContainer'>
                            <td class='bookSearchGenre'><span class='bookInfoTitle'>Genre - </span>" . $rows["book_genre"]. "</td>
                            <td class='bookSearchAge'><span class='bookInfoTitle'>Age Group - </span>" . $rows["age_group"]. "</td>
                            <td class='bookSearchCheckedin'><span class='bookInfoTitle'>Available -</span> ";
                                if($rows["is_checked_out"] != 1){                       
                                    echo 'yes';
                                } else {
                                    echo 'no';
                                };                                                     
                            echo "</td>  
                            <td class='bookSearchButton'>";

                            if ($_SESSION['isStaff'] === TRUE){
                                echo "
                                    <form method='post'>";
                                        if ($curPageName === 'editLibrary.php') {
                                            echo "<button class='loginButtons' id=" . $rows["book_id"] . " type='submit' name='edit' value=" . $rows["book_id"] . ">Edit</button>";
                                        }
                                        if ($rows["is_checked_out"] != 0) {
                                            echo "<button class='loginButtons' type='submit' name='checkIn' value=" . $rows["book_id"] . ">Checkin Book</button>";
                                        }                                 
                                        echo "<button class='loginButtons'>Cancel</button>
                                    </form>"; 
                            } else if ($rows["is_checked_out"] === "1" && $_SESSION['isStaff'] != TRUE) {
                                echo "
                                    <form method='post' action='mainPage.php#" . $rows["book_id"] . "'>                               
                                        <button class='login searchButton' id=" . $rows["book_id"] . " type='submit' name='addToCart' value=" . $rows["book_id"] . " disabled>Currently Unavailable</button> 
                                        <button class='login searchButton' >Cancel</button>
                                    </form>";                                  
                            } else {
                                echo "
                                    <form method='post' action='mainPage.php#" . $rows["book_id"] . "'>                               
                                        <button class='login searchButton' id=" . $rows["book_id"] . " type='submit' name='addToCart' value=" . $rows["book_id"] . ">Add to Cart</button> 
                                        <button class='login searchButton'>Cancel</button>
                                    </form>";                                           
                            }
                            echo "</td>
                        </div>
                    <tr>     
                </table>
                <hr class='horzontalBreak'>";                          
        }
        echo '</div>
        </div>'; 
        }

// The following functions allow edits to the datebase tables

    public function editBook(){
        $editId = strtolower($_POST['edit']);
        $sqls = "SELECT * FROM books LEFT OUTER JOIN authors ON books.author_id = authors.author_id   WHERE book_id = '$editId'"; 
        global $mysqli;                               
        $bookToEdit = $mysqli->query($sqls);                                           
        $rows = $bookToEdit->fetch_assoc();
        echo "
            <div class='container show' id='editFormContainer'>
                <form method='post' id=editForm enctype='multipart/form-data'>
                    <h2>Edit A Book Entry</h2>
                    <h4>You about to edit <span>" . $rows['book_title'] . "</span> by <span>" . $rows['author_name'] . "</span>.</h4>
                    <label class='label' for='editBookTitle'>Edit Book Title</label>
                    <input class='editInput' id='editBookTitle' name='editBookTitle' type='text' value='" . $rows['book_title'] . "'>

                    <label class='label' for='editGenre'>Edit Year Released</label>
                    <input class='editInput' id='editYearReleased' name='editYearReleased' type='text' value='" . $rows['year_released'] . "'>

                    <label class='label' for='editGenre'>Edit Genre</label>
                    <select class='editInput' id='editGenre' name='editGenre' type='text'>
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

                    <label class='label' for='editAgeGroup'>Edit Age Group</label>
                    <select class='editInput' id='editAgeGroup' name='editAgeGroup' type='text'> 
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
                    
                    <label class='label' for='imageEdit'>Change Image</label>
                    <input type='file' name='imageEdit'>
                    <br>
                    <button class='loginButtons' type='submit' name='editSubmit' value=" . $editId . ">Submit Edits</button>     
                    <button class='loginButtons' onclick='cancelEdit()'>Cancel</button>
                </form>
                <form method='post'>
                    <button class='loginButtons cancel' type='submit' name='deleteBook' value=" . $editId . ">Delete from database</button>
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
            echo "
                <div class='container show''>
                    <h2>Record '" . $bookTitleEdit . "' updated successfully</h2>
                </div>";
        } else {
            echo "
                <div class='container show''>
                    <h2>Error deleting record: " . $mysqli->error . "</h2>
                </div>";
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
                                        echo "
                                            <div class='container show'>
                                                <h2>New record created successfully</h2>
                                            ";
                                    } else {
                                        echo "
                                            <div class='container show'>
                                                <h2>Error: " . $bookTitle . "<br>" .  $mysqli->error . "</h2>
                                            </div>";
                                    }                
                            } else {
                                echo "
                                    <div class='container show'>
                                        <h2>Your file is too big, image should be less the 5mb</h2>
                                    </div>";
                            }
                        } else {
                            echo "
                                <div class='container show'>
                                    <h2>There was an error uploading your file</h2>
                                </div>";
                        }
                    } else {
                        echo "
                            <div class='container show'>
                                <h2>You cannot upload files of this type, file must be either jpeg, jpg or png</h2>
                            </div>";
                    };                         
        } else { 
            echo "image not edited </div>";
        };
    }
    public function deleteBookWarning(){
        $id = $_POST['deleteBook'];
        $sql = "SELECT book_title FROM books WHERE book_id = '$id'";
        global $mysqli;
        $book = $mysqli->query($sql);
        $bookToDelete = $book->fetch_assoc();
        echo "
            <section class='container show'>  
                <div>
                    <h2 class='warning'><span>WARNING</span> - You about to <span>permanently delete</span> " . $bookToDelete['book_title']. " from the database? </h2>
                    <h3>Are you sure you want to delete this?</h3>
                    <form method='post'>
                        <button class='loginButtons cancel' type='submit' name='confirmDeleteBook' value=" . $id . ">Delete Book</button>
                        <button  class='loginButtons' onclick='cancelEdit()'>Cancel</button>
                    </form>
                </div>
            </section>";
    }
    public function deleteBookFromDatabase(){
        $id = $_POST['confirmDeleteBook'];
        $book = "SELECT * FROM books WHERE book_id = '$id'";        
        global $mysqli;    
        $bookToDelete = $mysqli->query($book);
        $deleteBook = $bookToDelete->fetch_assoc();
        $sql = "DELETE FROM books WHERE book_id = '$id'";
            if($mysqli->query($sql) === TRUE){
                echo "
                    <div class='container show'>
                        <h2>" . $deleteBook['book_title'] . " has been succesfully deleted from the database</h2>
                    </div>";
            }
    }
    public function deleteAuthorWarning() {
        $id = $_POST['deleteAuthor'];
        $sql = "SELECT author_name FROM authors WHERE author_id = '$id'";
        global $mysqli;
        $author = $mysqli->query($sql);
        $authorToDelete = $author->fetch_assoc();
        echo "
            <section class='container show'>       
                <div>
                    <h2 class='warning'> <span>WARNING</span> - You about to <span>permanently delete</span> " . $authorToDelete['author_name']. " from the database, and all associated books! </h2>
                    <h3>Are you sure you want to delete this?</h3>
                    <form method='post'>
                        <button id='deleteEntry' class='searchButton addBook' type='submit' name='confirmDeleteAuthor' value=" . $id . ">Delete Author</button>
                        <button class='searchButton addBook' onclick='cancelEdit()'>Cancel</button>
                    </form>
                </div>
            </section>";
    }
    public function deleteAuthorFromDatabase() {
        $id = $_POST['confirmDeleteAuthor'];
        $author = "SELECT * FROM authors WHERE author_id = '$id'";
        global $mysqli;
        $authorToDelete = $mysqli->query($author);
        $deleteAuthor = $authorToDelete->fetch_assoc();
        $author = $deleteAuthor['author_name'];
        $sql = "DELETE FROM books WHERE author_id = '$id'";
        $mysqli->query($sql);
        $sqled = "DELETE FROM authors WHERE author_id = '$id'";
            if ($mysqli->query($sqled) === TRUE) {
                echo "
                    <div class='container show'>
                        <h2>" . $author . " has been succesfully deleted from the database</h2>
                    </div>";
            }
    }
}
$newEntry = new LibraryDatabase;
?>