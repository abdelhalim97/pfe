<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{this.$parent.lg=='en'? 'Display orders' :'Afficher les commandes'}}</div>

                    <div class="card-body">
                        <div class="card-body table-responsive p-0">

                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>{{this.$parent.lg=='en'? 'Worker name' :'Nom d\'ouvrier'}}</th>
                      <th>{{this.$parent.lg=='en'? 'Worker matricule' :'№ de matricule'}}</th>
                      <th>{{this.$parent.lg=='en'? 'Description' :'Description'}}</th>
                      <th>{{this.$parent.lg=='en'? 'Order date' :'Date de commande'}}</th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr v-for="order in orders.data" :key="order.id">
                        <td >{{order.id}}</td>
                         <td v-if="order.worker!=null">{{order.worker.full_name}}</td>
                        <td v-if="order.worker!=null">{{order.worker.nb_matricule}}</td>
                        <td>{{order.of}}</td>
                        <td>{{order.created_at |myDate}}</td>
                    </tr>
                  </tbody>
                </table>

              </div><div class="card-footer">
                  <pagination style="margin-bottom: 0px;"
 :data="orders" @pagination-change-page="getResults"></pagination>
              </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                orders:{},
            }
        },
        methods:{
            getResults(page = 1) {
                        axios.get('api/order?page=' + page)
                            .then(response => {
                                this.orders = response.data;

                            });
                },
            loadOrders(){
                    axios.get("/api/order").then((response)=>{this.orders = response.data;
})
            },
           },
        created() {
            Fire.$on('searching',()=>{
                let query=this.$parent.search;
                axios.get('api/findOrder?q='+query)
                .then((data)=>{
                    this.orders=data.data//if q!=null orders=data.data
                })
                .catch(()=>{

                })
            })
            this.loadOrders();
            Fire.$on('AfterCreated',()=>{this.loadOrders();});
}
    }
</script>
