<template>
    <div>
        <h4 class="text-center">All Employee</h4><br/>
        <button type="button" class="btn btn-info mb-2 float-end" @click="this.$router.push('/employee/add')"> <i class="fas fa-plus"></i> Add Employee</button>
        <Loader v-if="loading" />
        <table class="table table-bordered" v-if="!loading">
            <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Company</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="employee in employees.data" :key="employee.id">
                <td>{{ employee.id }}</td>
                <td>{{ employee.first_name }}</td>
                <td>{{ employee.last_name }}</td>
                <td>{{ employee.email }}</td>
                <td>{{ employee.phone }}</td>
                <td>{{ employee.company ? employee.company.name : '-' }}</td>
                <td>
                    <div class="btn-group" role="group">
                        <router-link :to="{name: 'editEmployee', params: { id: employee.id }}" class="btn btn-primary me-1"> <i class="fas fa-edit"></i>
                        </router-link>
                        <button class="btn btn-danger" @click="deleteCompany(company.id)"> <i class="fas fa-trash"></i></button>
                    </div>
                </td>
            </tr>
            <tr v-if="employees && employees.data && employees.data.length === 0">
                <td class="text-center" colspan="7">No records found</td>
            </tr>
            </tbody>
             <!-- Pagination controls -->
        </table>
            <pagination  v-if="!loading && employees" :prev="employees.prev_page_url" :next="employees.next_page_url" @fetchData="fetchPaginatedData"/>
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
            employees: [],
            loading :false
        }
    },
    created() {
        this.fetchPaginatedData('/api/employee');
    },

    methods: {
        fetchPaginatedData(url){
            this.loading = true;
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get(url)
                .then(response => {
                    this.employees = response.data;
                    this.loading = false;

                })
                .catch(function (error) {
                    console.error(error);
                });
        })
        },
        deleteCompany(id) {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.delete(`/api/employee/${id}`)
                    .then(response => {
                        let i = this.employees.map(item => item.id).indexOf(id); // find index of your object
                        this.employees.splice(i, 1)
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