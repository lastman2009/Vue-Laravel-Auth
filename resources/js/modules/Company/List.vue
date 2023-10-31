<template>
    <div>
        <h4 class="text-center">All Companies</h4><br/>
        <button type="button" class="btn btn-info mb-2 float-end" @click="this.$router.push('/company/add')"><i class="fas fa-plus"></i> Add Company</button>
        <Loader v-if="loading" />
        <table class="table table-bordered" v-if="!loading">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Website</th>
                <th>Logo</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="company in companies.data" :key="company.id">
                <td>{{ company.id }}</td>
                <td>{{ company.name }}</td>
                <td>{{ company.email }}</td>
                <td>{{ company.website }}</td>
                <td> <img v-if="company.logo" :src="company.logo" alt="My Image" style="width: 100px; height: 100px;"/></td>
                <td>
                    <div class="btn-group" role="group">
                        <router-link :to="{name: 'editCompany', params: { id: company.id }}" class="btn btn-primary me-1"><i class="fas fa-edit"></i>
                        </router-link>
                        <button class="btn btn-danger" @click="deleteCompany(company.id)"><i class="fas fa-trash"></i></button>
                    </div>
                </td>
            </tr>
            <tr v-if="companies && companies.data && companies.data.length === 0">
                <td class="text-center" colspan="7">No records found</td>
            </tr>
            </tbody>
             <!-- Pagination controls -->
        </table>
        <pagination v-if="!loading && companies" :prev="companies.prev_page_url" :next="companies.next_page_url" @fetchData="fetchPaginatedData"/>
    </div>
</template>

<script>
import Pagination from '../../components/pagination.vue'
export default {
    components:{
        'Pagination' : Pagination,
    },

    data() {
        return {
            companies: [],
            loading :false

        }
    },
    created() {
        this.fetchPaginatedData('/api/companies');
    },

    methods: {
        fetchPaginatedData(url){
            this.loading = true;
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get(url)
                .then(response => {
                    this.companies = response.data;
                    this.loading = false;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
        },
        deleteCompany(id) {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.delete(`/api/companies/${id}`)
                    .then(response => {
                        let i = this.companies.map(item => item.id).indexOf(id); // find index of your object
                        this.companies.splice(i, 1)
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        }
    },
    beforeRouteEnter(to, from, next) {
        let token  = localStorage.getItem('token')
        if (!token) {
            window.location.href = "/";
        }
        next();
    }
}
</script>