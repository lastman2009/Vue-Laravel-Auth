<template>
    <div>
        <h4 class="text-center">Edit Company</h4>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="updateCompany" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="companyObj.name">
                    </div><br>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" v-model="companyObj.email">
                    </div><br>
                    <div class="form-group">
                        <label>Website</label>
                        <input type="text" class="form-control" v-model="companyObj.website">
                    </div><br>
                    <div class="form-group">
                        <label>Logo</label>
                        <input type="file" ref="image" class="form-control" @change="handleImageChange">
                        <div v-if="image" class="">
                            <img :src="`/${image}`" alt="My Image" style="width: 100px; height: 100px;"/>
                        </div>
                    </div><br>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            companyObj: {},
            selectedImage: null,
            image: null,

        }
    },
    created() {
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get(`/api/companies/${this.$route.params.id}`)
                .then(response => {
                    this.companyObj = response.data;
                    this.setImage(response.data.logo)
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
    },
    methods: {
        setImage(selectedImage){
            if(selectedImage){
                this.image = selectedImage
                this.company.logo = null
            }
        },
        handleImageChange(event) {
            this.selectedImage = event.target.files[0];
        },
        updateCompany() {

            const formDataObj = new FormData();
            
            formDataObj.append('name', this.companyObj.name);
            formDataObj.append('email', this.companyObj.email);
            formDataObj.append('website', this.companyObj.website);
            formDataObj.append("_method", "PUT");
            this.selectedImage ? formDataObj.append('logo', this.selectedImage) :0

            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post(`/api/companies/${this.$route.params.id}`, formDataObj ,{
                    headers: { "content-type": "multipart/form-data" },
                    })
                .then(response => {
                    this.$router.push({name: 'companies'});  
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
