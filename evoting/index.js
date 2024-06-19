const fname = document.getElementById('fname');
const lname = document.getElementById('lname');
const submit = document.getElementById('submit');

submit.addEventListener('submit',(e)=>{
    e.preventDefault();
    let ebody = `
    <h1>First Name: </h1>${fname.value}
    <br>
    <h1>Last Name: </h1>${lname.value}
    `;

    Email.send({
        SecureToken : "889c4de2-8d7a-4af5-8141-e55d627a6d22", //add your token here
        To : 'ramaku258@gmail.com', 
        From : "ganery231@gmail.com",
        Subject : "This is the subject",
        Body : ebody
    }).then(
      message => alert(message)
    );
});