        <template>
            <div class="panel">
                <div class="panel-heading">
                    <span class="panel-title">Vendors</span>
                    <div>
                        <input type="text" v-model="first_name"  placeholder="First Name" />
                    <button class="btn btn-primary" @click="search">Search</button>
                    </div>
                    
                    <div>
                        <router-link to="/vendors/create" class="btn btn-primary">
                            New Vendor
                        </router-link>
                    </div>
                    
                </div>
                <div class="panel-body">
                    <table class="table table-link">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>FirstName</th>
                                <th>LastName</th>
                                <th>Email</th>
                                <th>Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="vendor in model.data" :key="vendor.data" @click="detailsPage(vendor)">
                                <td class="w-1">{{vendor.id}}</td>
                                <td class="w-3">{{vendor.firstname}}</td>
                                <td class="w-3">{{vendor.lastname}}</td>
                                <td class="w-9">{{vendor.email}}</td>
                                <td class="w-3">{{vendor.address}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="panel-footer flex-between">
                    <div>
                        <small>Showing {{model.from}} - {{model.to}} of {{model.total}}</small>
                    </div>
                    <div>
                        <button class="btn btn-sm" :disabled="!model.prev_page_url" @click="prevPage">
                            Prev
                        </button>
                        <button class="btn btn-sm" :disabled="!model.next_page_url" @click="nextPage">
                            Next
                        </button>
                    </div>
                </div>
            </div>
        </template>
        <script type="text/javascript">
            import Vue from 'vue'
            import { get } from '../../lib/api'
            export default {
                data () {
                    return {
                        model: {
                            data: []

                        },
                        first_name:'',
                    }
                },
                beforeRouteEnter(to, from, next) {
                    get('/api/vendors', to.query)
                        .then((res) => {
                            next(vm => vm.setData(res))
                        })
                },
                beforeRouteUpdate(to, from, next) {
                    get('/api/vendors', to.query)
                        .then((res) => {
                            this.setData(res)
                            next()
                        })
                },
                methods: {
                    detailsPage(vendor) {
                        this.$router.push(`/vendors/${vendor.id}`)
                    },
                    setData(res) {
                        Vue.set(this.$data, 'model', res.data.results)
                        this.page = this.model.current_page
                        this.$bar.finish()
                    },
                    nextPage() {
                        if(this.model.next_page_url) {
                            const query = Object.assign({}, this.$route.query)
                            query.page = query.page ? (Number(query.page) + 1) : 2

                            this.$router.push({
                                path: '/vendors',
                                query: query
                            })
                        }
                    },
                    prevPage () {
                        if(this.model.prev_page_url) {
                            const query = Object.assign({}, this.$route.query)
                            query.page = query.page ? (Number(query.page) - 1) : 1

                            this.$router.push({
                                path: '/vendors',
                                query: query
                            })
                        }
                    },
                search(){
                    console.log(this.first_name);
                }






                    
        }
            }
        </script>