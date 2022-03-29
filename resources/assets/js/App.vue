<template>
    <div class="container">
        <div class="navbar">&nbsp;
                      
                <router-link to="/customers" class="btn btn-primary">
                    Customers
                </router-link>

                 <router-link to="/products" class="btn btn-primary">
                    Products
                </router-link>
                 <router-link to="/invoices" class="btn btn-primary">
                    Invoices
                </router-link>

    
        </div>
    
        <div class="content">
            <transition name="fade" mode="out-in">
                <router-view class="page" :key="$route.path"></router-view>
            </transition>

    
        </div>
    </div>
</template>