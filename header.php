<!DOCTYPE html>
<html lang="pt-br" dir="ltr">
<head>
  <title>Pousada</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  

    <style>
      body {
    margin: 0;
    padding: 0;
    font-family: 'Arial', sans-serif;
}

.header {
    background-color: white;
    color: #DEB887;
    padding: 15px 0;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: white;
}

header a{
  color: black;

}

.logo img {
    width: 100px;
}

.nav-menu {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
}

.nav-link {
    color: black;
    text-decoration: none;
    margin: 0 15px;
    font-weight: bold;
}

.nav-link:hover {
    color: #0077ff;
  }

@media screen and (max-width: 768px) {
    .nav-menu {
        flex-direction: column;
        align-items: flex-start;
    }

    .nav-link {
        margin: 10px 0;
    }
}
.nav-menu {
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
  gap: 10px;
}

.nav-menu li {
  position: relative;
}

.nav-menu, 
.nav-menu ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

.nav-link {
  text-decoration: none;
  color: #333;
  padding: 8px 12px;
  display: block;
}

.dropdown-menu {
  position: absolute;
  top: 100%;
  left: 0;
  background: #fff;
  border: none;
  display: none;
  min-width: 150px;
  z-index: 1000;
}

.dropdown-menu li {
  width: 100%;
}

.dropdown-menu .nav-link {
  padding: 10px 15px;
  color: black;
}

.dropdown-menu .nav-link:hover {
  background-color:none;
  color: #0077ff;
}

.dropdown:hover .dropdown-menu {
  display: block;
  animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
  from {opacity: 0;}
  to {opacity: 1;}
}

    </style>
</head>

<body>
  <header class="header" id="navigation-menu">
    <div class="container">
      <nav>
        <a href="http://localhost:8085/" class="logo"> <img src="imagens/logo2.webp" alt=""> </a>

        <ul class="nav-menu">
          <li><a href="index.php" class="nav-link">Início</a></li>

          <li class="dropdown">
            <a href="#" class="nav-link">Cadastrar ▾</a>
            <ul class="dropdown-menu">
              <li><a href="cadastrar_caixa.php" class="nav-link">Pagamento</a></li>
              <li><a href="cadastrar_gasto.php" class="nav-link">Gasto</a></li>
              <li><a href="cadastrar_cartao.php" class="nav-link">Cartão</a></li>
              <!-- Adicione outras opções de cadastro aqui -->
            </ul>
          </li>

          <li class="dropdown">
            <a href="#" class="nav-link">Ver ▾</a>
            <ul class="dropdown-menu">
              <li><a href="resumo_caixa.php" class="nav-link">Resumo</a></li>
              <!-- <li><a href="cadastrar_gasto.php" class="nav-link">Gasto</a></li>
              <li><a href="cadastrar_cartao.php" class="nav-link">Cartão</a></li> -->
              <!-- Adicione outras opções de cadastro aqui -->
            </ul>
          </li>
          <li><a href="faleconosco.php" class="nav-link">Fale Conosco</a></li>
          <li><a href="login.php" class="nav-link">Entrar</a></li>
        </ul>
      </nav>
    </div>
  </header>


  
</body>

</html>