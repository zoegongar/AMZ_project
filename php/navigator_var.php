<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
body {
  font-family: Arial, Helvetica, sans-serif;
  margin: 0;
}

.nav_bar {
  overflow: hidden;
  background-color: #D60707; 
}

.nav_bar a {
  float: left;
  font-size: 16px;
  color: #0D0C0C;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

.sub_nav {
  float: left;
  overflow: hidden;
}

.sub_nav .sub_nav_btn {
  font-size: 16px;  
  border: none;
  outline: none;
  color: #0D0C0C;
  padding: 14px 16px;
  background-color: inherit;
  font-family: inherit;
  margin: 0;
}

.sub_nav:hover, a:hover, .sub_nav:hover .sub_nav_btn {
  background-color: #0D0C0C;
  color: #D60707;
}

.sub_nav-content {
  display: none;
  position: absolute;
  left: 0;
  background-color: red;
  width: 100%;
  z-index: 1;
}

.sub_nav-content a {
  float: left;
  color: #0D0C0C;
  text-decoration: none;
}

.sub_nav-content a:hover {
  background-color: #0D0C0C;
  color: #D60707;
}

.sub_nav:hover .sub_nav-content {

  display: block;
}
</style>
</head>
<body>

<div class="nav_bar">
  <a href="#home">Home</a>
  <div class="sub_nav">
    <button class="sub_nav_btn">Usuaria <i class="fa fa-caret-down"></i></button>
    <div class="sub_nav-content">
      <a href="new_user.php">Crear usuaria</a>
      <a href="search_user.php">Visualizar usuaria</a>
      <a href="update_user.php">Modificar usuaria</a>
      <a href="delete_user.php">Borrar usuaria</a>
    </div>
  </div> 
  <div class="sub_nav">
    <button class="sub_nav_btn">Permanencias <i class="fa fa-caret-down"></i></button>
    <div class="sub_nav-content">
      <a href="new_shift.php">Crear permanencia</a>
      <a href="update_shift.php">Modificar permanencia</a>      
      <a >Visualizar permanencias</a>
      <a href="delete_user.php">Borrar permanencia</a>
    </div>
  </div> 
  <a href="https://amzcreandocirco.org">blog</a>
  <a href="#home">Contacto</a>
</div>
</body>
</html>
