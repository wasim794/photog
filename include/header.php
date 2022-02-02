<?php
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$url =$actual_link;
 $keys = parse_url($url); // parse the url
 $path = explode("/", $keys['path']); // splitting the path
 //print_r($path);
  $last = $path[2];
?>
<header class="site-header header-1747 light-header fixed-header">
        <div class="header-main-block">
          <div class="container-fluid">
            <div class="row">
              <div class="desktop-main-bar-left col-auto">
          
                <div class="logo-block">
                  <div class="logo site-logo-619df7962c77f">
                    <a href="/" data-magic-cursor="link">
                      <span class="logoContainer">
                        
                        <img class="imgall" src="http://localhost/photog/public/img/logo.png" alt="" />
                      </span>
                    </a>
                  </div>
                </div>
              </div>
              <div class="desktop-main-bar-right col">
                <nav class="navigation navigation-619df7962c7a2 visible_menu hover-style2">
                  <ul id="menu-navigation" class="menu">
                    <li id="menu-item-3407" class="menu-item menu-item-type-custom menu-item-object-custom <?php if($last==''){ echo "current-menu-ancestor current-menu-parent menu-item-has-children"; } ?>">
                      <a href="/">
                        <span>Home</span>
                      </a>
                    </li>
                    <li id="menu-item-2786" class="menu-item menu-item-type-custom menu-item-object-custom <?php if($last=='works'){ echo "current-menu-ancestor current-menu-parent menu-item-has-children"; } ?>">
                      <a href="http://localhost/photog/works/">
                        <span>Work</span>
                      </a>
                    </li>
                    <li id="menu-item-2793" class="menu-item menu-item-type-custom menu-item-object-custom <?php if($last=='career'){ echo "current-menu-ancestor current-menu-parent menu-item-has-children"; } ?>">
                      <a href="http://localhost/photog/career/">
                        <span>Career</span>
                      </a>
                    </li>
                   <!--  <li id="menu-item-2814" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-2814">
                      <a href="./contacts/">
                        <span>Contact</span>
                      </a>
                    </li> -->
                    <li id="menu-item-2848" class="menu-item menu-item-type-post_type menu-item-object-page <?php if($last=='about-me'){ echo "current-menu-ancestor current-menu-parent menu-item-has-children"; } ?>">
                      <a href="http://localhost/photog/about-me/">
                        <span>About Us</span>
                      </a>
                    </li>
                  </ul>
                </nav>
                
              </div>
            </div>
          </div>
        </div>
      </header>