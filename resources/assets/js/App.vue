<template>
    <div class="container">
        <div class="navbar">&nbsp;</div>
        <div class="content">
            <transition name="fade" mode="out-in">
                <router-view class="page" :key="$route.path"></router-view>
            </transition>

             <div>
                <router-link to="/api/customers" class="btn btn-primary">
                    Customers
                </router-link>

                 <router-link to="/api/products" class="btn btn-primary">
                    Products
                </router-link>
                 <router-link to="/api/invoices" class="btn btn-primary">
                    Invoices
                </router-link>

            </div>
        </div>
    </div>
</template>