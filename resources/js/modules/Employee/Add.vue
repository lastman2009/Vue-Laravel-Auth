<template>
    <div>
        <h4 class="text-center">Add Employee</h4>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="addEmployee" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" class="form-control" v-model="employee.first_name">
                        <div v-if="errors.first_name" class="error">{{ errors.first_name[0] }}</div>
                    </div><br>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" class="form-control" v-model="employee.last_name">
                        <div v-if="errors.last_name" class="error">{{ errors.last_name[0] }}</div>
                    </div><br>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" v-model="employee.email">
                        <div v-if="errors.email" class="error">{{ errors.email[0] }}</div>
                    </div><br>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" class="form-control" v-model="employee.phone">
                        <div v-if="errors.phone" class="error">{{ errors.phone[0] }}</div>
                    </div><br>
                    <div class="form-group">
                        <label for="company">Company</label>
                        <select v-model="employee.company_id" class="form-control" id="company" placeholder="Select Company">
                        <option value="">Select a company</option>
                        <option v-for="company in companies" :key="company.id" :value="company.id">{{ company.name }}</option>
                        </select>
                        <div v-if="errors.company_id" class="error">{{ errors.company_id[0] }}</div>
                    </div>
                  
                    <button type="submit" class="btn btn-success mt-2 float-end">Add Employee</button>
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
            companies: null,
            errors: {},
        }
    },
    created(){
        this.fetchCompanies();
    },
    methods: {
        fetchCompanies(){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.get('/api/employee/create')
                    .then(response => {
                        this.companies = response.data
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        },  
        addEmployee() {
            let _self = this;
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/employee', this.employee)
                    .then(response => {
                        this.$router.push({name: 'employee'})
                    })
                    .catch(function (error) {
                        if (error.response.status === 422) {
                            _self.errors = error.response.data.errors;
                        }
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
<style scoped>
.error{
    color:red;
}
</style>
