<?php
session_start();

$conn=mysqli_connect(
"localhost",
"root",
"",
"swendb"
);

if(!$conn)
{
die("Connection Failed");
}

$error="";

/* Logout */

if(isset($_GET['logout']))
{
session_unset();
session_destroy();

header("Location: login.php");
exit();
}

/* Login */

if($_SERVER["REQUEST_METHOD"]=="POST")
{

$name=$_POST['name'];
$password=$_POST['password'];

$sql="SELECT * FROM login
WHERE name='$name'
AND password='$password'";

$result=mysqli_query($conn,$sql);

if(mysqli_num_rows($result)>0)
{

$_SESSION['name']=$name;

header("Location: login.php");
exit();

}
else
{

$error="Invalid Username or Password";

}

}

/* Dashboard */

if(isset($_SESSION['name']))
{
?>

<!DOCTYPE html>

<html>

<head>

<title>Dashboard</title>

<style>

body{
margin:0;
font-family:Arial;
background:#f2f2f2;
display:flex;
justify-content:center;
align-items:center;
height:100vh;
}

.box{
background:white;
padding:40px;
border-radius:10px;
box-shadow:0 0 10px rgba(0,0,0,0.2);
text-align:center;
}

a{
display:inline-block;
margin-top:20px;
padding:10px 20px;
background:red;
color:white;
text-decoration:none;
border-radius:5px;
}

</style>

</head>

<body>

<div class="box">

<h1>
Welcome
<?php echo htmlspecialchars($_SESSION['name']); ?>
</h1>

<a href="login.php?logout=1">
Logout
</a>

</div>

</body>

</html>

<?php
}
else
{
?>

<!DOCTYPE html>

<html>

<head>

<title>Login</title>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Arial;
}

body{

background:#f2f2f2;

display:flex;

justify-content:center;

align-items:center;

height:100vh;

}

.container{

background:white;

padding:30px;

width:320px;

border-radius:10px;

box-shadow:0 0 10px rgba(0,0,0,0.2);

text-align:center;

}

h2{

margin-bottom:20px;

}

input{

width:100%;

padding:12px;

margin:10px 0;

border:1px solid gray;

border-radius:5px;

}

button{

width:100%;

padding:12px;

border:none;

background:blue;

color:white;

border-radius:5px;

cursor:pointer;

}

button:hover{

background:darkblue;

}

.error{

color:red;

margin-bottom:10px;

}

</style>

</head>

<body>

<div class="container">

<h2>Login</h2>

<p class="error">

<?php echo $error; ?>

</p>

<form method="POST">

<input
type="text"
name="name"
placeholder="Username"
required>

<input
type="password"
name="password"
placeholder="Password"
required>

<button type="submit">

Login

</button>

</form>

</div>

</body>

</html>

<?php
}

mysqli_close($conn);

?>