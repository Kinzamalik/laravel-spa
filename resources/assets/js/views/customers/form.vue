<template>
    <div class="panel" v-if="show">
        <div class="panel-heading">
            <span class="panel-title">{{title}} Customer</span>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
            
                            <label for="">First Name</label>
                            <input type="text" class="form-control"  v-model="form.firstname"/>
                            <br>
                               <label for="">Last Name</label>
                            <input type="text" class="form-control"  v-model="form.lastname"/>
                            <br>
                               <label for="">Email</label>
                            <input type="email" class="form-control"  v-model="form.email"/>
                            <br>
                               <label for="">Address</label>
                            <input type="text" class="form-control"  v-model="form.address"/>
                        <small class="error-control" v-if="errors.customer_id">
                            {{errors.customer_id[0]}}
                        </small>
                    </div>
                </div>
              
            </div>
          
        </div>
        <div class="panel-footer flex-end">
            <div>
                <button class="btn btn-primary" :disabled="isProcessing" @click="onSave">Save</button>
                <button class="btn" :disabled="isProcessing" @click="onCancel">Cancel</button>
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
            'create': `/api/customers/create`,
            'edit': `/api/customers/${to.params.id}/edit`
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
                resource: '/customers',
                store: '/api/customers',
                method: 'POST',
                title: 'Create',
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

                // console.log(this.$data.form.);

                if(this.$route.meta.mode === 'edit') {
                    this.store = `/api/customers/${this.$route.params.id}`
                    this.method = 'PUT'
                    this.title = 'Edit'
                }

                this.show = true
                this.$bar.finish()
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
                        if(res.form && res.form.saved) {
                            this.success(res)
                        }
                    })
                    .catch((error) => {
                        if(error.response.status === 422) {
                            this.errors = error.response.form.errors
                        }
                        this.isProcessing = false
                    })
            },
            success(res) {
                Vue.set(this.$form, 'form', {})
                this.isProcessing = false

                this.$router.push(`${this.resource}/${res.data.id}`)
            }
        }
    }
</script>