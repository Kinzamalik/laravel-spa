        <template>
            <div class="panel">
                <div class="panel-heading">
                    <span class="panel-title">Customers</span>
                    <div>
                        <input type="text"  v-model="param.q"  placeholder="Search" />
                    <button class="btn btn-primary" @onClick="onSearch" >Search</button>
                    <!-- <span>{{customer.firstname}}</span> -->
                    </div>
                    
                    <div>
                        <router-link to="/customers/create" class="btn btn-primary">
                            New Customer
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
                            <tr v-for="customer in model.data" :key="customer.data" @click="detailsPage(customer)">
                                <td class="w-1">{{customer.id}}</td>
                                <td class="w-3">{{customer.firstname}}</td>
                                <td class="w-3">{{customer.lastname}}</td>
                                <td class="w-9">{{customer.email}}</td>
                                <td class="w-3">{{customer.address}}</td>
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
                         param:{
                             q:'',
                         },
                        }
                    }
                },
                beforeRouteEnter(to, from, next) {
                    get('/api/customers', to.query)
                        .then((res) => {
                            next(vm => vm.setData(res))
                        })
                },
                beforeRouteUpdate(to, from, next) {
                    get('/api/customers', to.query)
                        .then((res) => {
                            this.setData(res)
                            next()
                        })
                },
                methods: {
                    detailsPage(customer) {
                        this.$router.push(`/customers/${customer.id}`)
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
                                path: '/customers',
                                query: query
                            })
                        }
                    },
                    prevPage () {
                        if(this.model.prev_page_url) {
                            const query = Object.assign({}, this.$route.query)
                            query.page = query.page ? (Number(query.page) - 1) : 1

                            this.$router.push({
                                path: '/customers',
                                query: query
                            })
                        }
                    },

                    onsearch: {
                        

                    }
        }
            }
        </script>