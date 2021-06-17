<template>
    <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{this.$parent.lg=='en'? 'Display products' :'Afficher les produits'}}</h3>
                <div class="card-tools">
                    <button class="btn btn-success" @click="newModal" data-toggle="modal" data-target="#addNew">{{this.$parent.lg=='en'? 'Add new Product' :'Ajouter un nouveau produit'}}<i class="fas fa-user-plus fa-fw"></i></button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">

                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <!-- <th>{{this.$parent.lg=='en'? 'Product's image' :'Image du produit'}}</th> -->
                      <th>{{this.$parent.lg=='en'? 'Button\'s image' :'L\'image de l\'bouton'}}</th>
                      <th>{{this.$parent.lg=='en'? 'Boitier\'s image' :'L\'image de l\'boitier'}}</th>
                      <th>{{this.$parent.lg=='en'? 'Connection\'s image' :'L\'image de l\'connexion'}}</th>
                      <th>{{this.$parent.lg=='en'? 'Ampere\'s image' :'L\'image de l\'ampère'}}</th>
                      <th>{{this.$parent.lg=='en'? 'Creation date' :'Date de creation'}}</th>
                      <th>{{this.$parent.lg=='en'? 'Edit & delete' :'Modifier & supprimer'}}</th>

                    </tr>
                  </thead>

                  <tbody>
                    <tr v-for="product in products.data" :key="product.id">
                        <!-- <td><img v-bind:src="'/images/products/' + product.image" ></td> -->
                        <td v-if="product.button!=null"><img v-bind:src="'/images/buttons/' + product.button.image" ></td>
                        <td v-if="product.boitier!=null"><img v-bind:src="'/images/boitiers/' + product.boitier.image" ></td>
                        <td v-if="product.pole!=null"><img v-bind:src="'/images/connetions/' + product.pole.image" ></td>
                        <td v-if="product.ampere!=null"><img v-bind:src="'/images/emperages/' + product.ampere.image" ></td>
                        <td>{{product.created_at |myDate}}</td>
                      <td><a href="#" @click="editModal(product)"><i class="fa fa-edit"></i></a> / <a href="#" @click="deleteProduct(product.id)"><i class="fa fa-trash red"></i></a></td>
                    </tr>

                  </tbody>
                </table>
              </div>
              <div class="card-footer">
                  <pagination style="margin-bottom: 0px;"
 :data="products" @pagination-change-page="getResults"></pagination>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
       <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" v-show="!editmode" id="addNewLabel">{{this.$parent.lg=='en'? 'Add new product' :'Ajouter un produit'}}</h5>
        <h5 class="modal-title" v-show="editmode" id="addNewLabel">{{this.$parent.lg=='en'? 'Update product\'s information' :'Modifier les informations du produit'}}</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form @submit.prevent="editmode ? updateProduct() : createProduct()" >
      <div class="modal-body">
<div class="form-group" style="margin-bottom:0px">
                    <label for="exampleInputFile">{{this.$parent.lg=='en'? 'File input' :'Entrée le fichier'}}</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input @change="onImageChange" name="image" type="file" class="custom-file-input" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile" :value="form.name">{{form.name}}</label>
                      </div>

                    </div>
                  </div>
                        <input v-model="form.name" type="text" name="name"
                             @change="onNameChange" style="height:0px;border:0px;padding:0px" >
                             <div>
<label>{{this.$parent.lg=='en'? 'Choose the button' :'Choisissez le bouton'}}</label>
    <select v-model="form.button" class="form-control"  @change="onButtonChange" for="se1">
        <option disabled value="">{{this.$parent.lg=='en'? 'Choose the button' :'Choisissez le bouton'}}</option>
   <option  v-for="button in buttons" :value="button.id"  v-bind:key="button.id"   >{{button.name}}</option>

  </select>
<input v-model="form.button_id" type="text" name="button" class="form-control" style="visibility: hidden;height:0px">
</div>
<div>
<label>{{this.$parent.lg=='en'? 'Choose the boitier' :'Choisissez le boitier'}}</label>
  <select v-model="form.boitier" class="form-control"   @change="onBoitierChange">
        <option disabled value="">{{this.$parent.lg=='en'? 'Choose the boitier' :'Choisissez le boitier'}}</option>
   <option  :value="boitier.id" v-for="boitier in boitiers"  v-bind:key="boitier.id" >{{boitier.name}}</option>
  </select>
<input  v-model="form.boitier_id" type="text" name="boitier" class="form-control" style="visibility: hidden;height:0px">
</div>
<div>
<label>{{this.$parent.lg=='en'? 'Choose the Connection type' :'Choisissez la connexion'}}</label>
  <select v-model="form.pole" class="form-control"  @change="onPoleChange">
        <option disabled value="">{{this.$parent.lg=='en'? 'Choose the Connection type' :'Choisissez la connexion'}}</option>
   <option :value="pole.id" v-for="pole in poles"  v-bind:key="pole.id" >{{pole.name}}</option>
  </select>
<input  v-model="form.pole_id" type="text" name="pole" class="form-control" style="visibility: hidden;height:0px">
</div>
<div>
<label>{{this.$parent.lg=='en'? 'Choose the amperage' :'Choisissez l\'ampérage'}}</label>

  <select v-model="form.ampere" class="form-control"  @change="onAmpereChange" >
        <option disabled value="">{{this.$parent.lg=='en'? 'Choose the amperage' :'Choisissez l\'ampérage'}}</option>
   <option :value="ampere.id" v-for="ampere in amperes"  v-bind:key="ampere.id" >{{ampere.name}}</option>
  </select>
<input  v-model="form.ampere_id" type="text" name="ampere" class="form-control" style="visibility: hidden;height:0px">
</div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">{{this.$parent.lg=='en'? 'Close' :'Fermer'}}</button>
        <button  @click.prevent="createProduct" v-show="!editmode"  type="submit" class="btn btn-primary">{{this.$parent.lg=='en'? 'Create' :'Créer'}}</button>
        <button  v-show="editmode"   type="submit" class="btn btn-success">{{this.$parent.lg=='en'? 'Update' :'Modifier'}}</button>
      </div>
</form>
    </div>
  </div>
</div>
    </div>
</template>
<script>
    export default {
        data(){
            return{
                id:'',
                ghalt:'',
              editmode:false,
                products:{},
                buttons:{},
                boitiers:{},
                poles:{},
                amperes:{},
                form:new Form({
                  id:'',
                    name:'',
                    image:'',
                    button:'',
                    boitier:'',
                    pole:'',
                    ampere:'',
                    button_id:'',
                    boitier_id:'',
                    pole_id:'',
                    ampere_id:'',
                }),
            }
        },

        methods:{
            getResults(page = 1) {
                        axios.get('api/product?page=' + page)
                            .then(response => {
                                this.products = response.data;
                            });
                },
            onButtonChange(event){
                this.form.button_id=this.form.button;
            },
            onBoitierChange(){
                this.form.boitier_id=this.form.boitier;
            },
            onPoleChange(){
                this.form.pole_id=this.form.pole;
            },
            onAmpereChange(){
                this.form.ampere_id=this.form.ampere;
            },
            onNameChange(){
                this.form.image=this.form.name;
                // if(this.form.name ==null){
                //     this.form.image =null;
                // console.log("function null triggired");
                // }
            },
          onImageChange(e) {
                let file = e.target.files[0] ;
                 var reader = new FileReader();
                 if(file!=null){reader.onloadend = (file) =>{
                    this.form.image = reader.result;
                  }
                   this.form.name = file.name;
                     console.log(reader.readAsDataURL(file)) ;}
            },
          createProduct(file) {
          this.$Progress.start();
                this.form.post('/api/product')
                .then((response)=>{ this.ghalt = response.data;
$('#addNew').modal('hide')
if(this.ghalt.msg1){
           swal.fire(
                                        'Done!',
                                        'Your product has been created.',
                                        'success'
                                        )
    this.$Progress.finish();
}
else if(this.ghalt.msg2){
    this.$Progress.fail();
    swal.fire({
  icon: 'error',
  title: 'Oops...',
  text: 'Product already exists',
  })
}
else if (this.ghalt.msg3){
    this.$Progress.fail();
    swal.fire({
  icon: 'error',
  title: 'Oops...',
  text: 'Some fields are empty',
  })
}
  Fire.$emit('AfterCreated')
})
.catch(()=>{
this.$Progress.fail();
    swal.fire({
  icon: 'error',
  title: 'Oops...',
  text: 'Something wrong',
  })
  Fire.$emit('AfterCreated')
})
          },
            updateProduct(){
            this.$Progress.start();
                this.form.put('/api/product/'+this.form.id)
              .then((response)=>{this.ghalt = response.data;
                                        Fire.$emit('AfterCreated')

                $('#addNew').modal('hide')
if(this.ghalt.msg1){
           swal.fire(
                                        'Done!',
                                        'Your product has been created.',
                                        'success'
                                        )
    this.$Progress.finish();
}
else if(this.ghalt.msg2){
    swal.fire({
  icon: 'error',
  title: 'Oops...',
  text: 'product already exists',
  })
    this.$Progress.fail();
  this.ghalt="";
}
this.ghalt=""
              })
              .catch(()=>{
this.$Progress.fail();
    swal.fire({
  icon: 'error',
  title: 'Oops...',
  text: 'Some fields are empty',
  })
  Fire.$emit('AfterCreated')
})
            },
            editModal(product){
              this.editmode = true;
                this.form.id=product.id;
                $('#addNew').modal('show')
            },
            newModal(){
              this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show')
            },
            loadProducts(){
                    // axios.get("/api/product").then(({ data }) => (this.products = data.data));
                    axios.get("/api/product").then( response  => {this.products=response.data});//this.button=response.data
                        axios.get("/api/button").then(({ data }) => (this.buttons = data.data));
                        axios.get("/api/boitier").then(({ data }) => (this.boitiers = data.data));
                        axios.get("/api/pole").then(({ data }) => (this.poles = data.data));
                        axios.get("/api/ampere").then(({ data }) => (this.amperes = data.data));
            },
            deleteProduct(id){
                swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        // Send request to the server
                         if (result.value) {
                                this.form.delete('/api/product/'+id).then(()=>{
                                        swal.fire(
                                        'Deleted!',
                                        'The product has been deleted.',
                                        'success'
                                        );//this : give us warning
                                        Fire.$emit('AfterCreated');
                                }).catch(()=> {
                                    swal.fire("Failed!", "There was something wronge.", "warning");
                                });
                         }
                    })
            }},
        created() {
            Fire.$on('searching',()=>{
                let query=this.$parent.search;
                axios.get('api/findProduct?q='+query)
                .then((data)=>{
                    this.products=data.data
                })
                .catch(()=>{

                })
            })
            this.loadProducts();
            Fire.$on('AfterCreated',()=>{this.loadProducts();});
}
    }
</script>
