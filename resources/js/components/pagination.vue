<template>
   <ul class="pagination float-end" v-if="prev || next">
            <li @click="paginateData(prev)" :class="{ 'disabled': !prev }" class="btn btn-info me-2">
                <a  href="#" aria-label="Previous">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i>
                </a>
            </li>
            <li  @click="paginateData(next)" :class="{ 'disabled': !next }"  class="btn btn-info">
                <a  href="#" aria-label="Next">
                    <i class="fa fa-arrow-right" aria-hidden="true"></i>
                </a>
            </li>
        </ul>
</template>
<script>
export default{
    name: 'pagination',
    props: {
        next: String, 
        prev: String, 
    },
    methods:{
        paginateData(url){
            this.$emit('fetchData', url);
        }
    },  
}
</script>