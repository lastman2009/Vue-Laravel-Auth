<template>
    <div>
        <h4 class="text-center">Add Company</h4>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="addCompany" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="company.name">
                        <div v-if="errors.name" class="error">{{ errors.name[0] }}</div>

                    </div><br>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" v-model="company.email">
                        <div v-if="errors.email" class="error">{{ errors.email[0] }}</div>

                    </div><br>
                    <div class="form-group">
                        <label>Website</label>
                        <input type="text" class="form-control" v-model="company.website">
                        <div v-if="errors.website" class="error">{{ errors.website[0] }}</div>

                    </div><br>
                    <div class="form-group">
                        <label>Logo (100x100)</label>
                        <input type="file" ref="image" class="form-control" @change="handleImageChange">
                        <div v-if="errors.logo" class="error">{{ errors.logo[0] }}</div>

                    </div><br>
                    <button type="submit" class="btn btn-success float-end">Add Company</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            company: {
                name: '',
                email: '',
                website: '',
            },
            selectedImage: '',
            errors: {},
        }   
    },
    methods: {
        handleImageChange(event) {
            this.selectedImage = event.target.files[0];
        },
        addCompany() {
            let _self= this
            const formData = new FormData();
            formData.append('logo', this.selectedImage);
            formData.append('name', this.company.name);
            formData.append('email', this.company.email);
            formData.append('website', this.company.website);

            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/companies', formData ,{
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        },
                    })
                    .then(response => {
                        // this.$router.push({name: 'companies'})
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