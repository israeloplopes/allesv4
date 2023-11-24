            <li class="nav-item dropdown d-none d-xl-inline-flex user-dropdown">
              <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                <img class="img-xs rounded-circle ml-2" src="images/faces/<?=$_SESSION['foto']?>" alt="Alles"> <span class="font-weight-normal"><?=$_SESSION['usuario'];?></span></a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                <div class="dropdown-header text-center">
                  <img class="img-md rounded-circle" src="images/faces/<?=$_SESSION['foto']?>" height="50%" width="50%" alt="Alles">
                  <p class="mb-1 mt-3"><?=$_SESSION['nomeusu'];?></p>
                </div>
                <a class="dropdown-item"><i class="dropdown-item-icon icon-user text-primary"></i>Perfil <!--<span class="badge badge-pill badge-danger">1</span>--></a>
                <a class="dropdown-item"><i class="dropdown-item-icon icon-speech text-primary"></i>Mensagens</a>
                <a href="attarefa.php" class="dropdown-item"><i class="dropdown-item-icon icon-energy text-primary"></i>Tarefas</a>
                <a href="logout.php" class="dropdown-item"><i class="dropdown-item-icon icon-power text-primary"></i>Finalizar</a>
              </div>
            </li>