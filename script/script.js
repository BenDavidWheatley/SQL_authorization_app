
member = (x) => {
        document.getElementById('staffContainer').style.display = 'none';
        document.getElementById('newMemberContainer').style.display = 'none';
        document.getElementById('loginTypeContainer').style.display = 'none'; 
        document.getElementById('loginTitle').style.display = 'none';
        document.getElementById('memberContainer').style.display = 'none';      

    if (x === 'memberContainer') {
        document.getElementById(x).style.display = 'block';       
    } else if (x === 'staffContainer'){
        document.getElementById(x).style.display = 'block';
    } else if (x === 'newMemberContainer') {
        document.getElementById(x).style.display = 'block';
    } else if (x === 'cancelMember'){       
        document.getElementById('loginTypeContainer').style.display = 'block';
        document.getElementById('loginTitle').style.display = 'block';
    } else if (x === 'cancelStaff'){       
        document.getElementById('loginTypeContainer').style.display = 'block';
        document.getElementById('loginTitle').style.display = 'block';
    } else if (x === 'cancelNewMember'){
        document.getElementById('loginTypeContainer').style.display = 'block';
        document.getElementById('loginTitle').style.display = 'block';
    }
}
showBox = (x) => {
    document.getElementById('editFirstName').style.display = 'none';
    document.getElementById('editSurname').style.display = 'none';
    document.getElementById('editUsername').style.display = 'none';
    document.getElementById('editEmail').style.display = 'none';
    document.getElementById('editPassword').style.display = 'none';
    document.getElementById('editUserImage').style.display = 'none';

    if (x === 'editFirstName'){
        document.getElementById(x).style.display = 'block';
    } else if (x === 'editSurname') {
        document.getElementById(x).style.display = 'block';
    } else if (x === 'editUsername') {
        document.getElementById(x).style.display = 'block';
    } else if (x === 'editEmail') {
        document.getElementById(x).style.display = 'block';
    } else if (x === 'editPassword') {
        document.getElementById(x).style.display = 'block';
    } else if (x === 'editUserImage') {
        document.getElementById(x).style.display = 'block';
    }   
}
hideBox = (x) => {
    document.getElementById(x).style.display = 'none';
}

mainPage = () => {
    window.location = 'mainPage.php'
}
cart= () => {
    window.location = 'cart.php'
}
display = () => {
    document.getElementById('viewCartContainer').style.display = 'none';
}


// This function hides the relevant page divs when a book is searched

bookSearch = () => {
    let doesExist = document.getElementById('bookSearchResult');
    let doesAuthorExist = document.getElementById('searchAuthorContainer');
    let authorsBooks = document.getElementById('searchAuthorContainer');
    let noBooks = document.getElementById('authorDoesNotExist');
    let user = document.getElementById('userSearch');
    let usersBooks = document.getElementById('');
    let searchUser = document.getElementById('searchUser');
    let events = document.getElementById('eventsAndInfoContainer');
    let cart = document.getElementById('booksInCart');
    let profile = document.getElementById('profileContainer');

  
    if (doesExist || doesAuthorExist || authorsBooks || noBooks || user) {
        console.log('yes');
        if (events) {
        events.style.display = 'none';
        } else if (cart) {
        cart.style.display = 'none';
        } else if (profile) {
            profile.style.display = 'none';
        } else if (searchUser){
            searchUser.style.display = 'none'
        }
    } else {
        if(events) {
            events.style.display = 'block';
        } else if (cart){
            cart.style.display = 'block';
        } else if  (profile) {
            profile.style.display = 'grid';
        } else if (searchUser) {
            searchUser.style.display = 'block';
        }
    }
}
