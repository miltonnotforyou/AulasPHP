<?php 
// Retorna o caminho da URL após o domínio, por exemplo: "/INFO_52/IOT_Store/admin/produtos/"
$url_parcial = $_SERVER['REQUEST_URI'];
// Verifica o caminho exemplo "/INFO_52/IOT_Store/admin/produtos/"
// 0 => ""
// 1 => "INFO_52"
// 2 => "IOT_Store"
// 3 => "admin"
// 4 => "produtos"
$caminho = explode("/", $url_parcial);

$url = "http://" . $_SERVER['HTTP_HOST'] // Retorna o domínio, por exemplo: "localhost"
 . "/" . $caminho[1] // Retorna a primeira parte do caminho, por exemplo: "INFO_52"
 . "/" . $caminho[2]; // Retorna a segunda parte do caminho, por exemplo: "IOT_Store"
 
?>

<header class="navbar navbar-dark sticky-top flex-md-nowrap p-0 shadow" style="background-color: #2b3d4f;">
  <!-- Link para a página inicial do admin.php -->
  <a class="navbar-brand col-md-3 col-lg-2 px-3" href="<?php echo $url; ?>/admin/Admin.php">IOT Store</a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="navbar" style="background-color: #2b3d4f;">
    <div class="nav-item text-nowrap">
      <!-- Link para sair do sistema -->
      <a class="nav-link px-3" style="color: white;"  href="<?php echo $url; ?>/admin/LogOff.php">Sair</a>
    </div>
  </div>
</header>