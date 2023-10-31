<template>
     <div>
        <h4 class="text-center">Edit Employee</h4>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="updateEmployee" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" class="form-control" v-model="employee.first_name">
                    </div><br>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" class="form-control" v-model="employee.last_name">
                    </div><br>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" v-model="employee.email">
                    </div><br>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" class="form-control" v-model="employee.phone">
                    </div><br>
                    <div class="form-group">
                        <label for="company">Company</label>
                        <select v-model="employee.company_id" class="form-control" id="company" placeholder="Select Company">
                        <option value="">Select a company</option>
                        <option v-for="company in companies" :key="company.id" :value="company.id">{{ company.name }}</option>
                        </select>
                    </div>
                  
                    <button type="submit" class="btn btn-primary mt-2 float-end">Update Employee</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            employee: {},
            companies: {},

        }
    },
    created() {
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get(`/api/employee/${this.$route.params.id}/edit`)
                .then(response => {
                    this.employee = response.data.employee;
                    this.companies = response.data.companies
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
    },
    methods: {
        updateEmployee() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.put(`/api/employee/${this.$route.params.id}`, this.employee)
                .then(response => {
                    this.$router.push({name: 'employee'});  
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
