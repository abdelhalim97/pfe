<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>E-T-A</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="/css/app.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper" id="app">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <div class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" @keyup.enter="searchit" v-model="search" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" @click="searchit" >
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </div>
    </ul>
    <!-- SEARCH FORM -->
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fas fa-language"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item" @click="changeEn" style="padding:0 1% 0 3%">
          <img  src="/images/eta/icons8-great-britain-48.png"> <span>EN</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item" @click="changeFr" style="padding:0 1% 0 3%">
          <img  src="/images/eta/icons8-france-48.png"> <span>FR</span>

          </a>

      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4" style="position: fixed;">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img id="fn" src="/images/eta/etaTransparentImg.png" alt="AdminLTE Logo" class="brand-image"
           style="opacity: .8">
    </a>

    <!-- Sidebar -->
    <div class="sidebar" style="height: 100vh;">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <span class="image sz ">
        <i class="fas fa-user-circle"></i>

</span>
        <div class="info" id="padd">
          <a href="#" class="d-block black" id="abyedh">{{ Auth::user()->name }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               @if(Auth::guard('moderator')->check())
               <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <li class="nav-item">
            <router-link to="/moderator" class="nav-link" id="abyedh">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p class="n1">
                Dashboard
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/profile" class="nav-link" id="abyedh">
              <i class="nav-icon fas fa-id-card"></i>
              <p class="n11">
              Profile
              </p>
            </router-link>
          </li>
          </li>
          <li class="nav-item red" >

            <a class="nav-link red" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                                 <i class="fas fa-power-off red"></i>
                                                     <p class="red n10">{{ __('Logout') }}</p>
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
          </li>
        </ul>
      </nav>
@elseif(Auth::guard('admin')->check())
<nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <li class="nav-item">
            <router-link to="/user" class="nav-link" id="abyedh">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p class="n1" >
                Dashboard
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/worker" class="nav-link" id="abyedh">
              <i class="nav-icon fas fa-id-badge"></i>
              <p class="n2">
                Workers
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/order" class="nav-link" id="abyedh">
              <i class="nav-icon fas fa-clipboard-list"></i>
              <p class="n3">
                Orders
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/product" class="nav-link" id="abyedh">
              <i class="nav-icon fas fa-dolly-flatbed"></i>
              <p  class="n4">
                Product
              </p>
            </router-link>
          </li>
          <li class="nav-item has-treeview" id="abyedh">
            <a href="#" class="nav-link ">
              <i class="nav-icon fas fa-cubes"></i>
              <p  class="n5">
                add elements
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" >
              <li class="nav-item">
                <router-link to="/button" class="nav-link" id="abyedh">
                  <i class="far fas fa-toggle-on"></i>
                  <p  class="n6">add button</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/boitier" class="nav-link" id="abyedh">
                  <i class="far fas fa-box"></i>
                  <p  class="n7">add boitier</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/connection" class="nav-link" id="abyedh">
                  <i class="far fas fa-link"></i>
                  <p  class="n8">add connection</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/ampere" class="nav-link" id="abyedh">
                  <i class="fas fa-bolt"></i>
                  <p class="n9">add amperage</p>
                </router-link>
              </li>
            </ul>
          </li>
          <li class="nav-item" >
<a class="nav-link" href="{{ route('logout') }}"  onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                                                     <i class="fas fa-power-off ddanger"></i>
                                         <p class="ddanger n10">{{ __('Logout') }}</p>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
</li>
        </ul>


      </nav>

@endif
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="margin-left:0px;position:relative">
    <section class="home">
     <div class="slider">
        <div class="slide active" style="background-image: url('images/slide-1.jpg')">
            <div class="container">
                <!-- <div class="caption">
                    <h1>1. Winter Collection 2020</h1>
                    <p>Lorem ipsum dummy text goes here.</p>
                    <a href="">Shop Now</a>
                </div> -->
            </div>
        </div>
        <div class="slide" style="background-image: url('images/slide-2.jpg')">
            <div class="container">
                <!-- <div class="caption">
                    <h1>2. Winter Collection 2020</h1>
                    <p>Lorem ipsum dummy text goes here.</p>
                    <a href="">Shop Now</a>
                </div> -->
            </div>
        </div>
        <div class="slide" style="background-image: url('images/slide-3.jpg')">
            <div class="container">
                <!-- <div class="caption">
                    <h1>3. Winter Collection 2020</h1>
                    <p>Lorem ipsum dummy text goes here.</p>
                    <a href="">Shop Now</a>
                </div> -->
            </div>
        </div>
     </div>
    <div class="indicator">
    </div>
  </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content" style="opacity:92%;position: absolute;
    z-index: 10;top:0;bottom:0;right:0;left:0;margin:auto">

      <div class="container-fluid" >

<router-view></router-view>
<vue-progress-bar></vue-progress-bar>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>

  <!-- <footer class="main-footer nopad" style="position:absolute;z-index:11">
    <div class="float-right d-none d-sm-inline">
    <div class="container">
		<div class="langWrap">
			<a href="#" language='EN' @click="changeEn" class="lougha" >English</a>
			<a href="#" language='FR' @click="changeFr" class="lougha">&nbsp;&nbsp;Francais</a>
		</div>
    </div>
  </footer> -->
</div>
<!-- ./wrapper -->
<!-- REQUIRED SCRIPTS -->
<style>
    .modal-backdrop{
        display:none;
    }
    body{
	margin:0;
	overflow-x: hidden;
}
*{	box-sizing: border-box;}
.home{
    width: 100vw;
	height: 100vh;
	overflow:hidden;
    position: absolute;
    z-index: 9;
}
.home .slide{
	position: absolute;
	left:0;
	top:0;
	width: 100%;
	height: 100%;
	background-size: cover;
	background-position: center;
	z-index:1;
	display:none;
	padding:0 15px;
	animation: slide 2s ease;
}
.home .slide.active{
	display: flex;
}
@keyframes slide{
	0%{
		transform:scale(1.1);
	}
	100%{
		transform: scale(1);
	}
}
.container{
	max-width: 1170px;
	margin:auto;
}
.home .container{
	 flex-grow: 1;
}
.home .caption{
	width:50%;
}
.home .caption h1{
	font-size:42px;
	color:#000000;
	margin:0;
}
.home .slide.active .caption h1{
	opacity:0;
	animation: captionText .5s ease forwards;
	animation-delay:1s;
}
.home .caption p{
	font-size: 18px;
	margin:15px 0 30px;
	color:#222222;
}
.home .slide.active .caption p{
	opacity:0;
	animation: captionText .5s ease forwards;
	animation-delay:1.2s;
}
.home .caption a{
 display: inline-block;
 padding:10px 30px;
 background-color: #000000;
 text-decoration: none;
 color:#ffffff;
}
.home .slide.active .caption a{
	opacity:0;
	animation: captionText .5s ease forwards;
	animation-delay:1.4s;
}
@keyframes captionText{
	0%{
		opacity:0; transform: translateX(-100px);
	}
	100%{
	 opacity:1; transform: translateX(0px);
	}
}
.home .controls .prev,
.home .controls .next{
 position: absolute;
 z-index:2;
 top:50%;
 height:40px;
 width: 40px;
 margin-top: -20px;
 color:#ffffff;
 background-color: #FF5722;
 text-align: center;
 line-height: 40px;
 font-size:20px;
 cursor:pointer;
 transition: all .5s ease;
}
.home .controls .prev:hover,
.home .controls .next:hover{
	background-color: #000000;
}
.home .controls .prev{
 left:0;
}
.home .controls .next{
 right:0;
}
.home .indicator{
	position: absolute;
	left:50%;
	bottom:30px;
	z-index: 2;
	transform: translateX(-50%);
}
.home .indicator div{
	display: inline-block;
	width:25px;
	height: 25px;
	color:#ffffff;
	background-color: #FF5722;
	border-radius:50%;
	text-align: center;
	line-height: 25px;
	margin:0 3px;
}
.home .indicator div.active{
 background-color: #000;
}
/*responsive*/
@media(max-width: 767px){
	.controls{
		display: none;
	}
}
</style>
<script src="/js/app.js"></script>
<script>
		const langEl = document.querySelector('.langWrap');
		const link = document.querySelectorAll('a');
		const titleEl1 = document.querySelector('.n1');
        const titleEl2 = document.querySelector('.n2');
		const titleEl3 = document.querySelector('.n3');
		const titleEl4 = document.querySelector('.n4');
		const titleEl5 = document.querySelector('.n5');
		const titleEl6 = document.querySelector('.n6');
		const titleEl7 = document.querySelector('.n7');
		const titleEl8 = document.querySelector('.n8');
		const titleEl9 = document.querySelector('.n9');
		const titleEl10 = document.querySelector('.n10');
		link.forEach(el => {
			el.addEventListener('click', () => {
				const attr = el.getAttribute('language');
				titleEl1.textContent = data[attr].n1;
                titleEl2.textContent = data[attr].n2;
				titleEl3.textContent = data[attr].n3;
				titleEl4.textContent = data[attr].n4;
				titleEl5.textContent = data[attr].n5;
				titleEl6.textContent = data[attr].n6;
				titleEl7.textContent = data[attr].n7;
				titleEl8.textContent = data[attr].n8;
				titleEl9.textContent = data[attr].n9;
				titleEl10.textContent = data[attr].n10;
			});
		});
		var data = {
			  "EN":
			  {
			    "n1": "Dashboard",
                "n2": "Workers",
			    "n3": "Orders",
			    "n4": "Product",
			    "n5": "Add elements",
			    "n6": "Add button",
			    "n7": "Add boitier",
			    "n8": "Add connetion",
			    "n9": "Add amperage",
			    "n10": "Logout",
			    "n11": "Profile"

			  },
			  "FR":
			  {
			    "n1": "Tableau de bord",
                "n2": "Les ouvriers",
			    "n3": "les commandes",
			    "n4": "Les produits",
			    "n5": "Ajouter des éléments",
			    "n6": "Ajouter les boutons",
			    "n7": "Ajouter les boitiers",
			    "n8": "Ajouter les connecxions",
			    "n9": "Ajouter les ampérage",
			    "n10": "Se déconnecter",
			    "n10": "Profil"
			  }
			}
	</script>
<script>
const slides=document.querySelector(".slider").children;
const prev=document.querySelector(".prev");
const next=document.querySelector(".next");
const indicator=document.querySelector(".indicator");
let index=0;

  function nextSlide(){
     if(index==slides.length-1){
         index=0;
     }
     else{
         index++;
     }
     changeSlide();
  }
  function changeSlide(){
             for(let i=0; i<slides.length; i++){
                  slides[i].classList.remove("active");
             }
      slides[index].classList.add("active");
  }
  function resetTimer(){
        clearInterval(timer);
        timer=setInterval(autoPlay,4000);
  }
 function autoPlay(){
     nextSlide();
 }
 let timer=setInterval(autoPlay,4000);
</script>
</body>
</html>

