<template>
    <div class="panel">
        <div class="panel-heading">
            <span class="panel-title">Products</span>
            <div>
                <router-link to="/products/create" class="btn btn-primary">
                    New Product
                </router-link>
            </div>
        </div>
        <div class="panel-body">
            <table class="table table-link">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product code</th>
                        <th>Description</th>
                        <th>Unit Price</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="product in model.data" :key="product.data" @click="detailsPage(product)">
                        <td class="w-1">{{product.id}}</td>
                        <td class="w-3">{{product.item_code}}</td>
                        <td class="w-3">{{product.description}}</td>
                        <td class="w-9">{{product.unit_price}}</td>
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
                }
            }
        },
        beforeRouteEnter(to, from, next) {
            get('/api/products', to.query)
                .then((res) => {
                    next(vm => vm.setData(res))
                })
        },
        beforeRouteUpdate(to, from, next) {
            get('/api/products', to.query)
                .then((res) => {
                    this.setData(res)
                    next()
                })
        },
        methods: {
            detailsPage(product) {
                this.$router.push(`/products/${product.id}`)
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
                        path: '/products',
                        query: query
                    })
                }
            },
            prevPage () {
                if(this.model.prev_page_url) {
                    const query = Object.assign({}, this.$route.query)
                    query.page = query.page ? (Number(query.page) - 1) : 1

                    this.$router.push({
                        path: '/products',
                        query: query
                    })
                }
            }
        }
    }
</script>