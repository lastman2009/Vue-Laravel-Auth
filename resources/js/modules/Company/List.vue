<template>
    <div>
        <h4 class="text-center">All Companies</h4><br/>
        <button type="button" class="btn btn-info mb-2 float-end" @click="this.$router.push('/company/add')">Add Company</button>
        <table class="table table-bordered">
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
                        <router-link :to="{name: 'editCompany', params: { id: company.id }}" class="btn btn-primary">Edit
                        </router-link>
                        <button class="btn btn-danger" @click="deleteCompany(company.id)">Delete</button>
                    </div>
                </td>
            </tr>
            </tbody>
             <!-- Pagination controls -->
        </table>
        <ul class="pagination float-end">
                    <li :class="{ 'd-none': !companies.prev_page_url }" class="btn btn-info me-2">
                        <a @click="fetchPaginatedData(companies.prev_page_url)" href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li :class="{ 'd-none': !companies.next_page_url }" class="btn btn-info">
                        <a @click="fetchPaginatedData(companies.next_page_url)" href="#" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>

    </div>
</template>

<script>
export default {
    data() {
        return {
            companies: []
        }
    },
    created() {
        this.fetchPaginatedData('/api/companies');
    },

    methods: {
        fetchPaginatedData(url){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get(url)
                .then(response => {
                    this.companies = response.data;
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