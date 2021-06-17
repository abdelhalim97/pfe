@extends('layouts.app')
@section('content')
<body onload="getfocustext();">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<form method="post" action="{{route('scanner.reader')}}">
<select name="family">
  <option>3120</option>
</select>
<input  type="text" name="scanner1" id="text" maxlength="4" onkeyup="moveCursor(this,'text2')"/>
<input  type="text" name="scanner2" id="text2" maxlength="4" onkeyup="moveCursor(this,'text3')"/>
<input  type="text" name="scanner3" id="text3" maxlength="6" onkeyup="moveCursor(this,'text4')"/><!-- max =9-->
<input  type="text" name="scanner4" id="text4" maxlength="4"/>

<input value="Type registration number" href="#" data-toggle="modal" data-target="#myModal" class="btn btn-primary">

@csrf
<div class="modal fade" id=myModal>
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
<h1>Type your registration number</h1>
</div>
<div class="modal-body">
<input type="text" name="nb_matricule"></div>
<div class="modal-footer">
<input type="submit" name="submit" value="search" class="btn btn-primary"/>
<input value="close" data-dismiss="modal" class="btn btn-danger col-sm-*">
</div>
</div>
</div>
</div>
</form>

<script>
function getfocustext(){
    document.getElementById("text").focus();//autofocus
}
function moveCursor(fromTextBox,toTextBox){
    var length = fromTextBox.value.length;//auto cursor translation
    var maxLength = fromTextBox.getAttribute("maxLength");
    if(length==maxLength){
        document.getElementById(toTextBox).focus();
    }
}
//
// ch.addEventListener('change',function(e){
//     if(ch.checked){
//         document.getElementById("text3").setAttribute("maxlength", "6");

//     }
//     else{
//         document.getElementById("text3").setAttribute("maxlength", "5");

//     }
// })



</script>
@endsection
</body>
