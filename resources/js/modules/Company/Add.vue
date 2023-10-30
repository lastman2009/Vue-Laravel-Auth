<template>
    <div>
        <h4 class="text-center">Add Company</h4>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="addCompany" enctype="multipart/form-data">
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
                        <input type="file" ref="image" class="form-control" @change="handleImageChange">
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
            company: {},
            selectedImage: null,
        }
    },
    methods: {
        handleImageChange(event) {
            this.selectedImage = event.target.files[0];
        },
        addCompany() {
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
