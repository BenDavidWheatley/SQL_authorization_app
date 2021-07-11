# authorisation_library_app
<h1>Inner city Library authorisation and database app</h1>

<p>The Inner City Library app is a database and authorization app based on a fictional library. Depending if you are logged in as a member or staff will determine what you can do on the site.</p>

<h2>Logging in</h2>
<p>From the main login page you can log in as either staff member or member, you can also create a new account.</p>

![screenshot login page](/assets/readme/screenLogin.png)

<p>Once you are logged in you will come to the main landing page which has information about upcoming events.</p>

<p>The header to the website will change depending on who is logged in. Below a member has logged in. Our header has four icons, log out, home, profile, cart (left to right). It also displays the number of books we have checked out and the number we can still check out. We can also use the search bar to search for a book within the library.</p>

![screenshot header member](/assets/readme/screenHeaderMember.png)

<p>Compare this to the staff member and out icons are now log out, home, edit library, search user. The book allowance no longer shows. Our search now also allows us to search for an auther.</p>

![screenshot header staff](/assets/readme/screenHeaderStaff.png)

<h2> Using the search bars </h2>
<h3>Searching a book</h3>
<p>Clicking on the search icon, without inputing any data, will show all results within the library. If you know the book or author that you are searching for you can type this in either fully or partially.</p>

<p>You can sort the results by a variaty of catagories.</p>

<p>The results will slightly vary depending on the user. If you are a member, then you have the option to add a book to your cart, if available. If you are a staff member then you are able to check books back in to the library.</p>

![screenshot search result as staff](/assets/readme/screenResultStaff.png)
![screenshot search result as member](/assets/readme/screenResultMember.png)
<h3>Searching an author</h3>
<p>The search author bar is the same as searching for a book, but is only available to staff members. The results will show info about the author and will allow you to view what books that author has within the library.</p>

![screenshot search result author](/assets/readme/searchAuthor.png)
![screenshot search result author books](/assets/readme/viewBooks.png)

<h2>To edit library entries</h2>

<p>As a staff member you can edit or delete an author or book from the library.</p>
<p>Head over to the edit page by clicking on the edit icon on the header.</p>

![screenshot edit icon](/assets/readme/editIcon.png)

<p>from here you can use the search bars to searc the library for the book or author. The same way as before, but this time the results will allow you to edit</p>


![screenshot search book edit](/assets/readme/bookSearchEdit.png)
![screenshot search author edit](/assets/readme/auhtorEdit.png)

<p>Clicking on the edit button with take you to a pre populated edit form, meaning that you only need to edit the fields that you wish to without havng to update all the date.

![screenshot edit form](/assets/readme/editForm.png)

<h2>Profile<h2>

<h3>Searching for a user profile</h3>

<p>clicking on the profile search icon on the header will take you to the user search page</p>

![screenshot search user icon](/assets/readme/userSearch.png)

<p>From here you can view an user, the books that they have checked out and any fines that they have on there account</p>
<p>Should they have a fine you can clear this by clicking the pay fine button</p>

![screenshot view user](/assets/readme/viewUserStaff.png)

<h3>Viewing profile as a member</h3>

<p>You can edit your profile when logged in as a member by clicking on the following icon in the header</p>

![screenshot profile icon](/assets/readme/profile.png)

<p>From the profile page you can edit any of your details as well as view the books you have checked out</p>

![screenshot edit profile](/assets/readme/editProfile.png)

<h2>Cart</h2>

<p>Clicking on the following icn in the header will take you to your cart.</p>

![screenshot cart icon](/assets/readme/cart.png)

<p>From here you are abke to checkout your books. The app will calculate the remaining books you are allowed to checkout against what ou wish to now. If the later exceeds, then you will need to remove items from your cart</p>

![screenshot cart](/assets/readme/viewCart.png)