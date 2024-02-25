<template>
  <div class="avatar">
    <img :src="imageUrl" :alt="altText" :title="titleText" />
  </div>
</template>

<script>
export default {
  props: {
    imageUrl: {
      type: String,
      required: true
    },
    altText: {
      type: String,
      default: 'Avatar'
    },
    titleText: {
      type: String,
      default: 'Avatar'
    }
  }
}
</script>

<style scoped>
.avatar {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  overflow: hidden;
}

.avatar img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}
</style>
