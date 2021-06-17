<template>
    <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{this.$parent.lg=='en'? 'Search for product' :'Rechercher un produit'}}</h3>
                <div class="card-tools">
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body ">
                  <form @submit.prevent="search()" v-if="this.result==false" >
                      <div class="row">
                          <div class="col-md-12">
                              <div class="form-group row  justify-content-around">
                                  <label for="" class=" col-md-3 col-sm-3">{{this.$parent.lg=='en'? 'Family name' :'La famille'}}</label>
                        <select v-model="form.family" @change="onFamily" class="custom-select col-md-3 col-sm-3">
        <option disabled value="">{{this.$parent.lg=='en'? 'Choose the family' :'Choisissez la famille'}}</option>
                          <option >3120</option>
                          <option>3121</option>
                        </select>
                        <label for="" class=" col-md-3 col-sm-3">{{this.$parent.lg=='en'? 'Boitier\'s description' :'La description du boitier'}}</label>
                    <input @change="onScanner1Change()" @input="countChars1" v-model="form.scanner1" name="scanner1" type="text" class="form-control col-md-3 col-sm-3" :maxlength="ml1" :class="{ 'is-invalid': form.errors.has('scanner1') }">
                        <has-error :form="form" field="scanner1"></has-error>
                    </div>

                    <div class="form-group row  justify-content-around">

                        <label for="" class=" col-md-3 col-sm-3">{{this.$parent.lg=='en'? 'Button\'s description' :'La description du bouton'}}</label>
                    <input @change="onScanner2Change()" ref="search" @input="countChars2"  v-model="form.scanner2" name="scanner2" type="text" class="form-control col-md-3 col-sm-3" :maxlength="ml2" :class="{ 'is-invalid': form.errors.has('scanner2') }">
                    <has-error :form="form" field="scanner2"></has-error>
                    <label for="" class=" col-md-3 col-sm-3">{{this.$parent.lg=='en'? 'Pole\'s description' :'La description de la connexion '}}</label>
                    <input @change="onScanner3Change()" ref="search2" @input="countChars3" v-model="form.scanner3" name="scanner3" type="text" class="form-control col-md-3 col-sm-3" :maxlength="ml3" :class="{ 'is-invalid': form.errors.has('scanner3') }">
                    <has-error :form="form" field="scanner3"></has-error>
                    </div>
                    <div class="form-group row  justify-content-start">

                    <label for="" class=" col-md-3 col-sm-3">{{this.$parent.lg=='en'? 'Amperage\'s description' :'La description de l\'amperage'}}</label>
                    <input @change="onScanner4Change()" ref="search3" v-model="form.scanner4" name="scanner4" type="text" class="form-control col-md-3 col-sm-3" :maxlength="ml4" :class="{ 'is-invalid': form.errors.has('scanner4') }">
                    <has-error :form="form" field="scanner4"></has-error>
                    <button type="button" style="margin-left:1.5%" :disabled="active1+active2+active3+active4>0" data-toggle="modal" data-target="#myModal" id="for" class="input-group-text pointer col-md-1 col-sm-1 justify-content-center"><i class="fas fa-search ac"></i></button></div>
<input v-model="form.familyIN" type="text" name="family" class="form-control col-md-1 col-sm-1" style="visibility: hidden">
                    </div></div>
