<template lang="html">

    <div class="tm-tags"data-uk-margin>
    	<ul>
    		<li v-for="(indis , tag) in post"><a @click="remove(indis)">{{tag}}</a></li>
    	</ul>
    </div>

    <div data-uk-margin>
        <div class="uk-form-row">
            <input type="text" list="tagList" class="uk-width-1-1" :placeholder="'Enter Tags' | trans" v-model="input" @keydown.enter.prevent="add">
            <datalist id="tagList">
                <option v-for="tag in tags" v-bind:value="tag">
            </datalist>
        </div>
    </div>

</template>

<script>
export default {
    props:['post' , 'tags'],

    data:{
        input:'',
    },

    methods:{
        remove:function(indis){
            this.post.splice(indis , 1)
        },

        add:function(e){
            e.preventDefault();
            if (this.input) {
                this.post.push(this.input);
                this.input = '';
            }
        }
    }

}
</script>
