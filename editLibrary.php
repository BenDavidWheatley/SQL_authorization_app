<?php 
session_start();
include('function.php');
include('login.php');
include('connect.php');
$mysqli->query($sql);

?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="style/style.css" type="text/css">
        <title>Library App</title>
    </head>

    <body>
        <header>
            <?php include('header.php')?>
        <header>
        <section id='searchAuthorContainer'>
            <div>
                <h2>Seacrh for the author you wish to update</h2>
                <form id='searchAuthorForm' method='post'>
                    <label>Search database for author</label>
                    <input id='searchAuthor' name='searchAuthor' type='text'>

                    <input type='submit' name='searchAuthorSubmit' value='search'>
                </form>                    
            </div>

            <div>
            <?php 
                if(isset($_POST['searchAuthorSubmit'])){
                    echo "<h3>Your author search result is - </h3>";
                    $authorName = '%'.strtolower($_POST['searchAuthor']).'%'; 
                    $sql = "SELECT * FROM authors  WHERE author_name LIKE '$authorName'"; //LEFT OUTER JOIN books ON authors.author_id = books.author_id 

                    $doesAuthorExist = $mysqli->query($sql); 
                    
                    while($author = $doesAuthorExist->fetch_assoc()){;                              
                        echo "<table id='searchAuthorContainer'>
                                <tr class='searchTable'>
                                    <td>" . $author["author_id"]. "</td>
                                    <td>" . $author["author_name"]. "</td>
                                    <td>" . $author["age"]. "</td>
                                    <td>" . $author["genre"]. "</td>
                                    <td>" . $author["book_title"] . "</td>
                                    <td>" . $author["year_release"] . "</td>
                                    <td>" . $author["book_genre"] . "</td> 
                                    <td>" . $author["age_group"] . "</td>                                                                 
                                    <td>                      
                                    <form method='post'>
                                        <button id=" . $author["author_id"] . " type='submit' name='viewBooks' value=" . $author["author_id"] . ">View books</button> 
                                        <button onClick='window.location.href=window.location.href'>Cancel</button>
                                    </form>    
                                    </td>
                                <tr>     
                            </table>";
                        }
                    if (!$doesAuthorExist->fetch_assoc()) {
                    echo '<h4>Author is not in the database.
                    create author input</h4>';

                    echo "<div id='formContainerAuthor'>
                            <form id='authorFormContainer' method='post'>
                                <label for='authorsName'>Authors Name</label>
                                <input id='authorsName' name='authorsName' type='text' pattern='[a-z A-Z]+' required>

                                <label for='authorsAge'>Authors Age</label>
                                <input id='authorsAge' name='authorsAge' type='text' pattern='[0-9]+' required>

                                <label for='mainGenre'>Main Genre</label>
                                <select id='mainGenre' name='mainGenre' required>
                                    <option hidden disabled selected value> -- select an option -- </option>
                                    <option>Fiction</option>
                                    <option>Non-fiction</option>
                                </select>

                                <input type='submit' name='submitAuthor' value='submit'> 
                                <button onClick='window.location.href=window.location.href'>Cancel</button>
                            </form>
                        </div>";
                    };   
                };
                if (isset($_POST['viewBooks'])){
                    $id = $_POST['viewBooks'];

                    $sql = "SELECT * FROM books WHERE author_id = '$id'";
                    $viewBooks = $mysqli->query($sql); 
                    
                    while($author = $viewBooks->fetch_assoc()){
                            echo 
                            "<table> 
                                <tr>
                                    <td>" . $author["book_title"] . "</td>
                                    <td>" . $author["year_release"] . "</td>
                                    <td>" . $author["book_genre"] . "</td> 
                                    <td>" . $author["age_group"] . "</td>                               
                                </tr>                              
                            </table>"; 
                    }; 
                    echo 
                    "<form method='post'>
                    <button id=" . $id . " type='submit' name='addBookToDatabase' value=" . $id . ">add book</button>
                    </form>";
                };

                if(isset($_POST['submitAuthor'])){
                    $authorsName = strtolower($_POST['authorsName']);
                    $authorsAge = $_POST['authorsAge'];
                    $mainGenre = $_POST['mainGenre'];
                    $sql = "INSERT INTO authors (author_name, age, genre) VALUE ('$authorsName', '$authorsAge', '$mainGenre')";
                    if ($mysqli->query($sql) === TRUE) {
                        echo "New author added to database";
                        } else {
                            echo "Error: " . $authorName . "<br>" .  $mysqli->error;
                        }
                }                  
                 ?>
            </div>
        </section>

        <section id='bookAuthorForms'>             
            <?php if(isset($_POST['addBookToDatabase'])){
                $id = $_POST['addBookToDatabase'];
                echo    "<div id='formContainerBook'>      
                            <form id='bookFormContainer' method='post'>
                                <h2>Create a new book or author entry into the libraries database</h2>
                                <label for='bookTitle'>Book Title</label>
                                <input id='bookTitle' name='bookTitle' type='text' required>
                            
                                <label for='yearReleased'>Year released</label>
                                <input id='yearReleased' name='yearReleased' type='date' required>

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

                                <label for='ageGroup'>Age Group</label>
                                <select id='ageGroup' name='ageGroup' required>
                                    <option hidden disabled selected value> -- select an option -- </option>
                                    <option value='all ages'>All ages</option>
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

                                <button type='submit' name='submitBook' value=" . $id . ">Submit</button>     
                            </form>
                        </div>";
                    };

                    if (isset($_POST['submitBook'])){
                        $id = ($_POST['submitBook']);
                        $bookTitle = strtolower($_POST['bookTitle']);                   
                        $yearReleased = $_POST['yearReleased'];
                        $genre = $_POST['genre'];
                        $ageGroup = $_POST['ageGroup'];                     
                        $book = "INSERT INTO books (book_title, year_released, book_genre, age_group, author_id)
                        VALUES ('$bookTitle', '$yearReleased', '$genre', '$ageGroup', '$id')";
                        
                        if ($mysqli->query($book) === TRUE) {
                            echo "New record created successfully";
                            } else {
                                echo "Error: " . $bookTitle . "<br>" .  $mysqli->error;
                            }};?>         
        </section>

        <section>
            <div id=searchEditBar>
                <form method='post'>
                    <label for='searchDatabase'>Search Book</label>
                    <input id='searchDatabase' name='searchDatabase' type='text'>
                    <button type='submit' name='search'>Search Database</button>
                </form>           
            </div>
            <div>
                <?php if (isset($_POST['search'])) {
                    $result = '%'.strtolower($_POST['searchDatabase']).'%';               
                    echo "<h3>Your search result is - </h3>";
                    $sqls = "SELECT * FROM books LEFT OUTER JOIN authors ON books.author_id = authors.author_id 
                    WHERE book_title LIKE '$result'";  //JOIN books ON authors.author_id = books.author_id 
                    $searchResult = $mysqli->query($sqls);               
                        while($rows = $searchResult->fetch_assoc()){                          
                            echo "<table id='searchContainer'>
                                    <tr class='searchTable'>
                                        <td>" . $rows["book_id"]. "</td>
                                        <td>" . $rows["book_title"]. "</td>
                                        <td>" . $rows["author_name"] . "</td>
                                        <td>" . $rows["book_genre"]. "</td>
                                        <td>" . $rows["age_group"]. "</td>
                                        <td>";
                                            if($rows["is_checked_out"] === "1"){                            
                                                echo 'yes';
                                            } else {
                                                echo 'no';
                                            };                                                     
                                        echo "</td>  
                                        <td>                      
                                        <form method='post' onsubmit='editlibrary.php'>
                                            <button id=" . $rows["book_id"] . " type='submit' name='edit' value=" . $rows["book_id"] . ">Edit</button> 
                                            <button>Cancel</button>  
                                        </form>    
                                        </td>
                                    <tr>     
                                </table>";
                    }
                }; ?>
            </div>
            <div id='editContainer'>
                <?php
                    if (isset($_POST['edit'])){
                        $editId = strtolower($_POST['edit']);
                        $sqls = "SELECT * FROM books WHERE book_id = '$editId'";                                
                                    $bookToEdit = $mysqli->query($sqls);                                           
                                    $rows = $bookToEdit->fetch_assoc();

                        echo "<div id='editFormContainer'>
                                <form method='post' id=editForm>
                                    <h2>Edit A Book Entry</h2>
                                    <h4>You about to edit book ID " . $rows["book_id"] . " - " . $rows['book_title'] . " by " . "placeholderAuthor" . ".</h4>
                                    <label for='editBookTitle'>Edit Book Title</label>
                                    <input id='editBookTitle' name='editBookTitle' type='text' value='" . $rows['book_title'] . "'>

                                    <label for='editGenre'>Edit Year Released</label>
                                    <input id='editYearReleased' name='editYearReleased' type='date' value='" . $rows['year_released'] . "'>

                                    <label for='editGenre'>Edit Genre</label>
                                    <select id='editGenre' name='editGenre' type='text'>
                                        <option hidden disabled selected value>" . $rows['book_genre'] . "</option>
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
                                        <option hidden disabled selected value>" . $rows['age_group'] . "</option>
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

                                    <button type='submit' name='editSubmit' value=" . $editId . ">Edit task</button>       
                                    <button onclick='cancelEdit()'>Cancel</button>
                                </form>
                                
                            </div>";
                    }
                        if (isset($_POST['editSubmit'])){
                            echo $rows['book_title'];
                            $bookId = $_POST['editSubmit'];
                            $bookTitleEdit = strtolower($_POST['editBookTitle']);
                            $yearReleasedEdit = $_POST['editYearReleased'];
                            $genreEdit = $_POST['editGenre'];
                            $ageGroupEdit = $_POST['editAgeGroup'];
                            echo $bookId . "<br>";
                            echo $bookTitleEdit . "<br>";
                            echo $yearReleasedEdit . "<br>";
                            echo $genreEdit . "<br>";
                            echo $ageGroupEdit . "<br>";

                            $sql = "UPDATE books
                            SET book_title = '$bookTitleEdit', year_released = '$yearReleasedEdit', book_genre = '$genreEdit', age_group = '$ageGroupEdit'
                            WHERE book_id = $bookId";       
                                if ($mysqli->query($sql) === TRUE) {
                                    echo "Record '" . $bookTitleEdit . "' updated successfully";
                                } else {
                                    echo "Error deleting record: " . $mysqli->error;
                              }
                            }?>
            </div>
        </section>


        <footer>
            <?php include('footer.php') ?>
        </footer>

        <script src='script/script.js'></script>

    </body> 
</html>