member = (x) => {
    if (x === 'memberContainer') {
        document.getElementById(x).style.display = 'block';
    } else if (x === 'staffContainer'){
        document.getElementById(x).style.display = 'block';
    } else if (x === 'newMemberContainer') {
        document.getElementById(x).style.display = 'block';
    } else if (x === 'cancelMember'){
        document.getElementById('memberContainer').style.display = 'none'; 
    } else if (x === 'cancelStaff'){
        document.getElementById('staffContainer').style.display = 'none';
    } else if (x === 'cancelNewMember'){
        document.getElementById('newMemberContainer').style.display = 'none';
    }

}