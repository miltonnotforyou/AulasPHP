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

<!-- Navegação lateral -->
<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse" style="background-color: #2b3d4f;">
  <div class="position-sticky pt-3">
    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-light">
      <span>OPÇÕES</span>
    </h6>
    
    <ul class="nav flex-column">
      <li class="nav-item">
        <!-- O link para a página inicial do admin.php é construído usando a variável $url, que contém o caminho base do projeto. -->
        <a class="nav-link text-white" href="<?php echo $url; ?>/admin/admin.php">
          <i class="bi bi-house-door-fill"></i>
          Início
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link text-white" href="<?php echo $url; ?>/admin/cargos/">
          <i class="bi bi-person-fill-gear"></i>
          Cargos
        </a>
      </li>

      <?php if ($_SESSION['TYPE'] == 1)  
          {
            ?>
      <li class="nav-item">
        <a class="nav-link text-white" href="<?php echo $url; ?>/admin/funcionarios/">
          <i class="bi bi-person-vcard-fill"></i>
          Funcionários
        </a>
      </li>
      <?php } ?>  

      
      <li class="nav-item">
        <a class="nav-link text-white" href="<?php echo $url; ?>/admin/categorias/">
          <i class="bi bi-stack"></i>
          Categorias
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link text-white" href="<?php echo $url; ?>/admin/marcas/">
          <i class="bi bi-bag-fill"></i>
          Marcas
        </a>
      </li>
      
      <li class="nav-item">
        <a class="nav-link text-white" href="<?php echo $url; ?>/admin/produtos/">
          <i class="bi bi-archive-fill"></i>
          Produtos
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link text-white" href="<?php echo $url; ?>/admin/clientes/">
          <i class="bi bi-people-fill"></i>
          Clientes
        </a>
      </li>
    </ul>
  </div>
</nav>