<div class="modal fade" id=myModal style="margin-top:10vh">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
<h1>{{this.$parent.lg=='en'? 'Type your confirmaton number' :'Tapez votre numéro de matricule'}}</h1>
</div>
<div class="modal-body row justify-content-around">
<input type="text" v-model="form.nb_matricule" name="nb_matricule" class="form-control col-6" :class="{ 'is-invalid': form.errors.has('nb_matricule') }">
<has-error :form="form" field="nb_matricule"></has-error></div>
<div class="modal-footer ">
<input type="submit" @click="make_requests_handler" value="search"  class="btn btn-primary "/>
<input data-dismiss="modal" value="close" class="btn btn-danger" style="width:68.15px"/>
</div>
</div>
</div>
</div>
                    </form>
                    <table v-if="this.result==true" class="table table-sm">
                  <thead>
                    <tr :key="info.id">
                      <th>{{this.$parent.lg=='en'? 'Button\'s image' :'Image du bouton'}}</th>
                      <th>{{this.$parent.lg=='en'? 'Boitier\'s image' :'Image du Boitier'}}</th>
                      <th>{{this.$parent.lg=='en'? 'Boitier\'s 2nd image' :'2ème image du Boitier'}}</th>
                      <th>{{this.$parent.lg=='en'? 'Connection\'s image' :'Image de la connexion'}}</th>
                      <th>{{this.$parent.lg=='en'? 'Amperage\'s image' :'Image de l\'ampérage'}}</th>
                      <th v-if="this.info.data.image!=null">{{this.$parent.lg=='en'? 'Product\'s image' :'Image du produit'}}</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><img v-bind:src="'/images/buttons/' + this.info.data.button.image"></td>
                      <td><img v-bind:src="'/images/boitiers/' + this.info.data.boitier.image"></td>
                      <td><img v-bind:src="'/images/boitiers/' + this.sec.data.image"></td>
                      <td><img v-bind:src="'/images/connetions/' + this.info.data.pole.image"></td>
                      <td><img v-bind:src="'/images/emperages/' + this.info.data.ampere.image"></td>
                      <td v-if="this.info.data.image!=null"><img v-bind:src="'/images/products/' + this.info.data.image"></td>
                    </tr>
                  </tbody>
                </table>
                <button v-if="this.result==true" @click="back()" class="btn btn-danger">{{this.$parent.lg=='en'? 'Back' :'précédent'}}</button>
                    </div>
              <!-- /.card-body -->
              </div>
            <!-- /.card -->
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data(){
            return{
                message:'',
                sec:{},
                info:{},
                result:false,
                active1:1,
              active2:1,
              active3:1,
              active4:1,
                form:new Form({
                    scanner1:'',
                    scanner2:'',
                    scanner3:'',
                    scanner4:'',
                    nb_matricule:'',
                    family:'',
                    familyIN:'',
                  }),
            ml1:4,
            ml2:4,
            ml3:6,
            ml4:4,
            rc1:4,
            rc2:4,
            rc3:6,
            }
        },
        methods:{
          back(){
            this.result=!this.result;
            this.form.reset();
          },
            onFamily(){
                this.form.familyIN=this.form.family;
            },
            make_requests_handler() {
this.message = 'Requests in progress'
      axios.all([
        this.search(),
        this.search2()
      ])
    .then(axios.spread((first_response, second_response) => {
        this.message = 'Request finished'
          this.info = first_response
          this.result=true
          this.sec =  second_response
          if(!this.info.data.msg){
              swal.fire({
  position: 'top-end',
  icon: 'success',
  title: 'Searching',
  showConfirmButton: false,
  timer: 1000
})
          }
          else{
              swal.fire({
  position: 'top-end',
  icon: 'error',
  title: 'Searching',
  showConfirmButton: false,
  timer: 1000
})
          }
        }))
    },
    search() {
     return this.form.post("/api/home")
    },
    search2() {
      return  this.form.put("/api/home/1")
  },
            onScanner1Change(){
                if(this.form.scanner1.length>0){
              this.active1=0;
                }
                else{
                    this.active1=1;
                }
            },
            onScanner2Change(){
              if(this.form.scanner2.length>0){
              this.active2=0;
                }
                else{
                    this.active2=1;
                }
            },
            onScanner3Change(){
              if(this.form.scanner3.length>0){
              this.active3=0;
                }
                else{
                    this.active3=1;
                }
            },
            onScanner4Change(){
              if(this.form.scanner4.length>0){
              this.active4=0;
                }
                else{
                    this.active4=1;
                }
            },
            onNameChange(){
                this.form.image=this.form.name;
            },
            countChars1(){
      this.rc1 =this.ml1 - this.form.scanner1.length;
      if(this.rc1==0){
          this.$refs.search.focus();
          this.rc1=4;
      }
  },
  countChars2(){
      this.rc2 =this.ml2 - this.form.scanner2.length;
      if(this.rc2==0){
          this.$refs.search2.focus();
          this.rc2=4;
      }
  },
  countChars3(){
      this.rc3 =this.ml3 - this.form.scanner3.length;
      if(this.rc3==0){
          this.$refs.search3.focus();
          this.rc3=6;
      }
  },
        },
        mounted: function () {
  window.setInterval(() => {
    this.onScanner1Change()
    this.onScanner2Change()
    this.onScanner3Change()
    this.onScanner4Change()
  }, 1000)
}
    }
</script>
