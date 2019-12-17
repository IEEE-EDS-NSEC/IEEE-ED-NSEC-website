<template lang="html">
    <input-image-meta :image.sync="post.data.image" class="pk-image-max-height"></input-image-meta>
</template>

<script>
export default {
    props:['post'],
}
</script>
