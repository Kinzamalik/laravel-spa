<template>
    <div class="panel" v-if="show">
        <div class="panel-heading">
            <span class="panel-title">{{title}}Products</span>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label>Product</label>
                        <typeahead :url="customerURL" :initialize="form.customer"
                            @input="onCustomer" />
                        <small class="error-control" v-if="errors.customer_id">
                            {{errors.customer_id[0]}}
                        </small>
                    </div>
                </div>
         
    </div>
</template>
<script type="text/javascript">
    import Vue from 'vue'
    import {get, byMethod } from '../../lib/api'
    import {Typeahead } from '../../components/typeahead'

    function initialize(to) {
        let urls = {
            'create': `/api/products/create`,
            'edit': `/api/products/${to.params.id}/edit`
        }

        return (urls[to.meta.mode] || urls['create'])
    }
    export default {
        components: { Typeahead},
        data () {
            return {
                form: {},
                errors: {},
                isProcessing: false,
                show: false,
                resource: '/products',
                store: '/api/products',
                method: 'POST',
                title: 'Create',
                productURL: '/api/products',
                customerURL: '/api/customers'
            }
        },
        beforeRouteEnter(to, from, next) {
            get(initialize(to))
                .then((res) => {
                    next(vm => vm.setData(res))
                })
        },
        beforeRouteUpdate(to, from, next) {
            this.show = false
            get(initialize(to))
                .then((res) => {
                    this.setData(res)
                    next()
                })
        },
   
        methods: {
            setData(res) {
                Vue.set(this.$data, 'form', res.data.form)

                if(this.$route.meta.mode === 'edit') {
                    this.store = `/api/products/${this.$route.params.id}`
                    this.method = 'PUT'
                    this.title = 'Edit'
                }

                this.show = true
                this.$bar.finish()
            },
            addNewLine() {
                this.form.items.push({
                    product_id: null,
                    product: null,
                    unit_price: 0,
                    qty: 1
                })
            },
            onCustomer(e) {
                const customer = e.target.value
                Vue.set(this.$data.form, 'customer', customer)
                Vue.set(this.$data.form, 'customer_id', customer.id)
            },
            onProduct(index, e) {
                const product = e.target.value
                Vue.set(this.form.items[index], 'product', product)
                Vue.set(this.form.items[index], 'product_id', product.id)

                Vue.set(this.form.items[index], 'unit_price', product.unit_price)
            },
            removeItem(index) {
                this.form.items.splice(index, 1)
            },
            onCancel() {
                if(this.$route.meta.mode === 'edit') {
                    this.$router.push(`${this.resource}/${this.form.id}`)
                } else {
                    this.$router.push(`${this.resource}`)
                }
            },
            onSave() {
                this.errors = {}
                this.isProcessing = true
                byMethod(this.method, this.store, this.form)
                    .then((res) => {
                        if(res.data && res.data.saved) {
                            this.success(res)
                        }
                    })
                    .catch((error) => {
                        if(error.response.status === 422) {
                            this.errors = error.response.data.errors
                        }
                        this.isProcessing = false
                    })
            },
            success(res) {
                this.$router.push(`${this.resource}/${res.data.id}`)
            }
        }
    }
</script>