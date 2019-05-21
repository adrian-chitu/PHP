<?php 

require_once("../utils.php");

/* 
POST
{
    name: "Costel Popescu",
    username: "costel_popescu",
    email: "costel@gmail.com",
    password: "1234"
}

*/
//Postman-verificam daca am primit un request de tip post si daca exista toate acelea


/*
POST
{
    name: 'Costel Popescu',
    username: 'costel_popescu',
    email: 'costel@gmail.com',
    password: '1234'
}
*/

# Postman

function verificaEmail($email) {
    $emailParts = explode('@', $email);
    if (count($emailParts) === 2) {
        $domainParts = explode('.', $emailParts[1]);
        if (count($domainParts) >= 2) {
            return true;
        }
    }
    return false;
}


function adauga($name, $username, $email, $password) {

    $con = conexiuneCalendar();

    $query = 'INSERT INTO users (name, username, email, password) VALUES ("' . $name . '", "' . $username . '", "' . $email . '", "' . $password . '")';

	print_r ($query);

    $result = $con->query($query);

    if ($result === false) {
        die('Eroare la adaugare ' . $con->error);
    }

     #inchide conexiune db
     $con->close();

    return $result;
}

if ( isset($_POST['name']) && isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) ) {
    # verifica daca email este valid
    $result = verificaEmail($_POST['email']);
	
    if ($result === false) {
        # intoarcem eroare in UI
        die('Email invalid');
    }

    # verifica daca exista username in db
    $result = verificaUserByUsername($_POST['username']);
    if ($result === false) {
        # intoarcem eroare in UI
        die('Username exista deja in baza de date');
    }

    # adauga user in tabela users
    $result = adauga($_POST['name'], $_POST['username'], $_POST['email'], $_POST['password']);
	
	print_r("Rezultat adaugare: ". $result);
}

?>