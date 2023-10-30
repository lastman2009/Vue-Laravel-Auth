<template>
    <div>
        <h4 class="text-center">Add Company</h4>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="addCompany">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="company.name">
                    </div><br>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" v-model="company.email">
                    </div><br>
                    <div class="form-group">
                        <label>Website</label>
                        <input type="text" class="form-control" v-model="company.website">
                    </div><br>
                    <div class="form-group">
                        <label>Logo</label>
                        <input type="text" class="form-control" v-model="company.logo">
                    </div><br>
                    <button type="submit" class="btn btn-primary">Add Company</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            company: {}
        }
    },
    methods: {
        addCompany() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/company', this.company)
                    .then(response => {
                        this.$router.push({name: 'companies'})
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
