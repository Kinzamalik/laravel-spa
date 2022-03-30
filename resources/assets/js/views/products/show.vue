<template>
    <div class="panel" v-if="show">
        <div class="panel-heading">
            <span class="panel-title">{{model.number}}</span>
            <div>
                <router-link to="/products" class="btn">Back</router-link>
                <router-link :to="`/products/${model.id}/edit`" class="btn">Edit</router-link>
                <button class="btn btn-error" @click="deleteItem">Delete</button>
            </div>
        </div>
         <div class="panel-body">
            <div class="document">
                <div class="row">
                    <div class="col-6">
                        <strong>To:</strong>
                        <div>
                            <span>{{model.text}}</span>
                            <pre>{{model.address}}</pre>
                        </div>
                    </div>
                    <div class="col-6 col-offset-12">
                        <table class="document-summary">
                            <tbody>
                                <tr>
                                    <td colspan="2">
                                        <span class="document-title">CUSTOMER</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Id</td>
                                    <td>{{model.id}}</td>
                                </tr>
                                <tr>
                                    <td>Product Code</td>
                                    <td>{{model.product_code}}</td>
                                </tr>
                                <tr>
                                    <td>Description</td>
                                    <td>{{model.description}}</td>
                                </tr>
                                <tr>
                                    <td> Unit Price</td>
                                    <td>{{model.unit_price}}</td>
                                </tr>
                                   <tr>
                                    <td>text</td>
                                    <td>{{model.text}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script type="text/javascript">
    import Vue from 'vue'
    import {get, byMethod} from '../../lib/api'
    export default {
        data () {
            return {
                show: false,
                model: {
                    items: [],
                    customer: {}
                }
            }
        },
        beforeRouteEnter(to, from, next) {
            get(`/api/products/${to.params.id}`)
                .then((res) => {
                    next(vm => vm.setData(res))
                })
        },
        beforeRouteUpdate(to, from, next) {
            this.show = false
            get(`/api/products/${to.params.id}`)
                .then((res) => {
                    this.setData(res)
                    next()
                })
        },
        methods: {
            setData(res) {
                Vue.set(this.$data, 'model', res.data.model)
                this.show = true
                this.$bar.finish()
            },
            deleteItem() {
                byMethod('delete', `/api/products/${this.model.id}`)
                    .then((res) => {
                        if(res.data.deleted) {
                            this.$router.push('/products')
                        }
                    })
            }
        }
    }
</script>