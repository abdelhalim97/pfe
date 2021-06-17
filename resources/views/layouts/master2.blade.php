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
<body >
<div class="wrapper" id="app">


  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light" style="margin-left:0px;;padding-bottom: 0px;">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
      <img src="/images/eta/etaTransparentImg.png" alt="AdminLTE Logo" class="brand-image"
           style="opacity: .8">
      </li>
      <li class="nav-item d-none d-sm-inline-block">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
        <i id="gg" class="fas fa-user-circle sz "></i>
        </div>
        <div class="info">
          <a id="gg" class="d-block">{{ Auth::user()->name }}</a>
        </div>
      </div>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown" style="height:10%">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fas fa-language"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
          <a href="#" class="dropdown-item" @click="changeEn" style="padding:0 1% 0 3%">
          <img  src="/images/eta/icons8-great-britain-48.png"> <span>EN</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item" @click="changeFr" style="padding:0 1% 0 3%">
          <img  src="/images/eta/icons8-france-48.png"> <span>FR</span>
          </a>
      </li>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
      <div class="user-panel  pb-3 mb-3 d-flex" style="margin-top:0px;margin-bot:0px" >
      <a style="padding-top:0px" class="nav-link red" href="{{ route('logout') }}"  onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    <i class="fas fa-power-off ddanger" style="padding-left:25%"></i>
                                    <p class="ddanger">{{ __('Logout') }}</p>
       </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                    </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="margin-left:0px;position:relative">
    <!-- Content Header (Page header) -->
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

    <!-- controls  -->


    <!-- indicators -->
    <div class="indicator">
    </div>

  </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content " >

      <div class="container-fluid" style="opacity:92%;position: absolute;
    z-index: 10; ">
<router-view></router-view>
<vue-progress-bar></vue-progress-bar>

        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->



  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">

    </div>
    <!-- Default to the left -->
  </footer>

</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<script src="/js/app.js"></script>
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
<style>
    .modal-backdrop{
        display:none;
    }
    body{
	margin:0;
	font-family: "Times New Roman", Times, serif;
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
</body>
</html>

