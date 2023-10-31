<template>
    <div>
        <h4 class="text-center">All Employee</h4><br/>
        <button type="button" class="btn btn-info mb-2 float-end" @click="this.$router.push('/employee/add')">Add Employee</button>
        <table class="table table-bordered">
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
                        <router-link :to="{name: 'editEmployee', params: { id: employee.id }}" class="btn btn-primary">Edit
                        </router-link>
                        <button class="btn btn-danger" @click="deleteCompany(company.id)">Delete</button>
                    </div>
                </td>
            </tr>
            <tr v-if="employees.data.length === 0">
                <td class="text-center" colspan="7">No records found</td>
            </tr>
            </tbody>
             <!-- Pagination controls -->
        </table>
        <ul class="pagination float-end">
                    <li @click="fetchPaginatedData(employees.prev_page_url)" :class="{ 'd-none': !employees.prev_page_url }" class="btn btn-info me-2">
                        <a   href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li @click="fetchPaginatedData(employees.next_page_url)" :class="{ 'd-none': !employees.next_page_url }" class="btn btn-info">
                        <a  href="#" aria-label="Next">
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
            employees: []
        }
    },
    created() {
        this.fetchPaginatedData('/api/employee');
    },

    methods: {
        fetchPaginatedData(url){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get(url)
                .then(response => {
                    this.employees = response.data;
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